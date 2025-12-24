<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsolaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $sql = '';
        $rows = [];
        $columns = [];
        $error = null;
        $message = null;
        $timeMs = null;

        $tables = $this->listTables();
        $history = $request->session()->get('sql_console_history', []);

        return view('configuracion.consola', compact('sql', 'rows', 'columns', 'error', 'message', 'timeMs', 'tables', 'history'));
    }

    protected function isReadOnly(string $sql): bool
    {
        $s = ltrim($sql);
        $s = preg_replace('/^[\(\s]+/', '', $s);
        $upper = strtoupper(substr($s, 0, 10));
        if (str_starts_with($upper, 'SELECT') || str_starts_with($upper, 'SHOW') || str_starts_with($upper, 'DESCRIBE') || str_starts_with($upper, 'EXPLAIN') || str_starts_with($upper, 'WITH')) {
            return true;
        }
        return false;
    }

    protected function hasMultipleStatements(string $sql): bool
    {
        $pos = strpos($sql, ';');
        if ($pos === false) return false;
        if (substr_count($sql, ';') > 1) return true;
        $after = trim(substr($sql, $pos + 1));
        return $after !== '';
    }

    public function execute(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'sql' => ['required', 'string', 'min:1'],
        ], [
            'sql.required' => 'Debes ingresar una consulta SQL',
        ]);

        $sql = trim($validated['sql']);

        if ($this->hasMultipleStatements($sql)) {
            return back()->withErrors(['sql' => 'Solo se permite una sentencia por ejecución'])->withInput();
        }

        if (!$this->isReadOnly($sql)) {
            return back()->withErrors(['sql' => 'Solo se permiten consultas de lectura: SELECT, SHOW, DESCRIBE, EXPLAIN'])->withInput();
        }

        $start = microtime(true);

        try {
            $result = DB::select($sql);
            $timeMs = (int)round((microtime(true) - $start) * 1000);
            $rows = array_map(function ($row) {
                return (array)$row;
            }, $result);
            $columns = count($rows) ? array_keys($rows[0]) : [];

            $history = $request->session()->get('sql_console_history', []);
            $history[] = [
                'sql' => $sql,
                'time_ms' => $timeMs,
                'rows' => count($rows),
                'ts' => now()->toDateTimeString(),
                'status' => 'ok'
            ];
            $history = array_slice($history, -50);
            $request->session()->put('sql_console_history', $history);

            $tables = $this->listTables();
            return view('configuracion.consola', compact('sql', 'rows', 'columns', 'timeMs', 'tables', 'history'));
        } catch (\Throwable $e) {
            $history = $request->session()->get('sql_console_history', []);
            $history[] = [
                'sql' => $sql,
                'time_ms' => 0,
                'rows' => 0,
                'ts' => now()->toDateTimeString(),
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
            $history = array_slice($history, -50);
            $request->session()->put('sql_console_history', $history);

            return back()->withErrors(['sql' => $e->getMessage()])->withInput();
        }
    }

    protected function listTables(): array
    {
        try {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                $rows = DB::select('SHOW TABLES');
                if (!$rows) return [];
                $first = (array)$rows[0];
                $key = array_key_first($first);
                return array_values(array_map(function ($r) use ($key) {
                    $arr = (array)$r;
                    return $arr[$key] ?? null;
                }, $rows));
            } elseif ($driver === 'pgsql') {
                $rows = DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname NOT IN ('pg_catalog', 'information_schema')");
                return array_values(array_map(function ($r) {
                    return $r->tablename ?? null;
                }, $rows));
            } elseif ($driver === 'sqlite') {
                $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                return array_values(array_map(function ($r) {
                    return $r->name ?? null;
                }, $rows));
            } elseif ($driver === 'sqlsrv') {
                $rows = DB::select("SELECT TABLE_SCHEMA + '.' + TABLE_NAME AS name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
                return array_values(array_map(function ($r) {
                    return $r->name ?? null;
                }, $rows));
            }
        } catch (\Throwable $e) {
        }

        return [];
    }

    public function columns(Request $request)
    {
        if (!$request->session()->get('authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $table = $request->query('table');
        if (!$table || !is_string($table)) {
            return response()->json(['error' => 'Tabla requerida'], 400);
        }

        $tables = $this->listTables();
        if (!in_array($table, $tables, true)) {
            return response()->json(['error' => 'Tabla no válida'], 400);
        }

        try {
            $driver = DB::getDriverName();
            $columns = [];
            if ($driver === 'mysql') {
                $safe = str_replace('`', '``', $table);
                $rows = DB::select("SHOW FULL COLUMNS FROM `{$safe}`");
                foreach ($rows as $r) {
                    $arr = (array)$r;
                    $columns[] = [
                        'name' => $arr['Field'] ?? '',
                        'type' => $arr['Type'] ?? '',
                        'nullable' => ($arr['Null'] ?? '') === 'YES',
                        'default' => $arr['Default'] ?? null,
                    ];
                }
            } elseif ($driver === 'pgsql') {
                $rows = DB::select('SELECT column_name, data_type, is_nullable, column_default FROM information_schema.columns WHERE table_name = ?', [$table]);
                foreach ($rows as $r) {
                    $columns[] = [
                        'name' => $r->column_name ?? '',
                        'type' => $r->data_type ?? '',
                        'nullable' => ($r->is_nullable ?? '') === 'YES',
                        'default' => $r->column_default ?? null,
                    ];
                }
            } elseif ($driver === 'sqlite') {
                $safe = str_replace("'", "''", $table);
                $rows = DB::select("PRAGMA table_info('{$safe}')");
                foreach ($rows as $r) {
                    $columns[] = [
                        'name' => $r->name ?? '',
                        'type' => $r->type ?? '',
                        'nullable' => ($r->notnull ?? 0) == 0,
                        'default' => $r->dflt_value ?? null,
                    ];
                }
            } elseif ($driver === 'sqlsrv') {
                $parts = explode('.', $table, 2);
                $schema = $parts[0] ?? 'dbo';
                $name = $parts[1] ?? $table;
                $rows = DB::select('SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?', [$schema, $name]);
                foreach ($rows as $r) {
                    $columns[] = [
                        'name' => $r->COLUMN_NAME ?? '',
                        'type' => $r->DATA_TYPE ?? '',
                        'nullable' => ($r->IS_NULLABLE ?? '') === 'YES',
                        'default' => $r->COLUMN_DEFAULT ?? null,
                    ];
                }
            }

            return response()->json(['columns' => $columns]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

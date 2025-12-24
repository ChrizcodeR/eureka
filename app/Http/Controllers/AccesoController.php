<?php

namespace App\Http\Controllers;

use App\Models\OdooAcceso;
use App\Models\CorreoAcceso;
use App\Models\AddiAcceso;
use App\Models\SistecreditoAcceso;
use App\Models\EsmioAcceso;
use App\Models\SumaspayAcceso;
use App\Exports\AccesosTemplateExport;
use App\Imports\AccesosImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class AccesoController extends Controller
{
    /**
     * Obtiene el modelo según la plataforma
     */
    private function getModel($plataforma)
    {
        return match(strtoupper($plataforma)) {
            'ODOO' => new OdooAcceso(),
            'CORREO' => new CorreoAcceso(),
            'ADDI' => new AddiAcceso(),
            'SISTECREDITO' => new SistecreditoAcceso(),
            'ESMIO' => new EsmioAcceso(),
            'SUMASPAY' => new SumaspayAcceso(),
            default => null,
        };
    }

    /**
     * Obtiene el modelo por nombre de clase
     */
    private function getModelClass($plataforma)
    {
        return match(strtoupper($plataforma)) {
            'ODOO' => OdooAcceso::class,
            'CORREO' => CorreoAcceso::class,
            'ADDI' => AddiAcceso::class,
            'SISTECREDITO' => SistecreditoAcceso::class,
            'ESMIO' => EsmioAcceso::class,
            'SUMASPAY' => SumaspayAcceso::class,
            default => null,
        };
    }

    /**
     * Muestra la lista de accesos de todas las plataformas
     */
    public function index(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $search = $request->get('search', '');
        $filterUrl = $request->get('filter_url', '');
        $filterUser = $request->get('filter_user', '');
        $filterFechaDesde = $request->get('filter_fecha_desde', '');
        $filterFechaHasta = $request->get('filter_fecha_hasta', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $perPage = $request->get('per_page', 10);

        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return redirect()->route('accesos.index', ['plataforma' => 'ODOO'])
                ->with('error', 'Plataforma no válida');
        }

        $query = $modelClass::query();

        // Búsqueda general
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('user', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        // Filtro por URL
        if (!empty($filterUrl)) {
            $query->where('url', 'like', "%{$filterUrl}%");
        }

        // Filtro por Usuario
        if (!empty($filterUser)) {
            $query->where('user', 'like', "%{$filterUser}%");
        }

        // Filtro por fecha desde
        if (!empty($filterFechaDesde)) {
            $query->whereDate('created_at', '>=', $filterFechaDesde);
        }

        // Filtro por fecha hasta
        if (!empty($filterFechaHasta)) {
            $query->whereDate('created_at', '<=', $filterFechaHasta);
        }

        // Validar y aplicar ordenamiento
        $allowedSorts = ['url', 'user', 'created_at', 'updated_at'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';
        
        $query->orderBy($sortBy, $sortOrder);

        // Validar per_page
        $perPage = in_array($perPage, [5, 10, 25, 50, 100]) ? (int)$perPage : 10;

        // Paginar resultados
        $accesos = $query->paginate($perPage)->withQueryString();

        $plataformas = ['ODOO', 'CORREO', 'ADDI', 'SISTECREDITO', 'ESMIO', 'SUMASPAY'];

        return view('accesos.index', compact(
            'accesos', 
            'search', 
            'filterUrl',
            'filterUser',
            'filterFechaDesde',
            'filterFechaHasta',
            'sortBy',
            'sortOrder',
            'perPage', 
            'plataforma', 
            'plataformas'
        ));
    }

    /**
     * Muestra el formulario para crear un nuevo acceso
     * (Ya no se usa, se maneja con modal, pero se mantiene por compatibilidad)
     */
    public function create(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        // Redirigir al index con el modal (se maneja desde el frontend)
        return redirect()->route('accesos.index', ['plataforma' => $request->get('plataforma', 'ODOO')]);
    }

    /**
     * Almacena un nuevo acceso
     */
    public function store(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $request->validate([
            'plataforma' => 'required|string|in:ODOO,CORREO,ADDI,SISTECREDITO,ESMIO,SUMASPAY',
            'url' => 'nullable|url|max:500',
            'user' => 'required|string|max:255',
            'password' => 'required|string',
        ], [
            'plataforma.required' => 'La plataforma es obligatoria',
            'plataforma.in' => 'La plataforma no es válida',
            'url.url' => 'La URL debe ser válida',
            'user.required' => 'El usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        $modelClass = $this->getModelClass($request->plataforma);
        
        if (!$modelClass) {
            return redirect()->route('accesos.index')
                ->with('error', 'Plataforma no válida');
        }

        $modelClass::create([
            'plataforma' => strtoupper($request->plataforma),
            'url' => $request->url,
            'user' => $request->user,
            'password' => Crypt::encryptString($request->password),
        ]);

        return redirect()->route('accesos.index', ['plataforma' => $request->plataforma])
            ->with('success', 'Acceso creado exitosamente');
    }

    /**
     * Muestra el formulario para editar un acceso
     */
    public function edit(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return redirect()->route('accesos.index')
                ->with('error', 'Plataforma no válida');
        }

        $acceso = $modelClass::findOrFail($id);
        
        // Desencriptar la contraseña para mostrarla en el formulario
        try {
            $acceso->password_decrypted = Crypt::decryptString($acceso->password);
        } catch (\Exception $e) {
            $acceso->password_decrypted = '';
        }

        $plataformas = ['ODOO', 'CORREO', 'ADDI', 'SISTECREDITO', 'ESMIO', 'SUMASPAY'];

        return view('accesos.edit', compact('acceso', 'plataforma', 'plataformas'));
    }

    /**
     * Actualiza un acceso existente
     */
    public function update(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return redirect()->route('accesos.index')
                ->with('error', 'Plataforma no válida');
        }

        $acceso = $modelClass::findOrFail($id);

        $request->validate([
            'url' => 'nullable|url|max:500',
            'user' => 'required|string|max:255',
            'password' => 'required|string',
        ], [
            'url.url' => 'La URL debe ser válida',
            'user.required' => 'El usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        $acceso->update([
            'url' => $request->url,
            'user' => $request->user,
            'password' => Crypt::encryptString($request->password),
        ]);

        return redirect()->route('accesos.index', ['plataforma' => $plataforma])
            ->with('success', 'Acceso actualizado exitosamente');
    }

    /**
     * Elimina un acceso
     */
    public function destroy(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return response()->json(['success' => false, 'message' => 'Plataforma no válida'], 400);
        }

        $acceso = $modelClass::findOrFail($id);
        $acceso->delete();

        return response()->json([
            'success' => true,
            'message' => 'Acceso eliminado exitosamente'
        ]);
    }

    /**
     * Obtiene la contraseña desencriptada de un acceso (para mostrar)
     */
    public function getPassword(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return response()->json(['success' => false, 'message' => 'Plataforma no válida'], 400);
        }

        $acceso = $modelClass::findOrFail($id);
        
        try {
            $password = Crypt::decryptString($acceso->password);
            return response()->json([
                'success' => true,
                'password' => $password
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desencriptar la contraseña'
            ], 500);
        }
    }

    /**
     * Descarga la plantilla Excel para importar accesos
     */
    public function downloadTemplate(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $filename = 'plantilla_accesos_' . strtolower($plataforma) . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new AccesosTemplateExport($plataforma), $filename);
    }

    /**
     * Importa accesos desde un archivo Excel
     */
    public function import(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $plataforma = $request->get('plataforma', 'ODOO');
        $modelClass = $this->getModelClass($plataforma);
        
        if (!$modelClass) {
            return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                ->with('error', 'Plataforma no válida');
        }

        // Validar archivo
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'archivo.required' => 'Debes seleccionar un archivo',
            'archivo.mimes' => 'El archivo debe ser Excel (.xlsx o .xls)',
            'archivo.max' => 'El archivo no debe superar los 5MB',
        ]);

        try {
            // Validar la plataforma del Excel antes de importar (leer primera fila de datos)
            $reader = Excel::toArray([], $request->file('archivo'));
            if (!empty($reader) && !empty($reader[0])) {
                $plataformaExcel = null;
                $plataformasValidas = ['ODOO', 'CORREO', 'ADDI', 'SISTECREDITO', 'ESMIO', 'SUMASPAY'];
                
                // Buscar en la primera fila de datos (fila 2, índice 1, después del encabezado)
                if (count($reader[0]) > 1) {
                    $primeraFilaDatos = $reader[0][1]; // Segunda fila (después del encabezado)
                    
                    // Buscar la columna plataforma (primera columna generalmente)
                    if (isset($primeraFilaDatos[0])) {
                        $valorColumnaA = strtoupper(trim((string)$primeraFilaDatos[0]));
                        if (in_array($valorColumnaA, $plataformasValidas)) {
                            $plataformaExcel = $valorColumnaA;
                        }
                    }
                    
                    // Si no se encontró en la primera columna, buscar en todas las columnas
                    if (!$plataformaExcel) {
                        foreach ($primeraFilaDatos as $valor) {
                            if (is_string($valor) || is_numeric($valor)) {
                                $valorNormalizado = strtoupper(trim((string)$valor));
                                if (in_array($valorNormalizado, $plataformasValidas)) {
                                    $plataformaExcel = $valorNormalizado;
                                    break;
                                }
                            }
                        }
                    }
                }
                
                // Validar que coincida
                if ($plataformaExcel && $plataformaExcel !== strtoupper($plataforma)) {
                    return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                        ->with('error', "❌ Error de validación: La plataforma en el Excel ('{$plataformaExcel}') no coincide con la plataforma seleccionada ('{$plataforma}'). Por favor, verifica que estés importando el archivo correcto para la plataforma '{$plataforma}'.");
                }
            }

            $import = new AccesosImport($modelClass, $plataforma);
            
            Excel::import($import, $request->file('archivo'));

            // Obtener estadísticas
            $importados = $import->getImportedCount();
            $duplicados = $import->getSkippedCount();
            $errores = $import->getErrorsCount();

            // Mensaje de resultado
            $mensaje = "Importación completada: ";
            $mensaje .= $importados > 0 ? "✅ {$importados} accesos importados. " : "";
            $mensaje .= $duplicados > 0 ? "⚠️ {$duplicados} duplicados omitidos. " : "";
            $mensaje .= $errores > 0 ? "❌ {$errores} errores. " : "";

            if ($importados > 0) {
                return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                    ->with('success', $mensaje)
                    ->with('importados', $importados)
                    ->with('duplicados', $duplicados)
                    ->with('errores', $errores);
            } else {
                return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                    ->with('error', $mensaje . ($errores > 0 ? 'Revisa el formato del archivo.' : 'No se importaron accesos. Verifica que el archivo tenga el formato correcto.'));
            }

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $mensaje = 'Errores de validación en el archivo: ';
            foreach ($failures as $failure) {
                $mensaje .= "Fila {$failure->row()}: " . implode(', ', $failure->errors()) . ' ';
            }
            
            return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                ->with('error', $mensaje);
        } catch (\Exception $e) {
            \Log::error('Error al importar accesos: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Verificar si el error es por plataforma no coincidente
            $mensajeError = $e->getMessage();
            if (strpos($mensajeError, 'no coincide con la plataforma seleccionada') !== false) {
                return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                    ->with('error', $mensajeError);
            }
            
            return redirect()->route('accesos.index', ['plataforma' => $plataforma])
                ->with('error', 'Error al importar el archivo: ' . $mensajeError);
        }
    }
}

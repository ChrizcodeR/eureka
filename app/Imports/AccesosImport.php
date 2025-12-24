<?php

namespace App\Imports;

use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AccesosImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithBatchInserts, WithChunkReading
{
    protected $modelClass;
    protected $plataforma;
    
    public $importados = 0;
    public $duplicados = 0;
    public $errores = 0;
    public $erroresDetalle = [];

    public function __construct($modelClass, $plataforma)
    {
        $this->modelClass = $modelClass;
        $this->plataforma = strtoupper(trim($plataforma));
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Si el array está vacío o solo tiene valores null, retornar null
        if (empty(array_filter($row))) {
            return null;
        }

        // Normalizar las claves del array
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = is_numeric($key) ? $key : strtolower(trim((string)$key));
            $normalizedRow[$normalizedKey] = $value;
        }
        
        // Obtener los datos
        $plataformaExcel = $this->getValue($normalizedRow, ['plataforma', 0]);
        $url = $this->getValue($normalizedRow, ['url', 1]);
        $user = $this->getValue($normalizedRow, ['user', 'usuario', 'username', 2]);
        $password = $this->getValue($normalizedRow, ['password', 'contraseña', 'pass', 3]);

        // Validar que la plataforma del Excel coincida con la del formulario
        if (!empty($plataformaExcel)) {
            $plataformaExcelNormalizada = strtoupper(trim($plataformaExcel));
            
            // Si no coincide, lanzar excepción para detener la importación
            if ($plataformaExcelNormalizada !== $this->plataforma) {
                $this->errores++;
                throw new \Exception("Error en la fila: La plataforma en el Excel ('{$plataformaExcel}') no coincide con la plataforma seleccionada ('{$this->plataforma}'). La importación se ha detenido. Por favor, verifica que estés importando el archivo correcto para la plataforma '{$this->plataforma}'.");
            }
        }

        // Validar campos requeridos
        if (empty($user) || empty($password)) {
            $this->errores++;
            return null;
        }

        // Limpiar y validar
        $url = $url ? trim((string)$url) : null;
        $user = trim((string)$user);
        $password = trim((string)$password);

        // Validar URL si está presente
        if ($url && !filter_var($url, FILTER_VALIDATE_URL)) {
            $this->errores++;
            return null;
        }

        // Validar longitud
        if (strlen($user) > 255) {
            $this->errores++;
            return null;
        }

        if ($url && strlen($url) > 500) {
            $this->errores++;
            return null;
        }

        // Crear instancia del modelo
        try {
            $this->importados++;
            return new $this->modelClass([
                'plataforma' => $this->plataforma,
                'url' => $url,
                'user' => $user,
                'password' => Crypt::encryptString($password),
            ]);
        } catch (\Exception $e) {
            $this->errores++;
            $this->importados--;
            $this->erroresDetalle[] = $e->getMessage();
            return null;
        }
    }

    /**
     * Obtiene un valor del array probando diferentes claves
     */
    private function getValue(array $row, array $keys)
    {
        foreach ($keys as $key) {
            if (is_numeric($key)) {
                if (array_key_exists($key, $row) && !empty($row[$key])) {
                    return $row[$key];
                }
            } else {
                $normalizedKey = strtolower(str_replace([' ', '_'], '', $key));
                foreach ($row as $rowKey => $value) {
                    $normalizedRowKey = strtolower(str_replace([' ', '_'], '', $rowKey));
                    if ($normalizedRowKey === $normalizedKey && !empty($value)) {
                        return $value;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Tamaño del lote para inserción
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Tamaño del chunk para lectura
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Obtener estadísticas
     */
    public function getImportedCount(): int
    {
        return $this->importados;
    }

    public function getSkippedCount(): int
    {
        return $this->duplicados;
    }

    public function getErrorsCount(): int
    {
        return $this->errores;
    }
}


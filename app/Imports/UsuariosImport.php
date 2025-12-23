<?php

namespace App\Imports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsuariosImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithBatchInserts, WithChunkReading
{
    public $importados = 0;
    public $duplicados = 0;
    public $errores = 0;
    public $erroresDetalle = [];

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

        // Normalizar las claves del array (pueden venir con espacios o guiones bajos)
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = is_numeric($key) ? $key : strtolower(trim((string)$key));
            $normalizedRow[$normalizedKey] = $value;
        }
        
        // Intentar obtener los datos de diferentes formas posibles
        $nombreCompleto = $this->getValue($normalizedRow, ['nombre_completo', 'nombre completo', 'nombrecompleto', 0]);
        $numeroCedula = $this->getValue($normalizedRow, ['numero_cedula', 'numero de cedula', 'numerocedula', 'numero_de_cedula', 1]);

        // Si no hay datos válidos, retornar null
        if (empty($nombreCompleto) || empty($numeroCedula)) {
            $this->errores++;
            return null;
        }

        // Limpiar y validar
        $nombreCompleto = trim((string)$nombreCompleto);
        $numeroCedula = trim((string)$numeroCedula);

        // Validar longitud
        if (strlen($nombreCompleto) > 255) {
            $this->errores++;
            return null;
        }

        if (strlen($numeroCedula) > 20) {
            $this->errores++;
            return null;
        }

        // Verificar si ya existe
        if (Usuario::where('numero_cedula', $numeroCedula)->exists()) {
            $this->duplicados++;
            return null;
        }

        // Crear instancia del modelo (Laravel Excel lo guardará automáticamente)
        try {
            $this->importados++;
            return new Usuario([
                'nombre_completo' => mb_strtoupper($nombreCompleto, 'UTF-8'),
                'numero_cedula' => $numeroCedula,
            ]);
        } catch (\Exception $e) {
            $this->errores++;
            $this->importados--; // Revertir contador si falla
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
            // Si es una clave numérica, verificar si existe en el array
            if (is_numeric($key)) {
                if (array_key_exists($key, $row) && !empty($row[$key])) {
                    return $row[$key];
                }
            } else {
                // Para claves de texto, normalizar y buscar
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

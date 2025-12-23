<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Imports\UsuariosImport;
use App\Exports\UsuariosTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios con búsqueda y filtros
     */
    public function index(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        // Obtener parámetros de búsqueda y filtros
        $search = $request->get('search');
        $filterNombre = $request->get('filter_nombre');
        $filterCedula = $request->get('filter_cedula');
        $filterFechaDesde = $request->get('filter_fecha_desde');
        $filterFechaHasta = $request->get('filter_fecha_hasta');
        $filterImagen = $request->get('filter_imagen'); // 'con', 'sin', 'todos'
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $perPage = $request->get('per_page', 10);

        // Construir la consulta optimizada
        $query = Usuario::query();

        // Búsqueda general (nombre o cédula)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('numero_cedula', 'like', "%{$search}%");
            });
        }

        // Filtro por nombre
        if ($filterNombre) {
            $query->where('nombre_completo', 'like', "%{$filterNombre}%");
        }

        // Filtro por cédula
        if ($filterCedula) {
            $query->where('numero_cedula', 'like', "%{$filterCedula}%");
        }

        // Filtro por fecha desde
        if ($filterFechaDesde) {
            $query->whereDate('created_at', '>=', $filterFechaDesde);
        }

        // Filtro por fecha hasta
        if ($filterFechaHasta) {
            $query->whereDate('created_at', '<=', $filterFechaHasta);
        }

        // Filtro por imagen
        if ($filterImagen === 'con') {
            $query->whereNotNull('imagen')->where('imagen', '!=', '');
        } elseif ($filterImagen === 'sin') {
            $query->where(function($q) {
                $q->whereNull('imagen')->orWhere('imagen', '');
            });
        }

        // Validar y aplicar ordenamiento
        $allowedSorts = ['nombre_completo', 'numero_cedula', 'created_at', 'imagen_descargada'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';
        
        $query->orderBy($sortBy, $sortOrder);

        // Validar per_page
        $perPage = in_array($perPage, [5, 10, 25, 50, 100]) ? (int)$perPage : 10;

        // Paginar resultados
        $usuarios = $query->paginate($perPage)->withQueryString();

        return view('usuarios', compact(
            'usuarios',
            'search',
            'filterNombre',
            'filterCedula',
            'filterFechaDesde',
            'filterFechaHasta',
            'filterImagen',
            'sortBy',
            'sortOrder',
            'perPage'
        ));
    }

    /**
     * API: Retorna usuarios en formato JSON para actualización en tiempo real
     */
    public function apiIndex(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        // Obtener parámetros
        $search = $request->get('search');
        $filterNombre = $request->get('filter_nombre');
        $filterCedula = $request->get('filter_cedula');
        $filterFechaDesde = $request->get('filter_fecha_desde');
        $filterFechaHasta = $request->get('filter_fecha_hasta');
        $filterImagen = $request->get('filter_imagen');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $perPage = $request->get('per_page', 10);

        // Construir la consulta (misma lógica que index)
        $query = Usuario::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('numero_cedula', 'like', "%{$search}%");
            });
        }

        if ($filterNombre) {
            $query->where('nombre_completo', 'like', "%{$filterNombre}%");
        }

        if ($filterCedula) {
            $query->where('numero_cedula', 'like', "%{$filterCedula}%");
        }

        if ($filterFechaDesde) {
            $query->whereDate('created_at', '>=', $filterFechaDesde);
        }

        if ($filterFechaHasta) {
            $query->whereDate('created_at', '<=', $filterFechaHasta);
        }

        if ($filterImagen === 'con') {
            $query->whereNotNull('imagen')->where('imagen', '!=', '');
        } elseif ($filterImagen === 'sin') {
            $query->where(function($q) {
                $q->whereNull('imagen')->orWhere('imagen', '');
            });
        }

        $allowedSorts = ['nombre_completo', 'numero_cedula', 'created_at', 'imagen_descargada'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'created_at';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'desc';
        
        $query->orderBy($sortBy, $sortOrder);
        $perPage = in_array($perPage, [5, 10, 25, 50, 100]) ? (int)$perPage : 10;

        $usuarios = $query->paginate($perPage)->withQueryString();

        // Formatear datos para JSON
        $data = [
            'usuarios' => $usuarios->map(function($usuario) {
                $imagenUrl = null;
                if ($usuario->imagen && env('FTP_URL')) {
                    $imagenUrl = rtrim(env('FTP_URL'), '/') . '/' . ltrim($usuario->imagen, '/');
                }
                
                return [
                    'id' => $usuario->id,
                    'nombre_completo' => $usuario->nombre_completo,
                    'numero_cedula' => $usuario->numero_cedula,
                    'imagen' => $imagenUrl,
                    'imagen_descargada' => $usuario->imagen_descargada ?? false,
                    'fecha_descarga' => $usuario->fecha_descarga ? $usuario->fecha_descarga->format('d/m/Y H:i') : null,
                    'created_at' => $usuario->created_at->format('d/m/Y H:i'),
                ];
            }),
            'pagination' => [
                'current_page' => $usuarios->currentPage(),
                'last_page' => $usuarios->lastPage(),
                'per_page' => $usuarios->perPage(),
                'total' => $usuarios->total(),
                'from' => $usuarios->firstItem(),
                'to' => $usuarios->lastItem(),
            ],
            'last_update' => now()->toIso8601String(),
        ];

        return response()->json($data);
    }

    /**
     * Almacena un nuevo usuario
     */
    public function store(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        // Validar datos
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'numero_cedula' => 'required|string|unique:usuarios,numero_cedula|max:20',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio',
            'numero_cedula.required' => 'El número de cédula es obligatorio',
            'numero_cedula.unique' => 'Este número de cédula ya está registrado',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser JPEG, PNG, JPG o GIF',
            'imagen.max' => 'La imagen no debe superar los 2MB',
        ]);

        // Manejar la imagen
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $this->uploadImageToFTP($request->file('imagen'), $request->numero_cedula);
        }

        // Crear usuario
        Usuario::create([
            'nombre_completo' => mb_strtoupper($request->nombre_completo, 'UTF-8'),
            'numero_cedula' => $request->numero_cedula,
            'imagen' => $imagenPath,
        ]);

        // Preservar filtros y paginación en la redirección
        $filters = $request->only(['search', 'filter_nombre', 'filter_cedula', 'filter_fecha_desde', 'filter_fecha_hasta', 'filter_imagen', 'sort_by', 'sort_order', 'per_page', 'page']);
        $filters = array_filter($filters); // Eliminar valores vacíos

        return redirect()->route('usuarios.index', $filters)->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Actualiza un usuario existente
     */
    public function update(Request $request, $id)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $usuario = Usuario::findOrFail($id);

        // Validar datos
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'numero_cedula' => 'required|string|max:20|unique:usuarios,numero_cedula,' . $id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio',
            'numero_cedula.required' => 'El número de cédula es obligatorio',
            'numero_cedula.unique' => 'Este número de cédula ya está registrado',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser JPEG, PNG, JPG o GIF',
            'imagen.max' => 'La imagen no debe superar los 2MB',
        ]);

        // Manejar la imagen
        $data = [
            'nombre_completo' => mb_strtoupper($request->nombre_completo, 'UTF-8'),
            'numero_cedula' => $request->numero_cedula,
        ];

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($usuario->imagen) {
                $this->deleteImageFromFTP($usuario->imagen);
            }
            // Subir nueva imagen usando el número de cédula actualizado
            $data['imagen'] = $this->uploadImageToFTP($request->file('imagen'), $request->numero_cedula);
        } elseif ($usuario->imagen && $usuario->numero_cedula !== $request->numero_cedula) {
            // Si cambió el número de cédula pero no la imagen, renombrar la imagen
            $nuevaRuta = $this->renombrarImagenPorCedula($usuario->imagen, $request->numero_cedula);
            if ($nuevaRuta) {
                $data['imagen'] = $nuevaRuta;
            }
        }

        // Actualizar usuario
        $usuario->update($data);

        // Preservar filtros y paginación en la redirección
        $filters = $request->only(['search', 'filter_nombre', 'filter_cedula', 'filter_fecha_desde', 'filter_fecha_hasta', 'filter_imagen', 'sort_by', 'sort_order', 'per_page', 'page']);
        $filters = array_filter($filters); // Eliminar valores vacíos

        return redirect()->route('usuarios.index', $filters)->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario
     */
    public function destroy($id)
    {
        // Verificar autenticación via JSON
        if (!request()->session()->get('authenticated')) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }

        $usuario = Usuario::findOrFail($id);
        
        // Eliminar imagen del FTP si existe
        if ($usuario->imagen) {
            $this->deleteImageFromFTP($usuario->imagen);
        }
        
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }

    /**
     * Importa usuarios desde un archivo Excel
     */
    public function import(Request $request)
    {
        // Verificar autenticación
        if (!$request->session()->get('authenticated')) {
            return redirect()->route('login');
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
            $import = new UsuariosImport();
            
            Excel::import($import, $request->file('archivo'));

            // Obtener estadísticas usando los métodos getter
            $importados = $import->getImportedCount();
            $duplicados = $import->getSkippedCount();
            $errores = $import->getErrorsCount();

            // Mensaje de resultado
            $mensaje = "Importación completada: ";
            $mensaje .= $importados > 0 ? "✅ {$importados} usuarios importados. " : "";
            $mensaje .= $duplicados > 0 ? "⚠️ {$duplicados} duplicados omitidos. " : "";
            $mensaje .= $errores > 0 ? "❌ {$errores} errores. " : "";

            // Preservar filtros y paginación en la redirección
            $filters = $request->only(['search', 'filter_nombre', 'filter_cedula', 'filter_fecha_desde', 'filter_fecha_hasta', 'filter_imagen', 'sort_by', 'sort_order', 'per_page', 'page']);
            $filters = array_filter($filters); // Eliminar valores vacíos

            if ($importados > 0) {
                return redirect()->route('usuarios.index', $filters)
                    ->with('success', $mensaje)
                    ->with('importados', $importados)
                    ->with('duplicados', $duplicados)
                    ->with('errores', $errores);
            } else {
                return redirect()->route('usuarios.index', $filters)
                    ->with('error', $mensaje . ($errores > 0 ? 'Revisa el formato del archivo.' : 'No se importaron usuarios. Verifica que el archivo tenga el formato correcto.'));
            }

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $mensaje = 'Errores de validación en el archivo: ';
            foreach ($failures as $failure) {
                $mensaje .= "Fila {$failure->row()}: " . implode(', ', $failure->errors()) . ' ';
            }
            
            // Preservar filtros y paginación en la redirección
            $filters = $request->only(['search', 'filter_nombre', 'filter_cedula', 'filter_fecha_desde', 'filter_fecha_hasta', 'filter_imagen', 'sort_by', 'sort_order', 'per_page', 'page']);
            $filters = array_filter($filters); // Eliminar valores vacíos
            
            return redirect()->route('usuarios.index', $filters)
                ->with('error', $mensaje);
        } catch (\Exception $e) {
            \Log::error('Error al importar usuarios: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Preservar filtros y paginación en la redirección
            $filters = $request->only(['search', 'filter_nombre', 'filter_cedula', 'filter_fecha_desde', 'filter_fecha_hasta', 'filter_imagen', 'sort_by', 'sort_order', 'per_page', 'page']);
            $filters = array_filter($filters); // Eliminar valores vacíos
            
            return redirect()->route('usuarios.index', $filters)
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage() . '. Por favor, verifica que el archivo tenga el formato correcto.');
        }
    }

    /**
     * Descarga la plantilla Excel para importar usuarios
     */
    public function downloadTemplate()
    {
        // Verificar autenticación
        if (!request()->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        // Nombre del archivo con fecha
        $filename = 'plantilla_usuarios_' . date('Y-m-d') . '.xlsx';

        // Generar y descargar Excel
        return Excel::download(new UsuariosTemplateExport(), $filename);
    }

    /**
     * Sube una imagen al servidor FTP usando el número de cédula como nombre
     */
    private function uploadImageToFTP($file, $numeroCedula)
    {
        try {
            // Limpiar el número de cédula para usarlo como nombre de archivo
            $cedulaLimpia = $this->limpiarNombreArchivo($numeroCedula);
            
            // Obtener la extensión original del archivo
            $extension = $file->getClientOriginalExtension();
            
            // Generar nombre del archivo: usuarios/{cedula}.{extension}
            $fileName = 'usuarios/' . $cedulaLimpia . '.' . $extension;
            
            // Si ya existe una imagen con ese nombre, eliminarla primero
            if (Storage::disk('ftp')->exists($fileName)) {
                Storage::disk('ftp')->delete($fileName);
            }
            
            // Subir al FTP
            Storage::disk('ftp')->put($fileName, file_get_contents($file));
            
            return $fileName;
        } catch (\Exception $e) {
            \Log::error('Error al subir imagen al FTP: ' . $e->getMessage());
            throw new \Exception('Error al subir la imagen: ' . $e->getMessage());
        }
    }

    /**
     * Limpia el número de cédula para usarlo como nombre de archivo seguro
     */
    private function limpiarNombreArchivo($cedula)
    {
        // Eliminar espacios y caracteres especiales
        $cedulaLimpia = preg_replace('/[^a-zA-Z0-9]/', '', $cedula);
        
        // Si después de limpiar está vacío, usar un fallback
        if (empty($cedulaLimpia)) {
            $cedulaLimpia = 'cedula_' . time();
        }
        
        return $cedulaLimpia;
    }

    /**
     * Renombra una imagen existente usando el nuevo número de cédula
     */
    private function renombrarImagenPorCedula($rutaActual, $nuevaCedula)
    {
        try {
            if (!Storage::disk('ftp')->exists($rutaActual)) {
                return null;
            }

            // Obtener la extensión del archivo actual
            $extension = pathinfo($rutaActual, PATHINFO_EXTENSION);
            
            // Limpiar el nuevo número de cédula
            $cedulaLimpia = $this->limpiarNombreArchivo($nuevaCedula);
            
            // Generar nueva ruta
            $nuevaRuta = 'usuarios/' . $cedulaLimpia . '.' . $extension;
            
            // Si la nueva ruta ya existe y es diferente, eliminarla primero
            if ($nuevaRuta !== $rutaActual && Storage::disk('ftp')->exists($nuevaRuta)) {
                Storage::disk('ftp')->delete($nuevaRuta);
            }
            
            // Renombrar el archivo
            if ($nuevaRuta !== $rutaActual) {
                $contenido = Storage::disk('ftp')->get($rutaActual);
                Storage::disk('ftp')->put($nuevaRuta, $contenido);
                Storage::disk('ftp')->delete($rutaActual);
            }
            
            return $nuevaRuta;
        } catch (\Exception $e) {
            \Log::error('Error al renombrar imagen: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Elimina una imagen del servidor FTP
     */
    private function deleteImageFromFTP($path)
    {
        try {
            if (Storage::disk('ftp')->exists($path)) {
                Storage::disk('ftp')->delete($path);
            }
        } catch (\Exception $e) {
            \Log::error('Error al eliminar imagen del FTP: ' . $e->getMessage());
            // No lanzar excepción para no interrumpir el proceso principal
        }
    }

    /**
     * Obtiene la URL de la imagen desde el FTP
     */
    public function getImageUrl($path)
    {
        if (!$path) {
            return null;
        }

        try {
            // Si hay una URL base configurada para el FTP, usarla
            $ftpUrl = env('FTP_URL');
            if ($ftpUrl) {
                return rtrim($ftpUrl, '/') . '/' . ltrim($path, '/');
            }
            
            // Si no hay URL base, intentar obtener la URL del storage
            return Storage::disk('ftp')->url($path);
        } catch (\Exception $e) {
            \Log::error('Error al obtener URL de imagen: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Descarga la imagen de un usuario desde el FTP
     */
    public function downloadImage($id)
    {
        // Verificar autenticación
        if (!request()->session()->get('authenticated')) {
            return redirect()->route('login');
        }

        $usuario = Usuario::findOrFail($id);

        // Verificar que el usuario tenga una imagen
        if (!$usuario->imagen) {
            return redirect()->route('usuarios.index')
                ->with('error', 'Este usuario no tiene una imagen asociada.');
        }

        try {
            // Verificar que la imagen exista en el FTP
            if (!Storage::disk('ftp')->exists($usuario->imagen)) {
                return redirect()->route('usuarios.index')
                    ->with('error', 'La imagen no se encuentra en el servidor FTP.');
            }

            // Obtener el contenido de la imagen
            $contenido = Storage::disk('ftp')->get($usuario->imagen);
            
            // Obtener la extensión del archivo
            $extension = pathinfo($usuario->imagen, PATHINFO_EXTENSION);
            
            // Generar el nombre del archivo para descarga
            $nombreArchivo = $usuario->numero_cedula . '.' . $extension;

            // Retornar la descarga
            return response($contenido)
                ->header('Content-Type', $this->getContentType($extension))
                ->header('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->header('Content-Length', strlen($contenido));

        } catch (\Exception $e) {
            \Log::error('Error al descargar imagen: ' . $e->getMessage());
            return redirect()->route('usuarios.index')
                ->with('error', 'Error al descargar la imagen: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene el Content-Type según la extensión del archivo
     */
    private function getContentType($extension)
    {
        $tipos = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        return $tipos[strtolower($extension)] ?? 'application/octet-stream';
    }

    /**
     * Muestra la interfaz pública de búsqueda por cédula
     */
    public function publicSearch()
    {
        return view('public.search');
    }

    /**
     * Procesa la búsqueda pública por cédula
     */
    public function publicSearchPost(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|max:20',
        ], [
            'cedula.required' => 'Por favor ingresa un número de cédula',
        ]);

        $cedula = trim($request->cedula);
        $usuario = Usuario::where('numero_cedula', $cedula)->first();

        if (!$usuario) {
            return redirect()->route('public.search')
                ->with('error', 'No se encontró ningún usuario con el número de cédula: ' . $cedula)
                ->withInput();
        }

        // Marcar que se realizó una búsqueda
        $usuario->update([
            'busqueda_realizada' => true,
            'fecha_busqueda' => now(),
        ]);

        return view('public.search', compact('usuario', 'cedula'));
    }

    /**
     * Descarga la imagen de un usuario por cédula (público)
     */
    public function publicDownloadImage($cedula)
    {
        $usuario = Usuario::where('numero_cedula', $cedula)->first();

        if (!$usuario) {
            return redirect()->route('public.search')
                ->with('error', 'No se encontró ningún usuario con el número de cédula: ' . $cedula);
        }

        // Verificar que el usuario tenga una imagen
        if (!$usuario->imagen) {
            return redirect()->route('public.search')
                ->with('error', 'Este usuario no tiene una imagen asociada.')
                ->withInput(['cedula' => $cedula]);
        }

        try {
            // Verificar que la imagen exista en el FTP
            if (!Storage::disk('ftp')->exists($usuario->imagen)) {
                return redirect()->route('public.search')
                    ->with('error', 'La imagen no se encuentra en el servidor.')
                    ->withInput(['cedula' => $cedula]);
            }

            // Obtener el contenido de la imagen
            $contenido = Storage::disk('ftp')->get($usuario->imagen);
            
            // Obtener la extensión del archivo
            $extension = pathinfo($usuario->imagen, PATHINFO_EXTENSION);
            
            // Generar el nombre del archivo para descarga
            $nombreArchivo = $usuario->numero_cedula . '.' . $extension;

            // Marcar como descargada y guardar fecha
            $usuario->update([
                'imagen_descargada' => true,
                'fecha_descarga' => now(),
            ]);

            // Retornar la descarga
            return response($contenido)
                ->header('Content-Type', $this->getContentType($extension))
                ->header('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
                ->header('Content-Length', strlen($contenido));

        } catch (\Exception $e) {
            \Log::error('Error al descargar imagen pública: ' . $e->getMessage());
            return redirect()->route('public.search')
                ->with('error', 'Error al descargar la imagen. Por favor intenta nuevamente.')
                ->withInput(['cedula' => $cedula]);
        }
    }

}

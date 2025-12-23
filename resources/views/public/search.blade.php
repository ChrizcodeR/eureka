<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR su+pay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative overflow-hidden min-h-screen">
    <!-- Fondo Boreal Animado -->
    <div class="fixed inset-0 z-0">
        <!-- Gradiente base boreal -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-cyan-50"></div>
        
        <!-- Ondas animadas grandes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-200/40 to-indigo-300/40 rounded-full mix-blend-multiply filter blur-3xl animate-wave-slow"></div>
            <div class="absolute top-40 right-20 w-96 h-96 bg-gradient-to-br from-purple-200/40 to-pink-300/40 rounded-full mix-blend-multiply filter blur-3xl animate-wave-slower"></div>
            <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-gradient-to-br from-cyan-200/40 to-blue-300/40 rounded-full mix-blend-multiply filter blur-3xl animate-wave-reverse"></div>
        </div>
        
        <!-- Partículas flotantes -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400/60 rounded-full animate-float-1"></div>
            <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-indigo-400/60 rounded-full animate-float-2"></div>
            <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-purple-400/60 rounded-full animate-float-3"></div>
            <div class="absolute top-2/3 right-1/3 w-2 h-2 bg-cyan-400/60 rounded-full animate-float-4"></div>
            <div class="absolute bottom-1/3 right-1/5 w-3 h-3 bg-blue-300/60 rounded-full animate-float-5"></div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card Principal -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-[0_-10px_40px_-5px_rgba(0,0,0,0.2),0_20px_60px_-15px_rgba(0,0,0,0.3),0_10px_25px_-5px_rgba(0,0,0,0.2)] p-6">
                <!-- Título -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">
                        QR su+pay
                    </h1>
                    <p class="text-sm text-gray-600">
                        Ingresa tu número de cédula
                    </p>
                </div>

                <!-- Mensajes de Error/Success -->
                @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <!-- Formulario de Búsqueda -->
                <form action="{{ route('public.search.post') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="relative">
                        <input 
                            type="text" 
                            name="cedula"
                            value="{{ old('cedula', $cedula ?? '') }}"
                            placeholder="Número de cédula"
                            required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white transition-all"
                            autofocus
                        >
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full mt-3 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all"
                    >
                        Buscar
                    </button>
                </form>

                <!-- Resultado de la Búsqueda -->
                @if(isset($usuario))
                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Usuario Encontrado</h3>
                        </div>

                        <div class="bg-white rounded-lg p-4 mb-3">
                            <div class="flex items-center space-x-4">
                                <!-- Imagen o Avatar -->
                                <div class="flex-shrink-0">
                                    @if($usuario->imagen)
                                        @php
                                            $imagenUrl = $usuario->imagen;
                                            if (env('FTP_URL')) {
                                                $imagenUrl = rtrim(env('FTP_URL'), '/') . '/' . ltrim($usuario->imagen, '/');
                                            }
                                        @endphp
                                        <img src="{{ $imagenUrl }}" alt="{{ $usuario->nombre_completo }}" class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 shadow-md">
                                    @else
                                        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                                            {{ strtoupper(substr($usuario->nombre_completo, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Información del Usuario -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-gray-900 mb-1 truncate">{{ $usuario->nombre_completo }}</h4>
                                    <p class="text-xs text-gray-600">
                                        Cédula: {{ $usuario->numero_cedula }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de Descarga -->
                        @if($usuario->imagen)
                        <a 
                            href="{{ route('public.downloadImage', $usuario->numero_cedula) }}" 
                            class="block w-full px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all text-center"
                        >
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span>Descargar Imagen</span>
                            </div>
                        </a>
                        @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-yellow-800">
                                Este usuario no tiene una imagen asociada
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 text-gray-500 text-xs">
                <p>© {{ date('Y') }} IT DISTRIFABRICA</p>
            </div>
        </div>
    </div>

    <!-- Animaciones CSS -->
    <style>
        @keyframes wave-slow {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }
        @keyframes wave-slower {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-20px, 20px) scale(1.05); }
        }
        @keyframes wave-reverse {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.08); }
        }
        @keyframes float-1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -30px); }
        }
        @keyframes float-2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-15px, 25px); }
        }
        @keyframes float-3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(25px, 20px); }
        }
        @keyframes float-4 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, -25px); }
        }
        @keyframes float-5 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(15px, 30px); }
        }
        .animate-wave-slow { animation: wave-slow 20s ease-in-out infinite; }
        .animate-wave-slower { animation: wave-slower 25s ease-in-out infinite; }
        .animate-wave-reverse { animation: wave-reverse 18s ease-in-out infinite; }
        .animate-float-1 { animation: float-1 15s ease-in-out infinite; }
        .animate-float-2 { animation: float-2 18s ease-in-out infinite; }
        .animate-float-3 { animation: float-3 20s ease-in-out infinite; }
        .animate-float-4 { animation: float-4 16s ease-in-out infinite; }
        .animate-float-5 { animation: float-5 22s ease-in-out infinite; }
    </style>
</body>
</html>


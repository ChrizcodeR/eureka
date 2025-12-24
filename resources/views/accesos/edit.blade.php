<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Acceso - Eureka</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative">
    <!-- Fondo Boreal Animado -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 via-indigo-50 to-purple-50"></div>
    </div>
    
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-2xl">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Editar Acceso</h1>
                        <p class="text-sm text-gray-500 mt-1">Actualiza las credenciales de la plataforma</p>
                    </div>
                    <a href="{{ route('accesos.index') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            @foreach($errors->all() as $error)
                            <p class="text-red-700 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('accesos.update', ['id' => $acceso->id, 'plataforma' => $plataforma]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="plataforma" value="{{ $plataforma }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Plataforma</label>
                        <input 
                            type="text" 
                            value="{{ $acceso->plataforma }}"
                            disabled
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                        <input 
                            type="url" 
                            name="url" 
                            value="{{ old('url', $acceso->url) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                            placeholder="https://ejemplo.com"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Usuario *</label>
                        <input 
                            type="text" 
                            name="user" 
                            value="{{ old('user', $acceso->user) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                        <input 
                            type="password" 
                            name="password" 
                            value="{{ old('password', $acceso->password_decrypted ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                            placeholder="Ingresa la contraseña"
                        >
                    </div>

                    <div class="flex space-x-3 pt-4">
                        <a href="{{ route('accesos.index') }}" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors text-center">
                            Cancelar
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                            Actualizar Acceso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios del Sistema - Eureka</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative">
    <!-- Fondo Boreal Animado -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 via-indigo-50 to-purple-50"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-blue-200/30 to-cyan-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-1"></div>
            <div class="absolute top-1/3 right-0 w-[500px] h-[500px] bg-gradient-to-br from-indigo-200/30 to-purple-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-2"></div>
            <div class="absolute bottom-0 left-0 w-[550px] h-[550px] bg-gradient-to-br from-purple-200/30 to-pink-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-3"></div>
            <div class="absolute bottom-1/4 right-1/3 w-[450px] h-[450px] bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-4"></div>
        </div>
        <div class="absolute inset-0 opacity-40">
            <div class="absolute top-20 left-20 w-3 h-3 bg-blue-400 rounded-full animate-particle-1"></div>
            <div class="absolute top-40 right-40 w-2 h-2 bg-indigo-400 rounded-full animate-particle-2"></div>
            <div class="absolute top-60 left-1/2 w-2 h-2 bg-purple-400 rounded-full animate-particle-3"></div>
            <div class="absolute bottom-40 right-20 w-3 h-3 bg-cyan-400 rounded-full animate-particle-4"></div>
            <div class="absolute bottom-20 left-1/3 w-2 h-2 bg-blue-300 rounded-full animate-particle-5"></div>
            <div class="absolute top-1/3 right-1/4 w-2 h-2 bg-indigo-300 rounded-full animate-particle-6"></div>
        </div>
    </div>
    
    <div class="flex h-screen overflow-hidden relative z-10">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-between h-20 px-6 border-b border-slate-700/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white font-bold" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="50" cy="50" r="45" fill="currentColor" opacity="0.2"/>
                            <path d="M30 25 L30 75 M30 25 L65 25 M30 50 L55 50 M30 75 L65 75"/>
                            <circle cx="70" cy="30" r="4" fill="currentColor"/>
                            <path d="M70 40 L70 50"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Eureka</span>
                </div>
                <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 border-b border-slate-700/50">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ strtoupper(substr(session('user_nombre') ?? session('user_email') ?? 'AD', 0, 2)) }}
                        </div>
                        <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-400 border-2 border-slate-800 rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ session('user_nombre') ?? 'Administrador' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ session('user_email') ?? 'admin@panel.com' }}</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Usuarios</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuración</p>
                    
                    <a href="{{ route('configuracion.usuarios-sistema.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Usuarios Sistema</span>
                    </a>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ajustes</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-red-500/10 hover:border-l-4 hover:border-red-500 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="font-medium">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
                <div class="flex items-center justify-between h-20 px-6">
                    <div class="flex items-center space-x-4">
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Usuarios del Sistema</h1>
                            <p class="text-sm text-gray-500">Gestión de usuarios administrativos</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="openCreateModal()" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:shadow-lg transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Agregar Usuario</span>
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div id="successMessage" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl animate-slide-down">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div id="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl animate-slide-down">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            @foreach($errors->all() as $error)
                            <p class="text-red-700 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Barra de búsqueda -->
                <div class="mb-6">
                    <form action="{{ route('configuracion.usuarios-sistema.index') }}" method="GET" class="relative max-w-md">
                        <input 
                            type="text" 
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Buscar por nombre o email..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-xl transition-all shadow-sm"
                        >
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <!-- Tabla de usuarios -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Creación</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($usuarios as $usuario)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <p class="font-medium text-gray-900">{{ $usuario->nombre ?? 'Sin nombre' }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-gray-700">{{ $usuario->email }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($usuario->activo)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $usuario->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="editUser({{ $usuario->id }}, '{{ addslashes($usuario->nombre ?? '') }}', '{{ $usuario->email }}', {{ $usuario->activo ? 'true' : 'false' }})" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="confirmDelete({{ $usuario->id }}, '{{ addslashes($usuario->nombre ?? $usuario->email) }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-gray-900 font-medium">No hay usuarios del sistema registrados</p>
                                                <p class="text-gray-500 text-sm">Comienza agregando tu primer usuario</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($usuarios->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $usuarios->firstItem() ?? 0 }}</span> a 
                                <span class="font-semibold">{{ $usuarios->lastItem() ?? 0 }}</span> de 
                                <span class="font-semibold">{{ $usuarios->total() }}</span> resultados
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($usuarios->onFirstPage())
                                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">Anterior</span>
                                @else
                                    <a href="{{ $usuarios->previousPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Anterior</a>
                                @endif

                                @foreach($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
                                    @if($page == $usuarios->currentPage())
                                        <span class="px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($usuarios->hasMorePages())
                                    <a href="{{ $usuarios->nextPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Siguiente</a>
                                @else
                                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">Siguiente</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Modal para Crear Usuario -->
    <div id="createModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Agregar Usuario del Sistema</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('configuracion.usuarios-sistema.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input 
                        type="text" 
                        id="createNombre"
                        name="nombre" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Ej: JUAN PÉREZ"
                        style="text-transform: uppercase;"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="usuario@ejemplo.com"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Mínimo 6 caracteres"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Repite la contraseña"
                    >
                </div>
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="activo" 
                        id="createActivo"
                        value="1"
                        checked
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <label for="createActivo" class="ml-2 text-sm text-gray-700">Usuario activo</label>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeCreateModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Editar Usuario -->
    <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Editar Usuario del Sistema</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editForm" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input 
                        type="text" 
                        id="editNombre"
                        name="nombre" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        style="text-transform: uppercase;"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="editEmail"
                        name="email" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña <span class="text-gray-400 text-xs">(dejar vacío para mantener la actual)</span></label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Mínimo 6 caracteres"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nueva Contraseña</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Repite la contraseña"
                    >
                </div>
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="activo" 
                        id="editActivo"
                        value="1"
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                    >
                    <label for="editActivo" class="ml-2 text-sm text-gray-700">Usuario activo</label>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        openSidebar?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }

        // Convertir nombre a mayúsculas automáticamente
        function setupUppercaseInput(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('input', function() {
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.toUpperCase();
                    this.setSelectionRange(start, end);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupUppercaseInput('createNombre');
            setupUppercaseInput('editNombre');
        });

        // Modal functions - Create
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createModal').classList.remove('flex');
            document.getElementById('createModal').querySelector('form').reset();
        }

        // Modal functions - Edit
        function editUser(id, nombre, email, activo) {
            document.getElementById('editNombre').value = nombre ? nombre.toUpperCase() : '';
            document.getElementById('editEmail').value = email;
            document.getElementById('editActivo').checked = activo;
            document.getElementById('editForm').action = `/configuracion/usuarios-sistema/${id}`;
            
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
            document.getElementById('editForm').reset();
        }

        // Delete function
        function confirmDelete(id, nombre) {
            if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${nombre}"?`)) {
                fetch(`/configuracion/usuarios-sistema/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el usuario');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el usuario');
                });
            }
        }

        // Auto-hide success messages
        setTimeout(() => {
            const successMsg = document.getElementById('successMessage');
            if (successMsg) {
                successMsg.style.transition = 'all 0.5s ease-out';
                successMsg.style.opacity = '0';
                successMsg.style.transform = 'translateY(-20px)';
                setTimeout(() => successMsg.remove(), 500);
            }
        }, 5000);
    </script>

    <style>
        @keyframes wave-1 {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(50px, -50px) scale(1.1) rotate(120deg); }
            66% { transform: translate(-30px, 40px) scale(0.9) rotate(240deg); }
        }
        @keyframes wave-2 {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(-70px, 90px) scale(1.15) rotate(-90deg); }
            66% { transform: translate(80px, -70px) scale(0.85) rotate(-180deg); }
        }
        @keyframes wave-3 {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(360deg); }
            33% { transform: translate(90px, -60px) scale(1.25) rotate(240deg); }
            66% { transform: translate(-70px, 80px) scale(0.95) rotate(120deg); }
        }
        @keyframes wave-4 {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(-90px, -70px) scale(1.1) rotate(150deg); }
            66% { transform: translate(60px, 90px) scale(0.9) rotate(300deg); }
        }
        .animate-wave-1 { animation: wave-1 28s ease-in-out infinite; }
        .animate-wave-2 { animation: wave-2 32s ease-in-out infinite; }
        .animate-wave-3 { animation: wave-3 25s ease-in-out infinite; }
        .animate-wave-4 { animation: wave-4 30s ease-in-out infinite; }
        
        @keyframes particle-1 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; } 50% { transform: translate(120px, -180px) scale(2); opacity: 0.2; } }
        @keyframes particle-2 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; } 50% { transform: translate(-150px, 200px) scale(2.5); opacity: 0.15; } }
        @keyframes particle-3 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.7; } 50% { transform: translate(180px, 120px) scale(2.2); opacity: 0.25; } }
        @keyframes particle-4 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; } 50% { transform: translate(-100px, -150px) scale(1.8); opacity: 0.3; } }
        @keyframes particle-5 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; } 50% { transform: translate(90px, -130px) scale(2.3); opacity: 0.2; } }
        @keyframes particle-6 { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; } 50% { transform: translate(-110px, 160px) scale(2); opacity: 0.25; } }
        
        .animate-particle-1 { animation: particle-1 20s ease-in-out infinite; }
        .animate-particle-2 { animation: particle-2 24s ease-in-out infinite; }
        .animate-particle-3 { animation: particle-3 18s ease-in-out infinite; }
        .animate-particle-4 { animation: particle-4 22s ease-in-out infinite; }
        .animate-particle-5 { animation: particle-5 26s ease-in-out infinite; }
        .animate-particle-6 { animation: particle-6 19s ease-in-out infinite; }

        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-down { animation: slide-down 0.3s ease-out; }
    </style>
</body>
</html>


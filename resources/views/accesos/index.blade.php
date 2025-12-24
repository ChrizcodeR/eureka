<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log de Accesos - Eureka</title>
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
                    <span class="font-medium">Asesores</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuración</p>
                    
                    <a href="{{ route('accesos.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        <span class="font-medium">Log de Accesos</span>
                    </a>

                    <a href="{{ route('configuracion.usuarios-sistema.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
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
                            <h1 class="text-2xl font-bold text-gray-900">Log de Accesos</h1>
                            <p class="text-sm text-gray-500">Gestión de credenciales de plataformas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Selector de Plataforma -->
                        <form action="{{ route('accesos.index') }}" method="GET" class="flex items-center gap-2">
                            <select name="plataforma" onchange="this.form.submit()" class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                                @foreach($plataformas as $plat)
                                    <option value="{{ $plat }}" {{ $plataforma === $plat ? 'selected' : '' }}>{{ $plat }}</option>
                                @endforeach
                            </select>
                        </form>
                        <button onclick="openImportModal()" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg hover:shadow-lg transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span>Importar</span>
                        </button>
                        <button onclick="openCreateModal()" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:shadow-lg transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Agregar Acceso</span>
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

                <!-- Barra de búsqueda y acciones -->
                <div class="mb-6 flex flex-col gap-4">
                    <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                        <div class="relative flex-1 max-w-md">
                            <form action="{{ route('accesos.index') }}" method="GET" id="searchForm">
                                <input type="hidden" name="plataforma" value="{{ $plataforma }}">
                                @if(request('filter_url'))<input type="hidden" name="filter_url" value="{{ request('filter_url') }}">@endif
                                @if(request('filter_user'))<input type="hidden" name="filter_user" value="{{ request('filter_user') }}">@endif
                                @if(request('filter_fecha_desde'))<input type="hidden" name="filter_fecha_desde" value="{{ request('filter_fecha_desde') }}">@endif
                                @if(request('filter_fecha_hasta'))<input type="hidden" name="filter_fecha_hasta" value="{{ request('filter_fecha_hasta') }}">@endif
                                @if(request('sort_by'))<input type="hidden" name="sort_by" value="{{ request('sort_by') }}">@endif
                                @if(request('sort_order'))<input type="hidden" name="sort_order" value="{{ request('sort_order') }}">@endif
                                @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Buscar por usuario o URL..." 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-xl transition-all shadow-sm"
                                >
                                <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </form>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                            <button onclick="toggleFilters()" class="px-4 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-xl font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                <span>Filtros</span>
                            </button>
                            <button onclick="openImportModal()" class="px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                <span>Importar</span>
                            </button>
                            <button onclick="openCreateModal()" class="px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Agregar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Panel de Filtros Avanzados -->
                    <div id="filtersPanel" class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm p-6 hidden">
                        <form action="{{ route('accesos.index') }}" method="GET" id="filtersForm">
                            <input type="hidden" name="plataforma" value="{{ $plataforma }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Filtro por URL -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                                    <input 
                                        type="text" 
                                        name="filter_url"
                                        value="{{ $filterUrl ?? '' }}"
                                        placeholder="Filtrar por URL..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Filtro por Usuario -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                                    <input 
                                        type="text" 
                                        name="filter_user"
                                        value="{{ $filterUser ?? '' }}"
                                        placeholder="Filtrar por usuario..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Filtro por Fecha Desde -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Desde</label>
                                    <input 
                                        type="date" 
                                        name="filter_fecha_desde"
                                        value="{{ $filterFechaDesde ?? '' }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Filtro por Fecha Hasta -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Hasta</label>
                                    <input 
                                        type="date" 
                                        name="filter_fecha_hasta"
                                        value="{{ $filterFechaHasta ?? '' }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Ordenamiento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordenar por</label>
                                    <select name="sort_by" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="created_at" {{ ($sortBy ?? 'created_at') === 'created_at' ? 'selected' : '' }}>Fecha de Creación</option>
                                        <option value="updated_at" {{ ($sortBy ?? '') === 'updated_at' ? 'selected' : '' }}>Fecha de Actualización</option>
                                        <option value="url" {{ ($sortBy ?? '') === 'url' ? 'selected' : '' }}>URL</option>
                                        <option value="user" {{ ($sortBy ?? '') === 'user' ? 'selected' : '' }}>Usuario</option>
                                    </select>
                                </div>

                                <!-- Dirección de Ordenamiento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                                    <select name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Descendente</option>
                                        <option value="asc" {{ ($sortOrder ?? '') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                                    </select>
                                </div>

                                <!-- Selector de Registros por Página -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Registros por Página</label>
                                    <select name="per_page" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="5" {{ ($perPage ?? 10) == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-200">
                                <button type="button" onclick="clearFilters()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Limpiar Filtros</span>
                                </button>
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                                    Aplicar Filtros
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla de accesos -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">
                            Lista de Accesos 
                            <span class="text-sm font-normal text-gray-500">({{ $accesos->total() }} registros)</span>
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">URL</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuario</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Contraseña</th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($accesos as $acceso)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        @if($acceso->url)
                                            <a href="{{ $acceso->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline truncate block max-w-xs">
                                                {{ $acceso->url }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-gray-700">{{ $acceso->user }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <span id="password-{{ $acceso->id }}" class="text-gray-500 font-mono text-sm">••••••••</span>
                                            <button 
                                                onclick="togglePassword({{ $acceso->id }}, '{{ $plataforma }}')" 
                                                class="p-1 text-gray-400 hover:text-indigo-600 transition-colors cursor-pointer"
                                                title="Ver contraseña"
                                                id="eye-btn-{{ $acceso->id }}"
                                            >
                                                <svg id="eye-icon-{{ $acceso->id }}" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('accesos.edit', ['id' => $acceso->id, 'plataforma' => $plataforma]) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button onclick="confirmDelete({{ $acceso->id }}, '{{ $plataforma }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-gray-900 font-medium">No hay accesos registrados</p>
                                                <p class="text-gray-500 text-sm">Comienza agregando tu primer acceso</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($accesos->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $accesos->firstItem() ?? 0 }}</span> a 
                                <span class="font-semibold">{{ $accesos->lastItem() ?? 0 }}</span> de 
                                <span class="font-semibold">{{ $accesos->total() }}</span> resultados
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($accesos->onFirstPage())
                                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">Anterior</span>
                                @else
                                    <a href="{{ $accesos->previousPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Anterior</a>
                                @endif

                                @foreach($accesos->getUrlRange(1, $accesos->lastPage()) as $page => $url)
                                    @if($page == $accesos->currentPage())
                                        <span class="px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($accesos->hasMorePages())
                                    <a href="{{ $accesos->nextPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Siguiente</a>
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

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <!-- Modal para Importar Accesos -->
    <div id="importModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-900">Importar Accesos desde Excel</h3>
                <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('accesos.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="plataforma" value="{{ $plataforma }}">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700 flex-1">
                            <p class="font-semibold mb-1">Formato del archivo Excel:</p>
                            <p class="mb-2">El archivo debe ser Excel (.xlsx) con 4 columnas. Los datos se guardarán en la plataforma: <strong class="text-indigo-600 text-base">{{ $plataforma }}</strong></p>
                            <div class="bg-white p-3 rounded border border-blue-200 text-xs mb-3">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-indigo-500 text-white">
                                            <th class="border border-gray-300 px-2 py-1 text-left">plataforma<br><span class="text-xs font-normal">(solo referencia)</span></th>
                                            <th class="border border-gray-300 px-2 py-1 text-left">url<br><span class="text-xs font-normal">(opcional)</span></th>
                                            <th class="border border-gray-300 px-2 py-1 text-left">user<br><span class="text-xs font-normal">(requerido)</span></th>
                                            <th class="border border-gray-300 px-2 py-1 text-left">password<br><span class="text-xs font-normal">(requerido)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-gray-300 px-2 py-1 bg-gray-50 text-gray-500">{{ $plataforma }}</td>
                                            <td class="border border-gray-300 px-2 py-1">https://ejemplo.com</td>
                                            <td class="border border-gray-300 px-2 py-1">usuario@ejemplo.com</td>
                                            <td class="border border-gray-300 px-2 py-1">MiContraseña123</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-gray-300 px-2 py-1 bg-gray-50 text-gray-500">{{ $plataforma }}</td>
                                            <td class="border border-gray-300 px-2 py-1 text-gray-400">(opcional - puede estar vacío)</td>
                                            <td class="border border-gray-300 px-2 py-1">admin@ejemplo.com</td>
                                            <td class="border border-gray-300 px-2 py-1">AdminPass456</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                                <p class="text-xs text-yellow-800 font-semibold mb-1">📌 Instrucciones importantes:</p>
                                <ul class="text-xs text-yellow-700 space-y-1 list-disc list-inside">
                                    <li>La columna <strong>"plataforma"</strong> es solo informativa. Puedes dejarla como viene o borrarla, <strong>NO afecta dónde se guardan los datos</strong>.</li>
                                    <li>Los datos <strong>SIEMPRE se guardarán en la plataforma seleccionada arriba: {{ $plataforma }}</strong>, sin importar qué pongas en la columna "plataforma" del Excel.</li>
                                    <li>Si estás importando para <strong>CORREO</strong>, los datos irán a la tabla de CORREO aunque el Excel diga "ODOO".</li>
                                    <li>Si estás importando para <strong>ADDI</strong>, los datos irán a la tabla de ADDI aunque el Excel diga otra cosa.</li>
                                    <li>Y así sucesivamente para todas las plataformas (SISTECREDITO, ESMIO, SUMASPAY).</li>
                                </ul>
                            </div>
                            <a href="{{ route('accesos.template', ['plataforma' => $plataforma]) }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg text-sm font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Descargar Plantilla Excel ({{ $plataforma }})</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccionar Archivo Excel
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="archivoImport" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Selecciona un archivo</span>
                                    <input id="archivoImport" name="archivo" type="file" accept=".xlsx,.xls" required class="sr-only" onchange="updateFileName(this)">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel (.xlsx, .xls) hasta 5MB</p>
                            <p id="fileNameImport" class="text-sm text-indigo-600 font-medium mt-2 hidden"></p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeImportModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                        Importar Accesos
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Crear Acceso -->
    <div id="createModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Agregar Nuevo Acceso</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('accesos.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Plataforma *</label>
                    <select 
                        name="plataforma" 
                        id="createPlataforma"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white"
                    >
                        @foreach($plataformas as $plat)
                            <option value="{{ $plat }}" {{ $plataforma === $plat ? 'selected' : '' }}>{{ $plat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                    <input 
                        type="url" 
                        name="url" 
                        id="createUrl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="https://ejemplo.com"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Usuario *</label>
                    <input 
                        type="text" 
                        name="user" 
                        id="createUser"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Nombre de usuario o email"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="createPassword"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Contraseña de acceso"
                    >
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeCreateModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                        Crear Acceso
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        // Filter functions
        function toggleFilters() {
            const panel = document.getElementById('filtersPanel');
            if (panel) {
                panel.classList.toggle('hidden');
            }
        }

        function clearFilters() {
            // Redirigir a la ruta de accesos solo con la plataforma
            const plataforma = '{{ $plataforma }}';
            window.location.href = '{{ route("accesos.index") }}?plataforma=' + plataforma;
        }

        // Modal functions - Import
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
            document.getElementById('importModal').classList.add('flex');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.getElementById('importModal').classList.remove('flex');
            const form = document.getElementById('importModal').querySelector('form');
            if (form) {
                form.reset();
                document.getElementById('fileNameImport').classList.add('hidden');
            }
        }

        function updateFileName(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileNameDisplay = document.getElementById('fileNameImport');
                fileNameDisplay.textContent = fileName;
                fileNameDisplay.classList.remove('hidden');
            }
        }

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

        // Password toggle function
        const passwordTimeouts = {};
        
        function togglePassword(id, plataforma) {
            const passwordSpan = document.getElementById(`password-${id}`);
            const eyeBtn = document.getElementById(`eye-btn-${id}`);
            const eyeIcon = document.getElementById(`eye-icon-${id}`);
            
            // Si ya hay un timeout activo, cancelarlo
            if (passwordTimeouts[id]) {
                clearTimeout(passwordTimeouts[id]);
                delete passwordTimeouts[id];
            }
            
            // Si la contraseña ya está visible, ocultarla
            if (passwordSpan.dataset.visible === 'true') {
                passwordSpan.textContent = '••••••••';
                passwordSpan.dataset.visible = 'false';
                passwordSpan.classList.remove('text-indigo-600', 'font-semibold');
                passwordSpan.classList.add('text-gray-500');
                
                // Restaurar icono de ojo abierto
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
                eyeBtn.classList.remove('text-indigo-600');
                eyeBtn.classList.add('text-gray-400');
                return;
            }
            
            // Deshabilitar el botón mientras se carga
            eyeBtn.disabled = true;
            passwordSpan.textContent = 'Cargando...';
            
            // Hacer petición AJAX para obtener la contraseña
            fetch(`/accesos/${id}/password?plataforma=${plataforma}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                eyeBtn.disabled = false;
                
                if (data.success) {
                    // Mostrar la contraseña
                    passwordSpan.textContent = data.password;
                    passwordSpan.dataset.visible = 'true';
                    passwordSpan.classList.remove('text-gray-500');
                    passwordSpan.classList.add('text-indigo-600', 'font-semibold');
                    
                    // Cambiar icono a ojo cerrado
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    `;
                    eyeBtn.classList.remove('text-gray-400');
                    eyeBtn.classList.add('text-indigo-600');
                    
                    // Ocultar automáticamente después de 7 segundos
                    passwordTimeouts[id] = setTimeout(() => {
                        passwordSpan.textContent = '••••••••';
                        passwordSpan.dataset.visible = 'false';
                        passwordSpan.classList.remove('text-indigo-600', 'font-semibold');
                        passwordSpan.classList.add('text-gray-500');
                        
                        // Restaurar icono de ojo abierto
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        `;
                        eyeBtn.classList.remove('text-indigo-600');
                        eyeBtn.classList.add('text-gray-400');
                        delete passwordTimeouts[id];
                    }, 7000);
                } else {
                    passwordSpan.textContent = '••••••••';
                    alert('Error al obtener la contraseña: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                eyeBtn.disabled = false;
                passwordSpan.textContent = '••••••••';
                console.error('Error:', error);
                alert('Error al obtener la contraseña');
            });
        }

        // Delete function
        function confirmDelete(id, plataforma) {
            if (confirm(`¿Estás seguro de que deseas eliminar este acceso?`)) {
                fetch(`/accesos/${id}?plataforma=${plataforma}`, {
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
                        alert('Error al eliminar el acceso');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el acceso');
                });
            }
        }

        // Cerrar modales al hacer clic fuera
        document.getElementById('createModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });

        document.getElementById('importModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImportModal();
            }
        });

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


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Eureka</title>
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

                <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Usuarios</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuración</p>

                    <a href="{{ route('accesos.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        <span class="font-medium">Log de Accesos</span>
                    </a>

                    <a href="{{ route('configuracion.usuarios-sistema.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Usuarios Sistema</span>
                    </a>
                    <a href="{{ route('configuracion.consola.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v12H4zM8 9h8M8 13h5"></path>
                        </svg>
                        <span class="font-medium">Consola SQL</span>
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
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                Usuarios
                                <span id="refreshIndicator" class="hidden inline-flex items-center gap-1 text-xs font-normal text-indigo-600">
                                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Actualizando...
                                </span>
                            </h1>
                            <p class="text-sm text-gray-500">Gestión de usuarios del sistema</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="manualRefresh" onclick="manualUpdate()" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors flex items-center gap-2" title="Actualizar tabla manualmente">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Actualizar</span>
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">

                <!-- Mensajes de éxito/error -->
                @if(session('success'))
                <div id="successMessage" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl animate-slide-down">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-emerald-700 text-sm font-medium mb-1">{{ session('success') }}</p>
                            @if(session('importados') || session('duplicados') || session('errores'))
                            <div class="mt-2 space-y-1 text-xs text-emerald-600">
                                @if(session('importados'))
                                <p>✅ <strong>{{ session('importados') }}</strong> usuarios importados exitosamente</p>
                                @endif
                                @if(session('duplicados'))
                                <p>⚠️ <strong>{{ session('duplicados') }}</strong> usuarios duplicados omitidos</p>
                                @endif
                                @if(session('errores'))
                                <p>❌ <strong>{{ session('errores') }}</strong> errores encontrados</p>
                                @endif
                            </div>
                            @endif
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
                            <form action="{{ route('usuarios.index') }}" method="GET" id="searchForm">
                                @if(request('filter_nombre'))<input type="hidden" name="filter_nombre" value="{{ request('filter_nombre') }}">@endif
                                @if(request('filter_cedula'))<input type="hidden" name="filter_cedula" value="{{ request('filter_cedula') }}">@endif
                                @if(request('filter_fecha_desde'))<input type="hidden" name="filter_fecha_desde" value="{{ request('filter_fecha_desde') }}">@endif
                                @if(request('filter_fecha_hasta'))<input type="hidden" name="filter_fecha_hasta" value="{{ request('filter_fecha_hasta') }}">@endif
                                @if(request('filter_imagen'))<input type="hidden" name="filter_imagen" value="{{ request('filter_imagen') }}">@endif
                                @if(request('sort_by'))<input type="hidden" name="sort_by" value="{{ request('sort_by') }}">@endif
                                @if(request('sort_order'))<input type="hidden" name="sort_order" value="{{ request('sort_order') }}">@endif
                                @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Buscar por nombre o cédula..."
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
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
                        <form action="{{ route('usuarios.index') }}" method="GET" id="filtersForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Filtro por Nombre -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                    <input
                                        type="text"
                                        name="filter_nombre"
                                        value="{{ $filterNombre ?? '' }}"
                                        placeholder="Filtrar por nombre..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Filtro por Cédula -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Cédula</label>
                                    <input
                                        type="text"
                                        name="filter_cedula"
                                        value="{{ $filterCedula ?? '' }}"
                                        placeholder="Filtrar por cédula..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Filtro por Imagen -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Imagen</label>
                                    <select name="filter_imagen" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="todos" {{ ($filterImagen ?? 'todos') === 'todos' ? 'selected' : '' }}>Todos</option>
                                        <option value="con" {{ ($filterImagen ?? '') === 'con' ? 'selected' : '' }}>Con Imagen</option>
                                        <option value="sin" {{ ($filterImagen ?? '') === 'sin' ? 'selected' : '' }}>Sin Imagen</option>
                                    </select>
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

                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">
                            Lista de Usuarios
                            <span class="text-sm font-normal text-gray-500">({{ $usuarios->total() }} registros)</span>
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <a href="{{ route('usuarios.index', array_merge(request()->all(), ['sort_by' => 'nombre_completo', 'sort_order' => (($sortBy ?? 'created_at') == 'nombre_completo' && ($sortOrder ?? 'desc') == 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center space-x-1 hover:text-indigo-600 transition-colors">
                                            <span>Nombre Completo</span>
                                            @if(($sortBy ?? 'created_at') == 'nombre_completo')
                                                @if(($sortOrder ?? 'desc') == 'asc')
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <a href="{{ route('usuarios.index', array_merge(request()->all(), ['sort_by' => 'numero_cedula', 'sort_order' => (($sortBy ?? 'created_at') == 'numero_cedula' && ($sortOrder ?? 'desc') == 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center space-x-1 hover:text-indigo-600 transition-colors">
                                            <span>Número de Cédula</span>
                                            @if(($sortBy ?? 'created_at') == 'numero_cedula')
                                                @if(($sortOrder ?? 'desc') == 'asc')
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <a href="{{ route('usuarios.index', array_merge(request()->all(), ['sort_by' => 'imagen_descargada', 'sort_order' => (($sortBy ?? 'created_at') == 'imagen_descargada' && ($sortOrder ?? 'desc') == 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center space-x-1 hover:text-indigo-600 transition-colors">
                                            <span>Estado</span>
                                            @if(($sortBy ?? 'created_at') == 'imagen_descargada')
                                                @if(($sortOrder ?? 'desc') == 'asc')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                @endif
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                                </svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($usuarios as $usuario)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            @if($usuario->imagen)
                                                @php
                                                    $imagenUrl = $usuario->imagen;
                                                    if (env('FTP_URL')) {
                                                        $imagenUrl = rtrim(env('FTP_URL'), '/') . '/' . ltrim($usuario->imagen, '/');
                                                    }
                                                @endphp
                                                <img src="{{ $imagenUrl }}" alt="{{ $usuario->nombre_completo }}" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 shadow-lg">
                                            @else
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                                    {{ strtoupper(substr($usuario->nombre_completo, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $usuario->nombre_completo }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">
                                            {{ $usuario->numero_cedula }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($usuario->imagen_descargada)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Completado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="viewUser({{ $usuario->id }}, '{{ addslashes($usuario->nombre_completo) }}', '{{ $usuario->numero_cedula }}', '{{ $usuario->imagen ? (env('FTP_URL') ? rtrim(env('FTP_URL'), '/') . '/' . ltrim($usuario->imagen, '/') : $usuario->imagen) : '' }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Ver">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            @if($usuario->imagen)
                                            <a href="{{ route('usuarios.downloadImage', $usuario->id) }}" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Descargar Imagen" download>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                            </a>
                                            @endif
                                            <button onclick="editUser({{ $usuario->id }}, '{{ addslashes($usuario->nombre_completo) }}', '{{ $usuario->numero_cedula }}', '{{ $usuario->imagen ? (env('FTP_URL') ? rtrim(env('FTP_URL'), '/') . '/' . ltrim($usuario->imagen, '/') : $usuario->imagen) : '' }}')" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="confirmDelete({{ $usuario->id }}, '{{ addslashes($usuario->nombre_completo) }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-gray-900 font-medium">No hay usuarios registrados</p>
                                                <p class="text-gray-500 text-sm">Comienza agregando tu primer usuario</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación Mejorada -->
                    @if($usuarios->hasPages() || $usuarios->total() > 0)
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                Mostrando <span class="font-semibold">{{ $usuarios->firstItem() ?? 0 }}</span> a
                                <span class="font-semibold">{{ $usuarios->lastItem() ?? 0 }}</span> de
                                <span class="font-semibold">{{ $usuarios->total() }}</span> resultados
                                @if($usuarios->total() > 0)
                                    <span class="text-gray-400">(Página {{ $usuarios->currentPage() }} de {{ $usuarios->lastPage() }})</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Primera página -->
                                @if($usuarios->onFirstPage())
                                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $usuarios->url(1) }}" class="px-3 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors" title="Primera página">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                        </svg>
                                    </a>
                                @endif

                                <!-- Página anterior -->
                                @if($usuarios->onFirstPage())
                                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">Anterior</span>
                                @else
                                    <a href="{{ $usuarios->previousPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Anterior</a>
                                @endif

                                <!-- Números de página -->
                                @foreach($usuarios->getUrlRange(max(1, $usuarios->currentPage() - 2), min($usuarios->lastPage(), $usuarios->currentPage() + 2)) as $page => $url)
                                    @if($page == $usuarios->currentPage())
                                        <span class="px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach

                                <!-- Página siguiente -->
                                @if($usuarios->hasMorePages())
                                    <a href="{{ $usuarios->nextPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">Siguiente</a>
                                @else
                                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">Siguiente</span>
                                @endif

                                <!-- Última página -->
                                @if($usuarios->hasMorePages())
                                    <a href="{{ $usuarios->url($usuarios->lastPage()) }}" class="px-3 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors" title="Última página">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
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
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all relative">
            <!-- Loader overlay -->
            <div id="createModalLoader" class="hidden absolute inset-0 bg-white/90 backdrop-blur-sm rounded-2xl z-10 flex items-center justify-center">
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative w-20 h-20">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                            <circle id="createProgressCircle" cx="50" cy="50" r="45" stroke="#6366f1" stroke-width="8" fill="none"
                                    stroke-dasharray="283" stroke-dashoffset="283" stroke-linecap="round"
                                    class="transition-all duration-300"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="createProgressPercent" class="text-lg font-bold text-indigo-600">0%</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Creando usuario...</p>
                </div>
            </div>
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Agregar Nuevo Usuario</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                {{-- Preservar filtros actuales --}}
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('filter_nombre'))<input type="hidden" name="filter_nombre" value="{{ request('filter_nombre') }}">@endif
                @if(request('filter_cedula'))<input type="hidden" name="filter_cedula" value="{{ request('filter_cedula') }}">@endif
                @if(request('filter_fecha_desde'))<input type="hidden" name="filter_fecha_desde" value="{{ request('filter_fecha_desde') }}">@endif
                @if(request('filter_fecha_hasta'))<input type="hidden" name="filter_fecha_hasta" value="{{ request('filter_fecha_hasta') }}">@endif
                @if(request('filter_imagen'))<input type="hidden" name="filter_imagen" value="{{ request('filter_imagen') }}">@endif
                @if(request('sort_by'))<input type="hidden" name="sort_by" value="{{ request('sort_by') }}">@endif
                @if(request('sort_order'))<input type="hidden" name="sort_order" value="{{ request('sort_order') }}">@endif
                @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                @if(request('page'))<input type="hidden" name="page" value="{{ request('page') }}">@endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                    <input
                        type="text"
                        id="createNombre"
                        name="nombre_completo"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Ej: JUAN PÉREZ GARCÍA"
                        style="text-transform: uppercase;"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Cédula</label>
                    <input
                        type="text"
                        name="numero_cedula"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="Ej: 1234567890"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="createImagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Selecciona una imagen</span>
                                    <input id="createImagen" name="imagen" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                            <p id="createImagenName" class="text-sm text-indigo-600 font-medium mt-2 hidden"></p>
                        </div>
                    </div>
                    <div id="createImagenPreview" class="mt-4 hidden">
                        <img id="createImagenPreviewImg" src="" alt="Vista previa" class="mx-auto h-32 w-32 object-cover rounded-xl border-2 border-gray-300">
                    </div>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeCreateModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="createSubmitBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-medium hover:shadow-lg transition-all flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="createSubmitText">Crear Usuario</span>
                        <svg id="createSubmitSpinner" class="hidden w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Importar Usuarios -->
    <div id="importModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Importar Usuarios</h3>
                <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('usuarios.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                {{-- Preservar filtros actuales --}}
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('filter_nombre'))<input type="hidden" name="filter_nombre" value="{{ request('filter_nombre') }}">@endif
                @if(request('filter_cedula'))<input type="hidden" name="filter_cedula" value="{{ request('filter_cedula') }}">@endif
                @if(request('filter_fecha_desde'))<input type="hidden" name="filter_fecha_desde" value="{{ request('filter_fecha_desde') }}">@endif
                @if(request('filter_fecha_hasta'))<input type="hidden" name="filter_fecha_hasta" value="{{ request('filter_fecha_hasta') }}">@endif
                @if(request('filter_imagen'))<input type="hidden" name="filter_imagen" value="{{ request('filter_imagen') }}">@endif
                @if(request('sort_by'))<input type="hidden" name="sort_by" value="{{ request('sort_by') }}">@endif
                @if(request('sort_order'))<input type="hidden" name="sort_order" value="{{ request('sort_order') }}">@endif
                @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                @if(request('page'))<input type="hidden" name="page" value="{{ request('page') }}">@endif
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700 flex-1">
                            <p class="font-semibold mb-1">Formato del archivo Excel:</p>
                            <p class="mb-2">El archivo debe ser Excel (.xlsx) con 2 columnas:</p>
                            <div class="bg-white p-3 rounded border border-blue-200 text-xs mb-3">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-indigo-500 text-white">
                                            <th class="border border-gray-300 px-2 py-1 text-left">nombre_completo</th>
                                            <th class="border border-gray-300 px-2 py-1 text-left">numero_cedula</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-gray-300 px-2 py-1">Juan Pérez García</td>
                                            <td class="border border-gray-300 px-2 py-1">1234567890</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-gray-300 px-2 py-1">María López</td>
                                            <td class="border border-gray-300 px-2 py-1">0987654321</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ route('usuarios.template') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg text-sm font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Descargar Plantilla Excel</span>
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
                                <label for="archivo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Selecciona un archivo</span>
                                    <input id="archivo" name="archivo" type="file" accept=".xlsx,.xls" required class="sr-only">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">Excel (.xlsx, .xls) hasta 5MB</p>
                            <p id="fileName" class="text-sm text-indigo-600 font-medium mt-2 hidden"></p>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeImportModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span>Importar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Ver Usuario -->
    <div id="viewModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Detalles del Usuario</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-center mb-4">
                    <div id="viewAvatar" class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg hidden"></div>
                    <img id="viewImagen" src="" alt="Imagen del usuario" class="w-20 h-20 rounded-full object-cover border-4 border-gray-200 shadow-lg hidden">
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nombre Completo</label>
                    <p id="viewNombre" class="text-gray-900 font-medium"></p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Número de Cédula</label>
                    <p id="viewCedula" class="text-gray-900 font-medium"></p>
                </div>
                <button onclick="closeViewModal()" class="w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Usuario -->
    <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all relative">
            <!-- Loader overlay -->
            <div id="editModalLoader" class="hidden absolute inset-0 bg-white/90 backdrop-blur-sm rounded-2xl z-10 flex items-center justify-center">
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative w-20 h-20">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                            <circle id="editProgressCircle" cx="50" cy="50" r="45" stroke="#10b981" stroke-width="8" fill="none"
                                    stroke-dasharray="283" stroke-dashoffset="283" stroke-linecap="round"
                                    class="transition-all duration-300"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span id="editProgressPercent" class="text-lg font-bold text-emerald-600">0%</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-700">Actualizando usuario...</p>
                </div>
            </div>
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Editar Usuario</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                {{-- Preservar filtros actuales --}}
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('filter_nombre'))<input type="hidden" name="filter_nombre" value="{{ request('filter_nombre') }}">@endif
                @if(request('filter_cedula'))<input type="hidden" name="filter_cedula" value="{{ request('filter_cedula') }}">@endif
                @if(request('filter_fecha_desde'))<input type="hidden" name="filter_fecha_desde" value="{{ request('filter_fecha_desde') }}">@endif
                @if(request('filter_fecha_hasta'))<input type="hidden" name="filter_fecha_hasta" value="{{ request('filter_fecha_hasta') }}">@endif
                @if(request('filter_imagen'))<input type="hidden" name="filter_imagen" value="{{ request('filter_imagen') }}">@endif
                @if(request('sort_by'))<input type="hidden" name="sort_by" value="{{ request('sort_by') }}">@endif
                @if(request('sort_order'))<input type="hidden" name="sort_order" value="{{ request('sort_order') }}">@endif
                @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
                @if(request('page'))<input type="hidden" name="page" value="{{ request('page') }}">@endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                    <input
                        type="text"
                        id="editNombre"
                        name="nombre_completo"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        style="text-transform: uppercase;"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Número de Cédula</label>
                    <input
                        type="text"
                        id="editCedula"
                        name="numero_cedula"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen</label>
                    <div id="editImagenCurrent" class="mb-3 hidden">
                        <p class="text-xs text-gray-500 mb-2">Imagen actual:</p>
                        <img id="editImagenCurrentImg" src="" alt="Imagen actual" class="h-24 w-24 object-cover rounded-lg border-2 border-gray-300">
                    </div>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="editImagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Cambiar imagen</span>
                                    <input id="editImagen" name="imagen" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                            <p id="editImagenName" class="text-sm text-indigo-600 font-medium mt-2 hidden"></p>
                        </div>
                    </div>
                    <div id="editImagenPreview" class="mt-4 hidden">
                        <p class="text-xs text-gray-500 mb-2">Nueva imagen:</p>
                        <img id="editImagenPreviewImg" src="" alt="Vista previa" class="mx-auto h-32 w-32 object-cover rounded-xl border-2 border-gray-300">
                    </div>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="editSubmitBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg transition-all flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="editSubmitText">Guardar Cambios</span>
                        <svg id="editSubmitSpinner" class="hidden w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Confirmar Eliminación -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">¿Eliminar Usuario?</h3>
                <p class="text-gray-600 text-center mb-6">
                    ¿Estás seguro de que deseas eliminar a <strong id="deleteNombre"></strong>? Esta acción no se puede deshacer.
                </p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button onclick="deleteUser()" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                        Eliminar
                    </button>
                </div>
            </div>
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

        // Auto-submit search
        const searchInput = document.querySelector('input[name="search"]');
        let searchTimeout;
        searchInput?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });

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
                // También convertir al pegar
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedText = (e.clipboardData || window.clipboardData).getData('text').toUpperCase();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    this.value = this.value.substring(0, start) + pastedText + this.value.substring(end);
                    const newCursorPos = start + pastedText.length;
                    this.setSelectionRange(newCursorPos, newCursorPos);
                });
            }
        }

        // Aplicar conversión a mayúsculas en los campos de nombre
        document.addEventListener('DOMContentLoaded', function() {
            setupUppercaseInput('createNombre');
            setupUppercaseInput('editNombre');
        });

        // Toggle filters panel
        function toggleFilters() {
            const panel = document.getElementById('filtersPanel');
            if (panel) {
                panel.classList.toggle('hidden');
            }
        }

        // Clear all filters
        function clearFilters() {
            window.location.href = '{{ route("usuarios.index") }}';
        }

        // Actualización manual
        let lastUpdateTime = null;
        let isUpdating = false;

        function manualUpdate() {
            if (isUpdating) return;
            updateTable();
        }

        async function updateTable() {
            if (isUpdating) return;

            try {
                isUpdating = true;
                const indicator = document.getElementById('refreshIndicator');
                const refreshBtn = document.getElementById('manualRefresh');

                if (indicator) indicator.classList.remove('hidden');
                if (refreshBtn) {
                    refreshBtn.disabled = true;
                    refreshBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }

                const params = new URLSearchParams(window.location.search);
                const response = await fetch(`{{ route('usuarios.api') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    isUpdating = false;
                    if (indicator) indicator.classList.add('hidden');
                    if (refreshBtn) {
                        refreshBtn.disabled = false;
                        refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                    return;
                }

                const data = await response.json();

                // Solo actualizar si hay cambios
                if (lastUpdateTime && data.last_update === lastUpdateTime) {
                    isUpdating = false;
                    if (indicator) indicator.classList.add('hidden');
                    if (refreshBtn) {
                        refreshBtn.disabled = false;
                        refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                    return;
                }

                lastUpdateTime = data.last_update;
                renderTable(data.usuarios);
                updatePagination(data.pagination);

                // Efecto visual de actualización
                const tbody = document.querySelector('table tbody');
                if (tbody) {
                    tbody.style.opacity = '0.7';
                    setTimeout(() => {
                        tbody.style.opacity = '1';
                        tbody.style.transition = 'opacity 0.3s ease';
                    }, 100);
                }
            } catch (error) {
                console.error('Error al actualizar tabla:', error);
            } finally {
                isUpdating = false;
                const indicator = document.getElementById('refreshIndicator');
                const refreshBtn = document.getElementById('manualRefresh');

                if (indicator) indicator.classList.add('hidden');
                if (refreshBtn) {
                    refreshBtn.disabled = false;
                    refreshBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        function renderTable(usuarios) {
            const tbody = document.querySelector('table tbody');
            if (!tbody) return;

            tbody.innerHTML = usuarios.map(usuario => {
                const imagenHtml = usuario.imagen
                    ? `<img src="${usuario.imagen}" alt="${usuario.nombre_completo}" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 shadow-lg">`
                    : `<div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">${usuario.nombre_completo.substring(0, 2).toUpperCase()}</div>`;

                const estadoHtml = usuario.imagen_descargada
                    ? `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Completado
                    </span>`
                    : `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Pendiente</span>`;

                const downloadBtn = usuario.imagen
                    ? `<a href="/usuarios/${usuario.id}/descargar-imagen" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Descargar Imagen">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>`
                    : '';

                return `
                    <tr class="hover:bg-gray-50/50 transition-colors animate-slide-down">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3">
                                ${imagenHtml}
                                <div>
                                    <p class="font-medium text-gray-900">${usuario.nombre_completo}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">${usuario.numero_cedula}</span>
                        </td>
                        <td class="py-4 px-6">${estadoHtml}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                <button onclick="viewUser(${usuario.id}, '${usuario.nombre_completo.replace(/'/g, "\\'")}', '${usuario.numero_cedula}', '${usuario.imagen || ''}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Ver">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                ${downloadBtn}
                                <button onclick="editUser(${usuario.id}, '${usuario.nombre_completo.replace(/'/g, "\\'")}', '${usuario.numero_cedula}', '${usuario.imagen || ''}')" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="confirmDelete(${usuario.id}, '${usuario.nombre_completo.replace(/'/g, "\\'")}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            // Si no hay usuarios
            if (usuarios.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-900 font-medium">No hay usuarios registrados</p>
                                    <p class="text-gray-500 text-sm">Comienza agregando tu primer usuario</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        function updatePagination(pagination) {
            // Actualizar información de paginación si es necesario
            const paginationInfo = document.querySelector('.text-sm.text-gray-600');
            if (paginationInfo && pagination.total > 0) {
                paginationInfo.innerHTML = `
                    Mostrando <span class="font-semibold">${pagination.from || 0}</span> a
                    <span class="font-semibold">${pagination.to || 0}</span> de
                    <span class="font-semibold">${pagination.total}</span> resultados
                    <span class="text-gray-400">(Página ${pagination.current_page} de ${pagination.last_page})</span>
                `;
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

        // Modal functions - Create
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');
        }

        // Modal functions - Import
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
            document.getElementById('importModal').classList.add('flex');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.getElementById('importModal').classList.remove('flex');
            // Reset file input
            const fileInput = document.getElementById('archivo');
            if (fileInput) {
                fileInput.value = '';
                document.getElementById('fileName').classList.add('hidden');
            }
        }

        // Show selected file name
        document.getElementById('archivo')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const fileNameElement = document.getElementById('fileName');
            if (fileName) {
                fileNameElement.textContent = '📄 ' + fileName;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        });

        // Modal functions - View
        function viewUser(id, nombre, cedula, imagen) {
            document.getElementById('viewNombre').textContent = nombre;
            document.getElementById('viewCedula').textContent = cedula;

            const viewAvatar = document.getElementById('viewAvatar');
            const viewImagen = document.getElementById('viewImagen');

            if (imagen && imagen.trim() !== '') {
                viewImagen.src = imagen;
                viewImagen.classList.remove('hidden');
                viewAvatar.classList.add('hidden');
            } else {
                viewAvatar.textContent = nombre.substring(0, 2).toUpperCase();
                viewAvatar.classList.remove('hidden');
                viewImagen.classList.add('hidden');
            }

            document.getElementById('viewModal').classList.remove('hidden');
            document.getElementById('viewModal').classList.add('flex');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
            document.getElementById('viewModal').classList.remove('flex');
        }

        // Modal functions - Edit
        function editUser(id, nombre, cedula, imagen) {
            document.getElementById('editNombre').value = nombre.toUpperCase();
            document.getElementById('editCedula').value = cedula;
            document.getElementById('editForm').action = `/usuarios/${id}`;

            const editImagenCurrent = document.getElementById('editImagenCurrent');
            const editImagenCurrentImg = document.getElementById('editImagenCurrentImg');
            const editImagenPreview = document.getElementById('editImagenPreview');
            const editImagen = document.getElementById('editImagen');

            // Reset preview
            editImagenPreview.classList.add('hidden');
            editImagen.value = '';

            // Show current image if exists
            if (imagen && imagen.trim() !== '') {
                editImagenCurrentImg.src = imagen;
                editImagenCurrent.classList.remove('hidden');
            } else {
                editImagenCurrent.classList.add('hidden');
            }

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
            // Reset image preview
            document.getElementById('editImagenPreview').classList.add('hidden');
            document.getElementById('editImagen').value = '';
            // Reset loader
            hideEditLoader();
        }

        // Image preview for create modal
        document.getElementById('createImagen')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('createImagenPreview');
            const previewImg = document.getElementById('createImagenPreviewImg');
            const fileName = document.getElementById('createImagenName');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                fileName.textContent = '📷 ' + file.name;
                fileName.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                fileName.classList.add('hidden');
            }
        });

        // Image preview for edit modal
        document.getElementById('editImagen')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('editImagenPreview');
            const previewImg = document.getElementById('editImagenPreviewImg');
            const fileName = document.getElementById('editImagenName');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                fileName.textContent = '📷 ' + file.name;
                fileName.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
                fileName.classList.add('hidden');
            }
        });

        // Reset create modal on close
        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createModal').classList.remove('flex');
            // Reset form
            document.querySelector('#createModal form').reset();
            document.getElementById('createImagenPreview').classList.add('hidden');
            document.getElementById('createImagenName').classList.add('hidden');
            // Reset loader
            hideCreateLoader();
        }

        // Loader functions for create modal
        let createProgressInterval = null;
        function showCreateLoader() {
            const loader = document.getElementById('createModalLoader');
            const submitBtn = document.getElementById('createSubmitBtn');
            const submitText = document.getElementById('createSubmitText');
            const submitSpinner = document.getElementById('createSubmitSpinner');
            const progressCircle = document.getElementById('createProgressCircle');
            const progressPercent = document.getElementById('createProgressPercent');

            if (loader) loader.classList.remove('hidden');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            if (submitText) submitText.textContent = 'Creando...';
            if (submitSpinner) submitSpinner.classList.remove('hidden');

            // Reset progress
            let progress = 0;
            if (progressPercent) progressPercent.textContent = '0%';
            if (progressCircle) {
                progressCircle.style.strokeDashoffset = '283';
            }

            // Simulate progress
            createProgressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90; // Don't go to 100% until form actually submits

                const offset = 283 - (283 * progress / 100);
                if (progressCircle) progressCircle.style.strokeDashoffset = offset;
                if (progressPercent) progressPercent.textContent = Math.round(progress) + '%';
            }, 200);
        }

        function hideCreateLoader() {
            const loader = document.getElementById('createModalLoader');
            const submitBtn = document.getElementById('createSubmitBtn');
            const submitText = document.getElementById('createSubmitText');
            const submitSpinner = document.getElementById('createSubmitSpinner');
            const progressCircle = document.getElementById('createProgressCircle');
            const progressPercent = document.getElementById('createProgressPercent');

            // Clear interval
            if (createProgressInterval) {
                clearInterval(createProgressInterval);
                createProgressInterval = null;
            }

            // Complete progress to 100%
            if (progressCircle) {
                progressCircle.style.strokeDashoffset = '0';
            }
            if (progressPercent) {
                progressPercent.textContent = '100%';
            }

            // Hide after a brief moment
            setTimeout(() => {
                if (loader) loader.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                if (submitText) submitText.textContent = 'Crear Usuario';
                if (submitSpinner) submitSpinner.classList.add('hidden');

                // Reset progress
                if (progressCircle) progressCircle.style.strokeDashoffset = '283';
                if (progressPercent) progressPercent.textContent = '0%';
            }, 300);
        }

        // Loader functions for edit modal
        let editProgressInterval = null;
        function showEditLoader() {
            const loader = document.getElementById('editModalLoader');
            const submitBtn = document.getElementById('editSubmitBtn');
            const submitText = document.getElementById('editSubmitText');
            const submitSpinner = document.getElementById('editSubmitSpinner');
            const progressCircle = document.getElementById('editProgressCircle');
            const progressPercent = document.getElementById('editProgressPercent');

            if (loader) loader.classList.remove('hidden');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            if (submitText) submitText.textContent = 'Guardando...';
            if (submitSpinner) submitSpinner.classList.remove('hidden');

            // Reset progress
            let progress = 0;
            if (progressPercent) progressPercent.textContent = '0%';
            if (progressCircle) {
                progressCircle.style.strokeDashoffset = '283';
            }

            // Simulate progress
            editProgressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90; // Don't go to 100% until form actually submits

                const offset = 283 - (283 * progress / 100);
                if (progressCircle) progressCircle.style.strokeDashoffset = offset;
                if (progressPercent) progressPercent.textContent = Math.round(progress) + '%';
            }, 200);
        }

        function hideEditLoader() {
            const loader = document.getElementById('editModalLoader');
            const submitBtn = document.getElementById('editSubmitBtn');
            const submitText = document.getElementById('editSubmitText');
            const submitSpinner = document.getElementById('editSubmitSpinner');
            const progressCircle = document.getElementById('editProgressCircle');
            const progressPercent = document.getElementById('editProgressPercent');

            // Clear interval
            if (editProgressInterval) {
                clearInterval(editProgressInterval);
                editProgressInterval = null;
            }

            // Complete progress to 100%
            if (progressCircle) {
                progressCircle.style.strokeDashoffset = '0';
            }
            if (progressPercent) {
                progressPercent.textContent = '100%';
            }

            // Hide after a brief moment
            setTimeout(() => {
                if (loader) loader.classList.add('hidden');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                if (submitText) submitText.textContent = 'Guardar Cambios';
                if (submitSpinner) submitSpinner.classList.add('hidden');

                // Reset progress
                if (progressCircle) progressCircle.style.strokeDashoffset = '283';
                if (progressPercent) progressPercent.textContent = '0%';
            }, 300);
        }

        // Handle form submissions
        document.querySelector('#createModal form')?.addEventListener('submit', function(e) {
            showCreateLoader();
        });

        document.getElementById('editForm')?.addEventListener('submit', function(e) {
            showEditLoader();
        });

        // Modal functions - Delete
        let deleteUserId = null;
        function confirmDelete(id, nombre) {
            deleteUserId = id;
            document.getElementById('deleteNombre').textContent = nombre;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            deleteUserId = null;
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        function deleteUser() {
            if (!deleteUserId) return;

            fetch(`/usuarios/${deleteUserId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeDeleteModal();
                    // Actualizar la tabla manteniendo los filtros actuales
                    updateTable();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al eliminar el usuario');
            });
        }

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeImportModal();
                closeViewModal();
                closeEditModal();
                closeDeleteModal();
            }
        });
    </script>

    <style>
        @keyframes wave-1 {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            33% { transform: translate(80px, -80px) scale(1.2) rotate(120deg); }
            66% { transform: translate(-50px, 60px) scale(0.9) rotate(240deg); }
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

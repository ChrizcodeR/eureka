<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Eureka</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative">
    <!-- Fondo Boreal Animado -->
    <div class="fixed inset-0 z-0">
        <!-- Gradiente base boreal suave -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 via-indigo-50 to-purple-50"></div>
        
        <!-- Ondas animadas grandes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-blue-200/30 to-cyan-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-1"></div>
            <div class="absolute top-1/3 right-0 w-[500px] h-[500px] bg-gradient-to-br from-indigo-200/30 to-purple-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-2"></div>
            <div class="absolute bottom-0 left-0 w-[550px] h-[550px] bg-gradient-to-br from-purple-200/30 to-pink-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-3"></div>
            <div class="absolute bottom-1/4 right-1/3 w-[450px] h-[450px] bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full mix-blend-multiply filter blur-3xl animate-wave-4"></div>
        </div>
        
        <!-- Partículas flotantes sutiles -->
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
            
            <!-- Logo -->
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

            <!-- User Info -->
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

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="#" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

               

                <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium">Asesores</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuración</p>
                    
                    <a href="{{ route('configuracion.usuarios-sistema.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
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
            
            <!-- Top Bar -->
            <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
                <div class="flex items-center justify-between h-20 px-6">
                    <div class="flex items-center space-x-4">
                        <button id="openSidebar" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-sm text-gray-500">Bienvenido de vuelta, aquí está tu resumen</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <input 
                                type="text" 
                                placeholder="Buscar..." 
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-50 focus:bg-white transition-all"
                            >
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    
                    <!-- Card 1 -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-white/20 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">+12%</span>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">2,543</h3>
                            <p class="text-blue-100">Total Usuarios</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-white/20 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">+8%</span>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">$45,678</h3>
                            <p class="text-purple-100">Ingresos</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-white/20 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">+23%</span>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">89</h3>
                            <p class="text-emerald-100">Proyectos Activos</p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-white/20 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">+15%</span>
                            </div>
                            <h3 class="text-3xl font-bold mb-1">94.3%</h3>
                            <p class="text-amber-100">Tasa de Éxito</p>
                        </div>
                    </div>
                </div>

                <!-- Charts & Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    
                    <!-- Chart Card -->
                    <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Resumen de Actividad</h2>
                                <p class="text-sm text-gray-500">Últimos 30 días</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-medium hover:bg-indigo-600 transition-colors">Mes</button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">Año</button>
                            </div>
                        </div>
                        <div class="h-64 flex items-end justify-between space-x-2">
                            <div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg hover:from-blue-600 hover:to-blue-500 transition-all cursor-pointer" style="height: 45%"></div>
                            <div class="flex-1 bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-t-lg hover:from-indigo-600 hover:to-indigo-500 transition-all cursor-pointer" style="height: 60%"></div>
                            <div class="flex-1 bg-gradient-to-t from-purple-500 to-purple-400 rounded-t-lg hover:from-purple-600 hover:to-purple-500 transition-all cursor-pointer" style="height: 75%"></div>
                            <div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg hover:from-blue-600 hover:to-blue-500 transition-all cursor-pointer" style="height: 55%"></div>
                            <div class="flex-1 bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-t-lg hover:from-indigo-600 hover:to-indigo-500 transition-all cursor-pointer" style="height: 85%"></div>
                            <div class="flex-1 bg-gradient-to-t from-purple-500 to-purple-400 rounded-t-lg hover:from-purple-600 hover:to-purple-500 transition-all cursor-pointer" style="height: 70%"></div>
                            <div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg hover:from-blue-600 hover:to-blue-500 transition-all cursor-pointer" style="height: 90%"></div>
                        </div>
                        <div class="flex justify-between mt-4 text-xs text-gray-500">
                            <span>Lun</span>
                            <span>Mar</span>
                            <span>Mié</span>
                            <span>Jue</span>
                            <span>Vie</span>
                            <span>Sáb</span>
                            <span>Dom</span>
                        </div>
                    </div>

                    <!-- Activity Feed -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Actividad Reciente</h2>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Nuevo usuario registrado</p>
                                    <p class="text-xs text-gray-500">Hace 5 minutos</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Proyecto completado</p>
                                    <p class="text-xs text-gray-500">Hace 1 hora</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Pago recibido</p>
                                    <p class="text-xs text-gray-500">Hace 3 horas</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Nuevo comentario</p>
                                    <p class="text-xs text-gray-500">Hace 5 horas</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-rose-400 to-rose-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Error en el sistema</p>
                                    <p class="text-xs text-gray-500">Hace 8 horas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Projects Table -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Proyectos Recientes</h2>
                        <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl text-sm font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                            Ver Todos
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Proyecto</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Cliente</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Progreso</th>
                                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">WD</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Website Redesign</p>
                                                <p class="text-xs text-gray-500">Desarrollo Web</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Empresa ABC</td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">En Progreso</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full" style="width: 75%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600">75%</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">MA</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">Mobile App</p>
                                                <p class="text-xs text-gray-500">Desarrollo Móvil</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Tech Solutions</td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Revisión</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full" style="width: 90%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600">90%</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">EC</span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">E-Commerce Platform</p>
                                                <p class="text-xs text-gray-500">Comercio Electrónico</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-600">Retail Store</td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Planificación</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full" style="width: 30%"></div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600">30%</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <script>
        // Sidebar toggle functionality
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

        // Initially hide sidebar on mobile
        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    </script>
    
    <style>
        /* Animaciones de ondas boreales para dashboard */
        @keyframes wave-1 {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(80px, -80px) scale(1.2) rotate(120deg);
            }
            66% {
                transform: translate(-50px, 60px) scale(0.9) rotate(240deg);
            }
        }
        
        @keyframes wave-2 {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(-70px, 90px) scale(1.15) rotate(-90deg);
            }
            66% {
                transform: translate(80px, -70px) scale(0.85) rotate(-180deg);
            }
        }
        
        @keyframes wave-3 {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(360deg);
            }
            33% {
                transform: translate(90px, -60px) scale(1.25) rotate(240deg);
            }
            66% {
                transform: translate(-70px, 80px) scale(0.95) rotate(120deg);
            }
        }
        
        @keyframes wave-4 {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(-90px, -70px) scale(1.1) rotate(150deg);
            }
            66% {
                transform: translate(60px, 90px) scale(0.9) rotate(300deg);
            }
        }
        
        .animate-wave-1 {
            animation: wave-1 28s ease-in-out infinite;
        }
        
        .animate-wave-2 {
            animation: wave-2 32s ease-in-out infinite;
        }
        
        .animate-wave-3 {
            animation: wave-3 25s ease-in-out infinite;
        }
        
        .animate-wave-4 {
            animation: wave-4 30s ease-in-out infinite;
        }
        
        /* Partículas flotantes */
        @keyframes particle-1 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(120px, -180px) scale(2);
                opacity: 0.2;
            }
        }
        
        @keyframes particle-2 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-150px, 200px) scale(2.5);
                opacity: 0.15;
            }
        }
        
        @keyframes particle-3 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.7;
            }
            50% {
                transform: translate(180px, 120px) scale(2.2);
                opacity: 0.25;
            }
        }
        
        @keyframes particle-4 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(-100px, -150px) scale(1.8);
                opacity: 0.3;
            }
        }
        
        @keyframes particle-5 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(90px, -130px) scale(2.3);
                opacity: 0.2;
            }
        }
        
        @keyframes particle-6 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(-110px, 160px) scale(2);
                opacity: 0.25;
            }
        }
        
        .animate-particle-1 {
            animation: particle-1 20s ease-in-out infinite;
        }
        
        .animate-particle-2 {
            animation: particle-2 24s ease-in-out infinite;
        }
        
        .animate-particle-3 {
            animation: particle-3 18s ease-in-out infinite;
        }
        
        .animate-particle-4 {
            animation: particle-4 22s ease-in-out infinite;
        }
        
        .animate-particle-5 {
            animation: particle-5 26s ease-in-out infinite;
        }
        
        .animate-particle-6 {
            animation: particle-6 19s ease-in-out infinite;
        }
    </style>
</body>
</html>


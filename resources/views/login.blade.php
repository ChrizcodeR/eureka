<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eureka</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative overflow-hidden">
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
    
    <div class="min-h-screen flex relative z-10">
        <!-- Panel Izquierdo - Decorativo -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
            <!-- Formas decorativas animadas -->
            <div class="absolute top-20 left-20 w-72 h-72 bg-blue-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-purple-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-40 w-72 h-72 bg-indigo-200/30 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            
            <div class="relative z-10 flex flex-col justify-center items-center w-full px-12">
                <div class="text-center space-y-6">
                    <!-- Logo/Icono -->
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl rotate-6 hover:rotate-0 transition-transform duration-500">
                        <svg class="w-14 h-14 text-white font-bold" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="50" cy="50" r="45" fill="currentColor" opacity="0.2"/>
                            <path d="M30 25 L30 75 M30 25 L65 25 M30 50 L55 50 M30 75 L65 75"/>
                            <circle cx="70" cy="30" r="4" fill="currentColor"/>
                            <path d="M70 40 L70 50"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Eureka
                    </h1>
                    
                    <p class="text-xl text-gray-600 max-w-md">
                        Gestiona tu plataforma con la herramienta más intuitiva y poderosa del mercado
                    </p>
                    
                    <!-- Características -->
                    <div class="mt-12 space-y-4">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-lg">Dashboard en tiempo real</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-lg">Análisis avanzado de datos</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-lg">Seguridad de primer nivel</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Derecho - Formulario de Login -->
        <div class="flex-1 flex items-center justify-center px-6 py-12 bg-white/80 backdrop-blur-xl">
            <div class="w-full max-w-md">
                <!-- Logo para móvil -->
                <div class="lg:hidden text-center mb-8">
                    <div class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">¡Bienvenido de nuevo!</h2>
                    <p class="text-gray-600">Ingresa tus credenciales para continuar</p>
                </div>

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Campo Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="block w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="tu@ejemplo.com"
                            >
                        </div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="group">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required
                                class="block w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <!-- Recordarme y Olvidé contraseña -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Recordarme
                            </label>
                        </div>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- Botón de Envío -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 text-white py-3.5 px-4 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        ¿No tienes cuenta? 
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                            Contacta al administrador
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Animaciones de ondas boreales */
        @keyframes wave-slow {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(60px, -60px) scale(1.15) rotate(120deg);
            }
            66% {
                transform: translate(-40px, 40px) scale(0.95) rotate(240deg);
            }
        }
        
        @keyframes wave-slower {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(-50px, 70px) scale(1.1) rotate(-90deg);
            }
            66% {
                transform: translate(60px, -50px) scale(0.9) rotate(-180deg);
            }
        }
        
        @keyframes wave-reverse {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(360deg);
            }
            33% {
                transform: translate(-70px, -40px) scale(1.2) rotate(240deg);
            }
            66% {
                transform: translate(50px, 60px) scale(0.85) rotate(120deg);
            }
        }
        
        .animate-wave-slow {
            animation: wave-slow 20s ease-in-out infinite;
        }
        
        .animate-wave-slower {
            animation: wave-slower 25s ease-in-out infinite;
        }
        
        .animate-wave-reverse {
            animation: wave-reverse 18s ease-in-out infinite;
        }
        
        /* Partículas flotantes */
        @keyframes float-1 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(100px, -150px) scale(1.5);
                opacity: 0.3;
            }
        }
        
        @keyframes float-2 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-120px, 180px) scale(2);
                opacity: 0.2;
            }
        }
        
        @keyframes float-3 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.7;
            }
            50% {
                transform: translate(150px, 100px) scale(1.8);
                opacity: 0.3;
            }
        }
        
        @keyframes float-4 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translate(-90px, -120px) scale(1.3);
                opacity: 0.4;
            }
        }
        
        @keyframes float-5 {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(80px, -100px) scale(2.2);
                opacity: 0.2;
            }
        }
        
        .animate-float-1 {
            animation: float-1 15s ease-in-out infinite;
        }
        
        .animate-float-2 {
            animation: float-2 18s ease-in-out infinite;
        }
        
        .animate-float-3 {
            animation: float-3 20s ease-in-out infinite;
        }
        
        .animate-float-4 {
            animation: float-4 16s ease-in-out infinite;
        }
        
        .animate-float-5 {
            animation: float-5 22s ease-in-out infinite;
        }
    </style>
</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servidor de Correo - Eureka</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-[Inter] antialiased relative">
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50 via-indigo-50 to-purple-50"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-blue-200/30 to-cyan-300/30 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute top-1/3 right-0 w-[500px] h-[500px] bg-gradient-to-br from-indigo-200/30 to-purple-300/30 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-[550px] h-[550px] bg-gradient-to-br from-purple-200/30 to-pink-300/30 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/3 w-[450px] h-[450px] bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>
    </div>
    <div class="flex h-screen overflow-hidden relative z-10">
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
                    @if((session('user_role') ?? 'admin') === 'root')
                    <a href="{{ route('accesos.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        <span class="font-medium">Log de Accesos</span>
                    </a>
                    @endif
                    <a href="{{ route('configuracion.usuarios-sistema.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Usuarios Sistema</span>
                    </a>
                    @if((session('user_role') ?? 'admin') === 'root')
                    <a href="{{ route('configuracion.consola.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v12H4zM8 9h8M8 13h5"></path>
                        </svg>
                        <span class="font-medium">Consola SQL</span>
                    </a>
                    @endif
                    <a href="{{ route('configuracion.correo.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 00-4-4m4 4a4 4 0 11-8 0m8 0v4m-8-4v4"/>
                        </svg>
                        <span class="font-medium">Servidor de Correo</span>
                    </a>
                </div>
                <div class="pt-6 mt-6 border-t border-slate-700/50">
                    <p class="px-4 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ajustes</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-red-500/10 hover:border-l-4 hover:border-red-500 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 01-3-3h4a3 3 0 01-3 3v1"></path>
                            </svg>
                            <span class="font-medium">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>
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
                            <h1 class="text-2xl font-bold text-gray-900">Servidor de Correo</h1>
                            <p class="text-sm text-gray-500">Configuración SMTP y plantillas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3"></div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
                @endif
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Servidor SMTP</h2>
                            <p class="text-sm text-gray-500">Define los parámetros del mailer</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('configuracion.correo.save') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-700">Host</label>
                                        <input name="host" value="{{ old('host', $config->host ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">Puerto</label>
                                        <input type="number" name="port" value="{{ old('port', $config->port ?? 587) }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">Encriptación</label>
                                        <select name="encryption" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            @php $enc = old('encryption', $config->encryption ?? 'tls'); @endphp
                                            <option value="tls" {{ $enc==='tls'?'selected':'' }}>tls</option>
                                            <option value="ssl" {{ $enc==='ssl'?'selected':'' }}>ssl</option>
                                            <option value="null" {{ $enc==='null'?'selected':'' }}>sin encriptación</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">Usuario</label>
                                        <input name="username" value="{{ old('username', $config->username ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">Contraseña</label>
                                        <input type="password" name="password" placeholder="(sin cambios si se deja vacío)" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">From Address</label>
                                        <input name="from_address" value="{{ old('from_address', $config->from_address ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">From Name</label>
                                        <input name="from_name" value="{{ old('from_name', $config->from_name ?? 'Eureka') }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @php $active = old('activo', ($config->activo ?? true) ? '1' : null); @endphp
                                        <input type="checkbox" name="activo" value="1" {{ $active ? 'checked' : '' }} />
                                        <span class="text-sm text-gray-700">Habilitar envío</span>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:shadow-lg transition-all">Guardar</button>
                                </div>
                            </form>
                            <div class="mt-6">
                                <form action="{{ route('configuracion.correo.test') }}" method="POST" class="flex items-end gap-4">
                                    @csrf
                                    <div class="flex-1">
                                        <label class="text-sm text-gray-700">Enviar prueba a</label>
                                        <input name="to_email" placeholder="correo@dominio.com" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-sm text-gray-700">Plantilla</label>
                                        <select name="template_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            @foreach(($templates ?? []) as $tpl)
                                                <option value="{{ $tpl->id }}">{{ $tpl->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg hover:shadow-lg transition-all">Enviar prueba</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Plantillas de Correo</h2>
                            <p class="text-sm text-gray-500">Asunto y cuerpo en HTML</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('configuracion.correo.templates.store') }}" method="POST" class="space-y-3 mb-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-700">Nombre</label>
                                        <input name="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700">Clave</label>
                                        <input name="clave" placeholder="ej: envio_contrasena" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-sm text-gray-700">Asunto</label>
                                        <input name="asunto" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-sm text-gray-700">HTML</label>
                                        <textarea name="html" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="activo" value="1" checked />
                                        <span class="text-sm text-gray-700">Activa</span>
                                    </div>
                                </div>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:shadow-lg transition-all">Crear plantilla</button>
                            </form>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50/80">
                                        <tr>
                                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Clave</th>
                                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Asunto</th>
                                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse(($templates ?? []) as $tpl)
                                            <tr>
                                                <td class="py-3 px-4 text-sm text-gray-800">{{ $tpl->nombre }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-800">{{ $tpl->clave }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-800">{{ $tpl->asunto }}</td>
                                                <td class="py-3 px-4 text-sm">{{ $tpl->activo ? 'Activa' : 'Inactiva' }}</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <details>
                                                        <summary class="cursor-pointer text-indigo-600">Editar</summary>
                                                        <div class="mt-3 p-4 border border-gray-200 rounded-xl">
                                                            <form action="{{ route('configuracion.correo.templates.update', $tpl->id) }}" method="POST" class="space-y-3">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                    <div>
                                                                        <label class="text-sm text-gray-700">Nombre</label>
                                                                        <input name="nombre" value="{{ $tpl->nombre }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                                                    </div>
                                                                    <div>
                                                                        <label class="text-sm text-gray-700">Clave</label>
                                                                        <input name="clave" value="{{ $tpl->clave }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                                                    </div>
                                                                    <div class="md:col-span-2">
                                                                        <label class="text-sm text-gray-700">Asunto</label>
                                                                        <input name="asunto" value="{{ $tpl->asunto }}" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                                                                    </div>
                                                                    <div class="md:col-span-2">
                                                                        <label class="text-sm text-gray-700">HTML</label>
                                                                        <textarea name="html" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ $tpl->html }}</textarea>
                                                                    </div>
                                                                    <div class="flex items-center gap-2">
                                                                        <input type="checkbox" name="activo" value="1" {{ $tpl->activo ? 'checked' : '' }} />
                                                                        <span class="text-sm text-gray-700">Activa</span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex gap-3">
                                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg hover:shadow-lg transition-all">Guardar</button>
                                                                    <button type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:shadow-lg transition-all" onclick="deleteTemplate({{ $tpl->id }})">Eliminar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </details>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td class="py-3 px-4 text-sm text-gray-500" colspan="5">No hay plantillas creadas.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
    async function deleteTemplate(id){
        if(!confirm('¿Eliminar plantilla?')) return;
        const url = "{{ url('/configuracion/correo/plantillas') }}/"+id;
        const res = await fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
        if(res.ok){ location.reload(); } else { alert('Error al eliminar'); }
    }
    </script>
</body>
</html>

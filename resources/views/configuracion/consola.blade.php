<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consola SQL - Eureka</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        textarea.sql-input { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
    </style>
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
                    <a href="{{ route('accesos.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
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
                    <a href="{{ route('configuracion.consola.index') }}" class="flex items-center space-x-3 px-4 py-3 text-white bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border-l-4 border-blue-500 rounded-lg transition-all duration-200">
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
                            <h1 class="text-2xl font-bold text-gray-900">Consola SQL</h1>
                            <p class="text-sm text-gray-500">Ejecución de consultas de lectura</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3"></div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                <div id="successMessage" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Tablas de la base de datos</h2>
                            <p class="text-sm text-gray-500">Total: {{ isset($tables) ? count($tables) : 0 }}</p>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <ul class="divide-y divide-gray-100">
                                @forelse(($tables ?? []) as $t)
                                    <li class="px-6 py-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-800">{{ $t }}</span>
                                            <div class="flex items-center gap-3">
                                                <button type="button" class="text-xs text-gray-600 hover:text-gray-800" onclick="loadColumns('{{ $t }}', this.closest('li').querySelector('.columns-container'))">Ver columnas</button>
                                                <button type="button" class="text-xs text-indigo-600 hover:text-indigo-800" onclick="(function(){const ta=document.querySelector('textarea[name=sql]'); if(ta){ ta.value='SELECT * FROM '+`\`${'{{ $t }}'}`+' LIMIT 20'; ta.focus(); }})()">Usar SELECT</button>
                                            </div>
                                        </div>
                                        <div class="columns-container hidden mt-3 border border-gray-200 rounded-lg overflow-hidden">
                                            <div class="px-4 py-2 bg-gray-50 text-xs text-gray-500">Columnas</div>
                                            <div class="p-4 text-sm text-gray-700">Cargando...</div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="px-6 py-3 text-sm text-gray-500">No se encontraron tablas.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Historial de consultas</h2>
                            <p class="text-sm text-gray-500">Últimas {{ isset($history) ? count($history) : 0 }} consultas</p>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <ul class="divide-y divide-gray-100">
                                @forelse(array_reverse($history ?? []) as $h)
                                    <li class="px-6 py-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500">{{ $h['ts'] ?? '' }} • {{ ($h['status'] ?? 'ok') === 'ok' ? 'OK' : 'Error' }} • {{ $h['time_ms'] ?? 0 }} ms • {{ $h['rows'] ?? 0 }} filas</p>
                                                <p class="mt-1 text-sm font-mono text-gray-800 break-words">{{ $h['sql'] ?? '' }}</p>
                                                @if(isset($h['error']))
                                                    <p class="mt-1 text-xs text-red-600">{{ $h['error'] }}</p>
                                                @endif
                                            </div>
                                            <button type="button" class="text-xs text-indigo-600 hover:text-indigo-800 flex-shrink-0" onclick="(function(){const ta=document.querySelector('textarea[name=sql]'); if(ta){ ta.value={{ json_encode($h['sql'] ?? '') }}; ta.focus(); }})()">Usar</button>
                                        </div>
                                    </li>
                                @empty
                                    <li class="px-6 py-3 text-sm text-gray-500">Aún no hay consultas.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                @if($errors->any())
                <div id="errorMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
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
                <div class="mb-6">
                    <form action="{{ route('configuracion.consola.execute') }}" method="POST" class="space-y-4 max-w-4xl">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700">Consulta SQL</label>
                        <textarea name="sql" rows="8" class="sql-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white/80 backdrop-blur-xl transition-all shadow-sm" placeholder="Escribe tu consulta SQL de lectura">{{ old('sql', $sql ?? '') }}</textarea>
                        <p class="text-xs text-gray-500">Solo se permiten consultas SELECT, SHOW, DESCRIBE, EXPLAIN.</p>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg hover:shadow-lg transition-all">Ejecutar</button>
                    </form>
                </div>
                @if(isset($columns) && count($columns))
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Resultados</h2>
                        @if(isset($timeMs))
                        <p class="text-sm text-gray-500">Tiempo: {{ $timeMs }} ms • Filas: {{ count($rows) }}</p>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50/80">
                                <tr>
                                    @foreach($columns as $col)
                                    <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($rows as $row)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    @foreach($columns as $col)
                                    <td class="py-4 px-6 text-sm text-gray-700">{{ $row[$col] ?? '' }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif(isset($timeMs))
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <p class="text-blue-700 text-sm">Consulta ejecutada sin resultados.</p>
                </div>
                @endif
            </main>
            <script>
            async function loadColumns(table, container){
                if(!container) return;
                if(!container.dataset.loaded){
                    const url = "{{ route('configuracion.consola.columns') }}" + "?table=" + encodeURIComponent(table);
                    try {
                        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        const data = await res.json();
                        let html = '';
                        const cols = (data && data.columns) ? data.columns : [];
                        if(cols.length){
                            html += '<div class="overflow-x-auto"><table class="w-full">';
                            html += '<thead class="bg-gray-50/80"><tr>' + ['Columna','Tipo','Nullable','Default'].map(h=>'<th class="text-left py-2 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">'+h+'</th>').join('') + '</tr></thead>';
                            html += '<tbody class="divide-y divide-gray-100">';
                            for(const c of cols){
                                html += '<tr class="hover:bg-gray-50/50 transition-colors">';
                                html += '<td class="py-2 px-4 text-sm text-gray-700">'+(c.name??'')+'</td>';
                                html += '<td class="py-2 px-4 text-sm text-gray-700">'+(c.type??'')+'</td>';
                                html += '<td class="py-2 px-4 text-sm text-gray-700">'+((c.nullable)?'YES':'NO')+'</td>';
                                html += '<td class="py-2 px-4 text-sm text-gray-700">'+(c.default??'')+'</td>';
                                html += '</tr>';
                            }
                            html += '</tbody></table></div>';
                        } else {
                            html = '<div class="p-4 text-sm text-gray-500">No se pudieron obtener columnas.</div>';
                        }
                        container.innerHTML = html;
                        container.dataset.loaded = '1';
                    } catch(e){
                        container.innerHTML = '<div class="p-4 text-sm text-red-600">Error cargando columnas</div>';
                        container.dataset.loaded = '1';
                    }
                }
                container.classList.toggle('hidden');
            }
            </script>
        </div>
    </div>
</body>
</html>

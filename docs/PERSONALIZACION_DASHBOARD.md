# 🎨 Guía de Personalización del Dashboard

## 🔧 Cómo Personalizar Tu Dashboard

---

## 1. 🎨 Cambiar la Paleta de Colores

### Opción A: Cambiar a Tonos Verdes (Naturaleza)

Busca en `dashboard.blade.php` y reemplaza:

```html
<!-- DE: -->
class="bg-gradient-to-br from-blue-500 to-blue-600"

<!-- A: -->
class="bg-gradient-to-br from-emerald-500 to-emerald-600"
```

### Opción B: Cambiar a Tonos Rosas (Moderno)

```html
<!-- DE: -->
class="bg-gradient-to-br from-blue-500 to-blue-600"

<!-- A: -->
class="bg-gradient-to-br from-pink-500 to-rose-600"
```

### Opción C: Cambiar a Tonos Naranjas (Energético)

```html
<!-- DE: -->
class="bg-gradient-to-br from-blue-500 to-blue-600"

<!-- A: -->
class="bg-gradient-to-br from-orange-500 to-amber-600"
```

---

## 2. 🖼️ Cambiar el Logo

### En el Sidebar (dashboard.blade.php línea ~14):

```html
<div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
    <!-- Reemplaza el SVG con tu logo o iniciales -->
    <span class="text-white font-bold text-lg">TU</span>
</div>
<span class="text-xl font-bold text-white">TuEmpresa</span>
```

### En el Login (login.blade.php línea ~16):

```html
<div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl">
    <!-- Puedes usar una imagen -->
    <img src="/ruta/a/tu/logo.png" alt="Logo" class="w-16 h-16">
</div>
```

---

## 3. 📝 Cambiar Textos y Títulos

### Título Principal del Dashboard:

En `dashboard.blade.php` línea ~166:

```html
<h1 class="text-2xl font-bold text-gray-900">Mi Panel</h1>
<p class="text-sm text-gray-500">Tu mensaje personalizado aquí</p>
```

### Título del Login:

En `login.blade.php` línea ~42:

```html
<h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
    Tu Empresa
</h1>
<p class="text-xl text-gray-600 max-w-md">
    Tu eslogan o descripción aquí
</p>
```

---

## 4. 📊 Personalizar las Tarjetas de Estadísticas

### Cambiar los Números:

En `dashboard.blade.php` líneas ~200-270:

```html
<!-- Card 1 -->
<h3 class="text-3xl font-bold mb-1">TU_NUMERO</h3>
<p class="text-blue-100">Tu Métrica</p>

<!-- Card 2 -->
<h3 class="text-3xl font-bold mb-1">$TU_VALOR</h3>
<p class="text-purple-100">Tu Descripción</p>
```

### Agregar una Nueva Tarjeta:

```html
<!-- Card 5 - Nuevo -->
<div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
    <div class="relative">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-white/20 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <!-- Tu icono aquí -->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">+10%</span>
        </div>
        <h3 class="text-3xl font-bold mb-1">123</h3>
        <p class="text-cyan-100">Tu Nueva Métrica</p>
    </div>
</div>
```

---

## 5. 🎯 Agregar Nuevas Secciones al Sidebar

En `dashboard.blade.php` después de la línea ~150:

```html
<a href="#" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-all duration-200 group">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <!-- Elige tu icono de https://heroicons.com -->
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    <span class="font-medium">Tu Nueva Sección</span>
    <!-- Opcional: Badge con contador -->
    <span class="ml-auto px-2 py-0.5 bg-blue-500/20 text-blue-300 text-xs font-semibold rounded-full">3</span>
</a>
```

---

## 6. 🔔 Personalizar el Feed de Actividad

En `dashboard.blade.php` líneas ~310-380:

```html
<!-- Agregar nueva actividad -->
<div class="flex items-start space-x-3">
    <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-full flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <!-- Tu icono -->
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900">Tu evento</p>
        <p class="text-xs text-gray-500">Hace X tiempo</p>
    </div>
</div>
```

---

## 7. 📋 Personalizar la Tabla de Proyectos

### Agregar una Nueva Fila:

En `dashboard.blade.php` después de la línea ~470:

```html
<tr class="hover:bg-gray-50 transition-colors">
    <td class="py-4 px-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-lg flex items-center justify-center">
                <span class="text-white font-semibold text-sm">NP</span>
            </div>
            <div>
                <p class="font-medium text-gray-900">Nuevo Proyecto</p>
                <p class="text-xs text-gray-500">Categoría</p>
            </div>
        </div>
    </td>
    <td class="py-4 px-4 text-sm text-gray-600">Cliente Nombre</td>
    <td class="py-4 px-4">
        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Estado</span>
    </td>
    <td class="py-4 px-4">
        <div class="flex items-center space-x-2">
            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full" style="width: 50%"></div>
            </div>
            <span class="text-xs font-medium text-gray-600">50%</span>
        </div>
    </td>
    <td class="py-4 px-4">
        <button class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver</button>
    </td>
</tr>
```

---

## 8. 🎨 Cambiar el Color del Sidebar

En `dashboard.blade.php` línea ~11:

```html
<!-- Opción 1: Sidebar Oscuro Azulado -->
<aside class="... bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900">

<!-- Opción 2: Sidebar Oscuro Morado -->
<aside class="... bg-gradient-to-b from-purple-900 via-purple-800 to-purple-900">

<!-- Opción 3: Sidebar Negro Puro -->
<aside class="... bg-gradient-to-b from-gray-900 via-black to-gray-900">

<!-- Opción 4: Sidebar Azul Marino -->
<aside class="... bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900">
```

---

## 9. 🔐 Cambiar las Credenciales de Login

En `app/Http/Controllers/AuthController.php` línea ~31:

```php
if ($request->email === 'tu@email.com' && $request->password === 'tucontraseña') {
    // Login exitoso
}
```

---

## 10. 📱 Personalizar el Avatar del Usuario

En `dashboard.blade.php` línea ~29:

```html
<!-- Opción 1: Con Iniciales -->
<div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
    TU
</div>

<!-- Opción 2: Con Imagen -->
<img src="/ruta/a/avatar.jpg" alt="Avatar" class="w-12 h-12 rounded-full shadow-lg object-cover">

<!-- Opción 3: Con Icono -->
<div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center shadow-lg">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
    </svg>
</div>
```

---

## 11. 🎨 Crear Tu Propia Paleta de Colores

### Paso 1: Define tus colores

```javascript
// Colores principales
const miPaleta = {
    primario: 'from-[#TU_COLOR_1] to-[#TU_COLOR_2]',
    secundario: 'from-[#TU_COLOR_3] to-[#TU_COLOR_4]',
    acento: 'from-[#TU_COLOR_5] to-[#TU_COLOR_6]'
};
```

### Paso 2: Reemplaza en las clases

```html
<!-- Ejemplo con colores personalizados -->
<div class="bg-gradient-to-br from-[#6366F1] to-[#8B5CF6]">
    <!-- Tu contenido -->
</div>
```

---

## 12. 📊 Cambiar el Estilo del Gráfico

En `dashboard.blade.php` líneas ~280-295:

```html
<!-- Cambiar altura de las barras -->
<div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t-lg" style="height: 45%"></div>

<!-- Cambiar a un solo color -->
<div class="flex-1 bg-blue-500 rounded-t-lg" style="height: 60%"></div>

<!-- Cambiar el gradiente -->
<div class="flex-1 bg-gradient-to-t from-emerald-500 to-teal-400 rounded-t-lg" style="height: 75%"></div>
```

---

## 13. 🔔 Personalizar Notificaciones

En `dashboard.blade.php` línea ~185:

```html
<!-- Cambiar el número de notificaciones -->
<button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
    </svg>
    <!-- Cambia el número aquí -->
    <span class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">9</span>
</button>
```

---

## 14. 🎯 Agregar Tooltips

```html
<!-- Agregar título para tooltip nativo -->
<button title="Haz clic para ver notificaciones" class="...">
    <!-- Contenido del botón -->
</button>

<!-- O agregar un tooltip personalizado -->
<div class="relative group">
    <button class="...">
        <!-- Contenido -->
    </button>
    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
        Tu mensaje aquí
    </div>
</div>
```

---

## 15. 🌙 Agregar Modo Oscuro (Básico)

En el `<body>` de ambos archivos, agrega `dark:` clases:

```html
<body class="font-[Inter] antialiased bg-gray-50 dark:bg-gray-900">

<!-- En tarjetas -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
    <h2 class="text-gray-900 dark:text-white">Título</h2>
    <p class="text-gray-600 dark:text-gray-300">Descripción</p>
</div>
```

---

## 🎨 Recursos Útiles

### Iconos:
- **Heroicons**: https://heroicons.com (los que estamos usando)
- **Feather Icons**: https://feathericons.com
- **Font Awesome**: https://fontawesome.com

### Paletas de Colores:
- **Coolors**: https://coolors.co
- **Adobe Color**: https://color.adobe.com
- **Tailwind Colors**: https://tailwindcss.com/docs/customizing-colors

### Gradientes:
- **UI Gradients**: https://uigradients.com
- **Gradient Hunt**: https://gradienthunt.com
- **CSS Gradient**: https://cssgradient.io

### Fuentes:
- **Google Fonts**: https://fonts.google.com
- Actualmente usando: **Inter** (moderna y limpia)

---

## 💡 Tips de Personalización

1. **Mantén la Consistencia**: Usa la misma paleta en todo el dashboard
2. **Contraste Adecuado**: Asegúrate de que el texto sea legible
3. **Espaciado Uniforme**: Mantén el sistema de espaciado de Tailwind
4. **Prueba en Móvil**: Verifica que tus cambios se vean bien en todos los dispositivos
5. **Guarda Backups**: Antes de hacer cambios grandes, guarda una copia
6. **Usa Variables CSS**: Para cambios globales de colores
7. **Documenta tus Cambios**: Anota qué modificaste para futuras referencias

---

## 🚀 Próximos Niveles de Personalización

### Nivel Intermedio:
- Conectar con API para datos reales
- Agregar gráficos con Chart.js o ApexCharts
- Implementar búsqueda funcional
- Sistema de notificaciones real

### Nivel Avanzado:
- Modo oscuro completo con toggle
- Temas personalizables por usuario
- Animaciones avanzadas con Framer Motion
- Dashboard en tiempo real con WebSockets
- Exportación de datos (PDF, Excel)
- Sistema de permisos y roles

---

✨ **¡Personaliza tu dashboard y hazlo único!** ✨


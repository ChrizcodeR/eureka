# URLs de Acceso al Sistema

Este documento describe todas las URLs disponibles en la aplicación.

## 🌐 URLs Públicas (Sin Autenticación)

### Búsqueda Pública de Usuarios
- **URL**: `http://localhost:8000/` o `http://tu-dominio.com/`
- **Descripción**: Interfaz pública para buscar usuarios por cédula y descargar imágenes
- **Acceso**: Público, sin necesidad de login
- **Funcionalidad**:
  - Buscar usuario por número de cédula
  - Ver información del usuario encontrado
  - Descargar imagen asociada (si existe)

### Búsqueda (POST)
- **URL**: `http://localhost:8000/buscar`
- **Método**: POST
- **Descripción**: Procesa la búsqueda de usuario por cédula

### Descarga Pública de Imagen
- **URL**: `http://localhost:8000/descargar-imagen/{cedula}`
- **Ejemplo**: `http://localhost:8000/descargar-imagen/1234567890`
- **Descripción**: Descarga la imagen de un usuario por su número de cédula

---

## 🔐 URLs del Backend Administrativo (Con Autenticación)

### Login (Acceso al Backend)
- **URL**: `http://localhost:8000/login` o `http://tu-dominio.com/login`
- **Descripción**: Página de inicio de sesión para acceder al panel administrativo
- **Credenciales**:
  - Email: `admin@panel.com`
  - Password: `admin123`

### Dashboard
- **URL**: `http://localhost:8000/dashboard` o `http://tu-dominio.com/dashboard`
- **Descripción**: Panel principal del administrador
- **Requisito**: Debe estar autenticado

### Gestión de Usuarios
- **URL**: `http://localhost:8000/usuarios` o `http://tu-dominio.com/usuarios`
- **Descripción**: Lista de usuarios con filtros, búsqueda y paginación
- **Funcionalidades**:
  - Ver lista de usuarios
  - Crear nuevo usuario
  - Editar usuario
  - Eliminar usuario
  - Ver detalles de usuario
  - Descargar imagen de usuario
  - Importar usuarios desde Excel
  - Filtrar y ordenar usuarios

### Descarga de Plantilla Excel
- **URL**: `http://localhost:8000/usuarios/plantilla`
- **Descripción**: Descarga la plantilla Excel para importar usuarios

### Importar Usuarios
- **URL**: `http://localhost:8000/usuarios/importar`
- **Método**: POST
- **Descripción**: Importa usuarios desde un archivo Excel

### Logout
- **URL**: `http://localhost:8000/logout`
- **Método**: POST
- **Descripción**: Cierra la sesión del administrador

---

## 📋 Resumen Rápido

### Para Usuarios Públicos
```
Frontend Público: http://localhost:8000/
```

### Para Administradores
```
Backend/Login:    http://localhost:8000/login
Dashboard:        http://localhost:8000/dashboard
Usuarios:         http://localhost:8000/usuarios
```

---

## 🔑 Credenciales de Acceso

### Backend Administrativo
- **Email**: `admin@panel.com`
- **Password**: `admin123`

---

## 📝 Notas Importantes

1. **Ruta Raíz (`/`)**: Ahora está configurada para la búsqueda pública. Si necesitas acceder al backend, usa `/login`.

2. **Autenticación**: Las rutas administrativas requieren estar autenticado. Si intentas acceder sin estar logueado, serás redirigido a `/login`.

3. **Sesión**: La autenticación se mantiene mediante sesiones. Al cerrar sesión, necesitarás volver a iniciar sesión.

4. **Producción**: En producción, reemplaza `localhost:8000` con tu dominio real.

---

## 🚀 Inicio Rápido

1. **Para acceder al backend administrativo**:
   ```
   http://localhost:8000/login
   ```

2. **Para usar la búsqueda pública**:
   ```
   http://localhost:8000/
   ```

3. **Para gestionar usuarios (después de login)**:
   ```
   http://localhost:8000/usuarios
   ```


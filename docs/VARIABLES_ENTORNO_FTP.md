# Variables de Entorno para FTP

Este documento describe las variables de entorno necesarias para configurar el servidor FTP donde se almacenarán las imágenes de los usuarios.

## Variables Requeridas

Agrega las siguientes variables a tu archivo `.env`:

```env
# Configuración del Servidor FTP
FTP_HOST=tu-servidor-ftp.com
FTP_USERNAME=tu_usuario_ftp
FTP_PASSWORD=tu_contraseña_ftp
FTP_PORT=21
FTP_ROOT=/
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30

# URL Base del FTP (opcional, para acceder a las imágenes)
# Si tu servidor FTP tiene una URL pública para acceder a los archivos, configúrala aquí
# Ejemplo: http://tu-servidor-ftp.com/public
# O si usas un dominio diferente: https://imagenes.tudominio.com
FTP_URL=http://tu-servidor-ftp.com/public
```

## Descripción de Variables

### FTP_HOST
- **Descripción**: Dirección del servidor FTP (IP o dominio)
- **Ejemplo**: `ftp.ejemplo.com` o `192.168.1.100`
- **Requerido**: Sí

### FTP_USERNAME
- **Descripción**: Nombre de usuario para autenticarse en el servidor FTP
- **Ejemplo**: `usuario_ftp`
- **Requerido**: Sí

### FTP_PASSWORD
- **Descripción**: Contraseña para autenticarse en el servidor FTP
- **Ejemplo**: `mi_contraseña_segura`
- **Requerido**: Sí

### FTP_PORT
- **Descripción**: Puerto del servidor FTP
- **Valor por defecto**: `21`
- **Ejemplo**: `21` (FTP estándar) o `990` (FTPS)
- **Requerido**: No

### FTP_ROOT
- **Descripción**: Directorio raíz donde se guardarán las imágenes
- **Valor por defecto**: `/`
- **Ejemplo**: `/public_html/imagenes` o `/uploads`
- **Requerido**: No

### FTP_PASSIVE
- **Descripción**: Modo pasivo del FTP (recomendado para la mayoría de servidores)
- **Valor por defecto**: `true`
- **Valores posibles**: `true` o `false`
- **Requerido**: No

### FTP_SSL
- **Descripción**: Usar conexión SSL/TLS (FTPS)
- **Valor por defecto**: `false`
- **Valores posibles**: `true` o `false`
- **Requerido**: No

### FTP_TIMEOUT
- **Descripción**: Tiempo de espera en segundos para las operaciones FTP
- **Valor por defecto**: `30`
- **Ejemplo**: `60`
- **Requerido**: No

### FTP_URL
- **Descripción**: URL base pública para acceder a las imágenes almacenadas en el FTP
- **Ejemplo**: `http://imagenes.tudominio.com` o `https://cdn.tudominio.com`
- **Requerido**: No (pero recomendado si quieres mostrar las imágenes directamente)

## Ejemplo de Configuración Completa

```env
# Servidor FTP de ejemplo
FTP_HOST=ftp.miempresa.com
FTP_USERNAME=usuario_imagenes
FTP_PASSWORD=MiContraseña123!
FTP_PORT=21
FTP_ROOT=/public_html/imagenes/usuarios
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30

# URL pública para acceder a las imágenes
FTP_URL=https://imagenes.miempresa.com/usuarios
```

## Notas Importantes

1. **Seguridad**: Nunca compartas tu archivo `.env` públicamente. Contiene credenciales sensibles.

2. **Permisos del Servidor FTP**: Asegúrate de que el usuario FTP tenga permisos de escritura en el directorio especificado en `FTP_ROOT`.

3. **Modo Pasivo**: La mayoría de los servidores FTP modernos requieren modo pasivo (`FTP_PASSIVE=true`). Si tienes problemas de conexión, intenta cambiar este valor.

4. **FTPS (SSL)**: Si tu servidor requiere conexión segura, configura `FTP_SSL=true` y usa el puerto `990` en `FTP_PORT`.

5. **URL Pública**: Si configuras `FTP_URL`, las imágenes se mostrarán directamente desde el servidor FTP. Si no lo configuras, Laravel intentará generar una URL usando el sistema de almacenamiento.

6. **Estructura de Carpetas**: Las imágenes se guardarán en la carpeta `usuarios/` dentro del directorio raíz configurado. Cada imagen tendrá un nombre único generado automáticamente (UUID).

## Verificación de Configuración

Después de configurar las variables de entorno, puedes verificar que todo funcione correctamente:

1. Ejecuta la migración: `php artisan migrate`
2. Intenta crear un usuario con imagen desde el panel
3. Verifica que la imagen se suba correctamente al servidor FTP
4. Verifica que la imagen se muestre correctamente en la lista de usuarios

## Solución de Problemas

### Error: "Connection refused"
- Verifica que `FTP_HOST` y `FTP_PORT` sean correctos
- Asegúrate de que el servidor FTP esté accesible desde tu servidor

### Error: "Login incorrect"
- Verifica `FTP_USERNAME` y `FTP_PASSWORD`
- Asegúrate de que las credenciales sean correctas

### Error: "Permission denied"
- Verifica que el usuario FTP tenga permisos de escritura en `FTP_ROOT`
- Contacta con tu administrador de servidor FTP

### Las imágenes no se muestran
- Verifica que `FTP_URL` esté configurada correctamente
- Asegúrate de que la URL sea accesible públicamente
- Verifica los permisos del servidor FTP para lectura pública


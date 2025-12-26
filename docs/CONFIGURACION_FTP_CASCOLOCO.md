# Configuración FTP para cascoloco.com

## Configuración Correcta para tu archivo `.env`

Agrega estas líneas a tu archivo `.env` (cada variable en una línea separada):

```env
# Configuración del Servidor FTP
FTP_HOST=cascoloco.com
FTP_USERNAME=sumas
FTP_PASSWORD="2&s5G0oc1"
FTP_PORT=21
FTP_ROOT=/
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30

# URL Base para acceder a las imágenes públicamente
FTP_URL=https://cascoloco.com/imagenes/QR
```

## ⚠️ Cambios Importantes

### 1. FTP_HOST
- ❌ **Incorrecto**: `FTP_HOST=https://cascoloco.com`
- ✅ **Correcto**: `FTP_HOST=cascoloco.com`

**Razón**: El host FTP no debe incluir el protocolo (`https://` o `http://`). Solo el dominio o IP.

### 2. FTP_PASSWORD
- ✅ **Recomendado**: Usar comillas dobles porque contiene caracteres especiales (`&`)
- `FTP_PASSWORD="2&s5G0oc1"`

**Razón**: El carácter `&` puede causar problemas si no está entre comillas.

### 3. FTP_URL
- ✅ **Correcto**: `FTP_URL=https://cascoloco.com/imagenes/QR`
- **Nota**: Sin barra final (`/`) al final

**Razón**: Las imágenes se guardarán en `usuarios/` dentro de este directorio, así que la URL completa será:
- `https://cascoloco.com/imagenes/QR/usuarios/1234567890.jpg`

## 📁 Estructura de Directorios en el FTP

Asegúrate de que exista esta estructura en tu servidor FTP:

```
/
└── imagenes/
    └── QR/
        └── usuarios/  (esta carpeta se creará automáticamente)
            ├── 1234567890.jpg
            ├── 0987654321.png
            └── ...
```

## 🔧 Pasos para Configurar

1. **Abre tu archivo `.env`** en la raíz del proyecto

2. **Agrega o actualiza estas líneas** (cada una en una línea separada):

```env
FTP_HOST=cascoloco.com
FTP_USERNAME=sumas
FTP_PASSWORD="2&s5G0oc1"
FTP_PORT=21
FTP_ROOT=/
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30
FTP_URL=https://cascoloco.com/imagenes/QR
```

3. **Guarda el archivo**

4. **Limpia la caché de configuración** (opcional pero recomendado):

```bash
php artisan config:clear
php artisan config:cache
```

## ✅ Verificación

Después de configurar, prueba:

1. Crear un usuario con imagen
2. Verificar que la imagen se suba al FTP
3. Verificar que la imagen se muestre correctamente en la aplicación

## 🔍 Solución de Problemas

### Si las imágenes no se suben:
1. Verifica que el usuario FTP `sumas` tenga permisos de escritura en `/imagenes/QR/`
2. Verifica que el modo pasivo esté habilitado (`FTP_PASSIVE=true`)
3. Revisa los logs de Laravel: `storage/logs/laravel.log`

### Si las imágenes no se muestran:
1. Verifica que `FTP_URL` sea accesible públicamente
2. Verifica que la carpeta `/imagenes/QR/usuarios/` tenga permisos de lectura pública
3. Prueba acceder directamente a una imagen: `https://cascoloco.com/imagenes/QR/usuarios/1234567890.jpg`

### Si hay errores de conexión:
1. Verifica que el servidor FTP esté accesible desde tu servidor
2. Verifica que el puerto 21 no esté bloqueado por un firewall
3. Prueba conectarte manualmente con un cliente FTP (FileZilla, etc.)

## 📝 Notas Adicionales

- Las imágenes se guardarán con el nombre del número de cédula: `usuarios/{cedula}.{extension}`
- Si un usuario cambia su número de cédula, la imagen se renombrará automáticamente
- Si un usuario se elimina, su imagen también se eliminará del FTP automáticamente


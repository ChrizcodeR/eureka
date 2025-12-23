# 🚂 Guía de Despliegue en Railway

Esta guía te ayudará a desplegar tu aplicación Laravel en Railway usando Docker.

## 📋 Requisitos Previos

1. Cuenta en [Railway](https://railway.app)
2. Repositorio Git (GitHub, GitLab, o Bitbucket)
3. Base de datos MySQL/PostgreSQL (Railway puede proporcionarla)

## 🚀 Pasos para Desplegar

### 1. Preparar el Repositorio

Asegúrate de que todos los archivos de configuración estén en el repositorio:

- ✅ `Dockerfile` - Configuración de Docker con PHP 8.3
- ✅ `.dockerignore` - Archivos a ignorar en el build de Docker
- ✅ `railway.json` - Configuración de Railway para usar Docker
- ✅ `Procfile` - Define el comando de inicio (opcional con Docker)

**Nota**: Este proyecto usa Docker para tener control total sobre la versión de PHP (8.3) y evitar problemas de compatibilidad con dependencias.

### 2. Conectar con Railway

1. Ve a [railway.app](https://railway.app) e inicia sesión
2. Haz clic en **"New Project"**
3. Selecciona **"Deploy from GitHub repo"** (o tu proveedor Git)
4. Autoriza Railway a acceder a tu repositorio
5. Selecciona el repositorio y la rama que deseas desplegar

### 3. Configurar Variables de Entorno

En el panel de Railway, ve a la pestaña **"Variables"** y agrega las siguientes variables:

#### Variables Requeridas

```env
APP_NAME="Panel Administrativo"
APP_ENV=production
APP_KEY=base64:TU_CLAVE_GENERADA_AQUI
APP_DEBUG=false
APP_URL=https://tu-app.railway.app

DB_CONNECTION=mysql
DB_HOST=containers-us-west-XXX.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=TU_PASSWORD_DE_RAILWAY

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Configuración FTP
FTP_HOST=tu-servidor-ftp.com
FTP_USERNAME=tu_usuario_ftp
FTP_PASSWORD=tu_contraseña_ftp
FTP_PORT=21
FTP_ROOT=/
FTP_PASSIVE=true
FTP_SSL=false
FTP_TIMEOUT=30
FTP_URL=https://tu-servidor-ftp.com/imagenes
```

#### Generar APP_KEY

Si no tienes una `APP_KEY`, puedes generarla localmente:

```bash
php artisan key:generate --show
```

O Railway la generará automáticamente durante el build si no está configurada.

### 4. Configurar Base de Datos

Railway puede crear una base de datos MySQL automáticamente:

1. En el panel de Railway, haz clic en **"New"** → **"Database"** → **"Add MySQL"**
2. Railway creará automáticamente las variables de entorno:
   - `MYSQL_HOST`
   - `MYSQL_PORT`
   - `MYSQL_DATABASE`
   - `MYSQL_USER`
   - `MYSQL_PASSWORD`

3. Actualiza las variables de entorno de tu aplicación para usar estas variables:

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

### 5. Configurar Build y Deploy

Railway usará el `Dockerfile` para construir la imagen de Docker. El proceso de build ejecutará:

1. Instalación de PHP 8.3 y extensiones necesarias
2. Instalación de Composer
3. Instalación de Node.js y npm
4. `composer install --no-dev --optimize-autoloader`
5. `npm ci`
6. `npm run build`
7. Optimización de autoloader y caché de Laravel

El Dockerfile está optimizado para producción y usa PHP 8.3 para cumplir con los requisitos de las dependencias.

### 6. Ejecutar Migraciones

Después del primer despliegue, necesitas ejecutar las migraciones. Tienes dos opciones:

#### Opción A: Usar Railway CLI

```bash
# Instalar Railway CLI
npm i -g @railway/cli

# Iniciar sesión
railway login

# Conectar al proyecto
railway link

# Ejecutar migraciones
railway run php artisan migrate --force
```

#### Opción B: Usar el Panel de Railway

1. Ve a la pestaña **"Deployments"**
2. Haz clic en el despliegue más reciente
3. Abre la terminal
4. Ejecuta: `php artisan migrate --force`

### 7. Configurar Dominio Personalizado (Opcional)

1. En el panel de Railway, ve a **"Settings"** → **"Networking"**
2. Haz clic en **"Generate Domain"** para obtener un dominio de Railway
3. O configura un dominio personalizado en **"Custom Domain"**

### 8. Verificar el Despliegue

Una vez completado el despliegue:

1. Visita la URL proporcionada por Railway
2. Verifica que la aplicación carga correctamente
3. Prueba el login y las funcionalidades principales
4. Revisa los logs en el panel de Railway si hay errores

## 🔧 Configuración Adicional

### Optimización para Producción

El Dockerfile ya incluye todas las optimizaciones necesarias:
- ✅ PHP 8.3 con todas las extensiones necesarias
- ✅ `composer install --no-dev --optimize-autoloader` (optimiza autoloader)
- ✅ `npm run build` (compila assets)
- ✅ `npm prune --production` (elimina dependencias de desarrollo)
- ✅ Caché de configuración, rutas y vistas al iniciar

El contenedor Docker está optimizado para producción y es más eficiente que usar Nixpacks.

### Variables de Entorno Sensibles

⚠️ **Importante**: Nunca subas el archivo `.env` al repositorio. Usa las variables de entorno de Railway para valores sensibles.

### Logs

Los logs de la aplicación están disponibles en:
- Panel de Railway → Pestaña **"Deployments"** → Ver logs
- O usando Railway CLI: `railway logs`

### Storage

Para archivos persistentes, considera usar:
- **Railway Volumes** (para almacenamiento local)
- **AWS S3** o servicios similares (recomendado para producción)
- **FTP** (ya configurado en tu proyecto)

## 🐛 Solución de Problemas

### Error: "APP_KEY is not set" o "MissingAppKeyException"

**Solución Rápida:**

1. **Genera la clave** usando Railway CLI:
   ```bash
   railway run php artisan key:generate --show
   ```

2. **O genera una clave manualmente:**
   ```bash
   php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
   ```

3. **Agrega la variable en Railway:**
   - Ve a **Variables** en el panel de Railway
   - Agrega: `APP_KEY` = `base64:TU_CLAVE_GENERADA`
   - Guarda y espera a que se redespliegue

**Nota:** El Dockerfile intentará generar la clave automáticamente si no existe, pero es mejor configurarla manualmente en Railway para mayor seguridad.

### Error: "Database connection failed"

Solución: 
1. Verifica que la base de datos esté creada en Railway
2. Verifica que las variables de entorno `DB_*` estén correctamente configuradas
3. Asegúrate de usar las variables de referencia de Railway: `${{MySQL.MYSQL_HOST}}`

### Error: "Class not found" o errores de autoload

Solución: El Dockerfile ejecuta `composer install --optimize-autoloader` y `composer dump-autoload --optimize`. Verifica que el build de Docker se complete correctamente. Si el problema persiste, verifica que todas las dependencias estén en `composer.json`.

### Error: "Assets not found" o CSS/JS no carga

Solución: 
1. Verifica que `npm run build` se ejecute durante el build
2. Verifica que la carpeta `public/build` esté presente
3. Asegúrate de que `APP_URL` esté configurada correctamente

### Error: "Permission denied" en storage

Solución: El Dockerfile ya establece los permisos correctos (`chmod -R 775 storage bootstrap/cache`). Si el problema persiste, verifica que los directorios existan y tengan los permisos correctos.

### Error: "PHP version mismatch" o problemas con dependencias

Solución: El Dockerfile usa PHP 8.3 que cumple con todos los requisitos. Si ves errores de versión, verifica que Railway esté usando el Dockerfile y no Nixpacks. En `railway.json` debe estar configurado `"builder": "DOCKERFILE"`.

## 📚 Recursos Adicionales

- [Documentación de Railway](https://docs.railway.app)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Railway PHP Guide](https://docs.railway.app/guides/php)

## ✅ Checklist de Despliegue

- [ ] Repositorio conectado a Railway
- [ ] Variables de entorno configuradas
- [ ] Base de datos creada y conectada
- [ ] `APP_KEY` generada y configurada
- [ ] Migraciones ejecutadas
- [ ] Dominio configurado (opcional)
- [ ] Aplicación accesible y funcionando
- [ ] Logs revisados sin errores críticos
- [ ] Funcionalidades principales probadas

---

¡Tu aplicación debería estar funcionando en Railway! 🎉


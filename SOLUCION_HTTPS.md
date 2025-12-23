# 🔒 Solución: Assets cargando con HTTP en lugar de HTTPS

## Problema
Los assets se están cargando con `http://` en lugar de `https://`, causando problemas de carga o CORS.

**Ejemplo del error:**
```
Request URL: http://eureka.up.railway.app/build/assets/app-Cn9b5u0-.css
```

## Solución

### 1. Configurar APP_URL con HTTPS ⚠️ CRÍTICO

En Railway → Variables, asegúrate de que `APP_URL` use **https://**:

```env
APP_URL=https://eureka.up.railway.app
```

⚠️ **Importante:**
- Debe empezar con `https://` (no `http://`)
- Sin barra final (`/`)
- Debe coincidir exactamente con la URL de Railway

### 2. Limpiar Caché de Vistas

Las vistas compiladas pueden tener las URLs incorrectas en caché. Ejecuta:

```bash
railway run php artisan view:clear
railway run php artisan config:clear
railway run php artisan cache:clear
```

### 3. Regenerar Caché

Después de limpiar, regenera el caché:

```bash
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

### 4. Verificar en el Navegador

1. Abre la consola del navegador (F12)
2. Ve a la pestaña **Network**
3. Recarga la página (Ctrl+F5)
4. Verifica que las URLs de los assets usen `https://`

## Solución Completa (Un Solo Comando)

Ejecuta esto en Railway:

```bash
railway run sh -c 'php artisan view:clear && php artisan config:clear && php artisan cache:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache'
```

O desde el panel de Railway:
1. Ve a **Deployments** → Último despliegue → **Terminal**
2. Ejecuta los comandos uno por uno

## Verificación

Después de configurar `APP_URL` con `https://` y limpiar el caché:

1. ✅ Los assets deberían cargar con `https://`
2. ✅ No deberían aparecer errores de CORS
3. ✅ Los estilos deberían aplicarse correctamente

## Nota sobre Railway

Railway usa un proxy que maneja HTTPS automáticamente. Laravel necesita saber que debe usar HTTPS, por eso es crítico configurar `APP_URL` con `https://`.


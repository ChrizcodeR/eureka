# Usar imagen base de PHP 8.3
FROM php:8.3-cli-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    nodejs \
    npm \
    mysql-client \
    freetype-dev \
    libjpeg-turbo-dev

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    ftp

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de configuración de Composer y NPM primero (para cache de Docker)
COPY composer.json composer.lock ./
COPY package.json package-lock.json* ./

# Instalar dependencias de PHP (sin dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Instalar dependencias de Node.js (necesitamos dev para build)
RUN npm ci

# Copiar el resto de los archivos de la aplicación (excepto lo que ya copiamos)
COPY . .

# Ejecutar scripts post-install de Composer
RUN composer dump-autoload --optimize

# Compilar assets de frontend (esto genera public/build y public/manifest.json)
RUN npm run build

# Limpiar dependencias de desarrollo de Node.js después del build
RUN npm prune --production

# Crear directorios necesarios y establecer permisos
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Usar variable de entorno PORT de Railway, con fallback a 8000
ENV PORT=8000

# Exponer puerto
EXPOSE $PORT

# Comando para iniciar la aplicación
# Railway inyecta la variable PORT automáticamente
# Generar APP_KEY si no existe (fallback, pero mejor configurarla en Railway)
# Limpiar caché antes de regenerar para asegurar URLs correctas
CMD sh -c 'if [ -z "$APP_KEY" ]; then php artisan key:generate --force; fi && php artisan view:clear && php artisan config:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}'


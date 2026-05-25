#!/bin/bash

# Evitar errores de permisos si el volumen se monta con root
chmod -R 777 var/ || true

# Instalar dependencias si no están instaladas
composer install --no-interaction

# Esperar a que MySQL esté levantado (aunque docker-compose depends_on healthcheck lo hace)
echo "Esperando a la base de datos..."
sleep 5

# Crear BD, migrar y cargar fixtures automáticamente
php bin/console doctrine:database:create --if-not-exists -n
php bin/console doctrine:schema:update --force --complete -n
php bin/console doctrine:fixtures:load -n

# Limpiar caché
php bin/console cache:clear

# Ejecutar CMD original (php-fpm)
exec "$@"

#!/bin/bash

# Evitar errores de permisos si el volumen se monta con root
chmod -R 777 var/ || true

# Instalar dependencias si no están instaladas
composer install --no-interaction

# Esperar a que MySQL esté levantado (aunque docker-compose depends_on healthcheck lo hace)
echo "Esperando a la base de datos..."
sleep 5

# Crear BD y migrar
php bin/console doctrine:database:create --if-not-exists -n
php bin/console doctrine:schema:update --force --complete -n

# Solo cargar fixtures si la tabla de usuarios está vacía
USER_COUNT=$(php bin/console dbal:run-sql "SELECT COUNT(*) FROM user" 2>/dev/null | grep -o '[0-9]\+' | tail -n 1)
if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" -eq 0 ]; then
    echo "Base de datos vacía. Cargando fixtures..."
    php bin/console doctrine:fixtures:load -n
else
    echo "La base de datos ya contiene datos. Saltando fixtures para no perder progreso."
fi

# Limpiar caché
php bin/console cache:clear

# Ejecutar CMD original (php-fpm)
exec "$@"

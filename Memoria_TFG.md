# Memoria Técnica del Proyecto: Hello World! Party

## 1. Descripción del Proyecto
- **Objetivos:** Crear una plataforma interactiva que enseñe lógica de programación (JavaScript) a principiantes mediante gamificación extrema, narrativa post-apocalíptica y ejecución de código en tiempo real evaluado estáticamente y dinámicamente.
- **Alcance:** Sistema de autenticación seguro, panel de control de administrador para gestión de lecciones, interfaz de jugador inmersiva, motor de ejecución de código en el navegador e intérprete de errores inteligente.
- **Público Objetivo:** Estudiantes de ciclos formativos sin experiencia previa en programación.

## 2. Arquitectura del Sistema
- **Patrón:** MVC (Modelo-Vista-Controlador).
- **Backend:** Symfony 7/8. Rutas definidas mediante Atributos (`#[Route]`). Controladores ligeros (ej. `LessonController`, `HomeController`) que gestionan la experiencia (XP) y el renderizado.
- **Frontend:** Twig + Tailwind CSS. Integración de Ace Editor para el IDE embebido en la plataforma.
- **Aislamiento:** Todo el sistema se orquesta mediante contenedores Docker, con Nginx sirviendo las peticiones HTTP al contenedor PHP-FPM, conectado a una base de datos MySQL 8.

## 3. Modelo de Datos
El diagrama Entidad-Relación (E/R) consta de las siguientes entidades principales gestionadas por Doctrine ORM:
- `User`: Estudiantes y administradores (email, password_hash, roles, xp, avatar).
- `Course`: Bloques temáticos de aprendizaje ("Mundos" o "Pruebas").
- `Lesson`: Retos individuales dentro de un curso (title, lore, initialCode, expectedOutput).
- `UserProgress`: Tabla pivote que registra la superación de lecciones por los usuarios, guardando el código final (`codeSubmitted`) y si fue completado (`isCompleted`).

## 4. Especificaciones Técnicas
- **Symfony / PHP 8.2:** Elegido por su robustez, seguridad empresarial y ecosistema maduro.
- **MySQL 8:** Motor relacional escalable.
- **Tailwind CSS:** Para un diseño de componentes "Mobile First" sin archivos CSS desorganizados, facilitando una UI "Gamer" moderna.
- **Web Audio API & CSS Keyframes:** Para la capa de "Game Feel" (Juiciness), incluyendo el efecto Typewriter de las cinemáticas y los temblores (Glitch) ante errores críticos de sintaxis.

## 5. Manual de Despliegue
Para levantar este proyecto desde cero en cualquier máquina:
1. Clonar el repositorio.
2. Asegurarse de tener Docker Desktop o Docker Engine instalado.
3. Ejecutar en la raíz del proyecto: `docker compose up -d`
4. El contenedor ejecutará automáticamente `composer install`, creará la base de datos MySQL, forzará la migración del esquema (`doctrine:schema:update`) y cargará las lecciones y usuarios de prueba (`doctrine:fixtures:load`).
5. Acceder a `http://localhost`.

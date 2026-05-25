# Memoria Técnica del Proyecto

**Título del Proyecto:** Hello World! Party - Simulador Hacker Educativo
**Autor:** Fernando

## 1. Descripción del Proyecto
**Objetivos:** 
- Crear una plataforma educativa interactiva que enseñe lógica de programación de forma inmersiva y gamificada.
- Mitigar la frustración inicial de los usuarios sin conocimientos técnicos mediante un entorno seguro, con validaciones en tiempo real y una narrativa absorbente.

**Alcance:** 
Desarrollo Full Stack de la aplicación web. Incluye sistema de roles, base de datos relacional para seguimiento de progreso, editor de código integrado en el navegador y motor de evaluación de JavaScript.

**Público objetivo:**
Estudiantes de ciclos formativos, o cualquier entusiasta tecnológico sin experiencia previa que desee aprender programación desde cero.

## 2. Arquitectura del Sistema
La arquitectura sigue un modelo contenerizado para garantizar el aislamiento y la reproducibilidad total:
- **Capa Cliente (Frontend):** Navegador web interpretando HTML5, Tailwind CSS y Vanilla JS (motor de evaluación y captura de salida estándar).
- **Capa Servidor (Backend):** Contenedor Docker con PHP-FPM ejecutando el framework Symfony 7, actuando como controlador MVC. Contenedor web Nginx o equivalente según `docker-compose`.
- **Capa Persistencia:** Contenedor Docker con MySQL/PostgreSQL gestionado a través de Doctrine.

*Nota: El diagrama de arquitectura de alto nivel debe incluirse gráficamente en el documento PDF entregado.*

## 3. Modelo de Datos
El proyecto emplea una base de datos normalizada con las siguientes entidades principales gestionadas a través de Doctrine ORM:

**Diccionario de Datos y E/R:**
- **User:** Almacena credenciales encriptadas (hashing de seguridad nativo), roles (`ROLE_USER`, `ROLE_ADMIN`), experiencia (`xp`), alias y avatar. Cuenta con validaciones a nivel de entidad (`Assert`).
- **Course:** Agrupa las lecciones temáticas (Mundos). Contiene `title`, `description` y `difficulty`. Relación OneToMany con Lesson.
- **Lesson:** Contiene el reto individual. Almacena `title`, la narrativa inmersiva (`lore`), las instrucciones técnicas (`content`), el código base (`initialCode`) y la salida de consola validada (`expectedOutput`).
- **UserProgress:** Tabla de seguimiento (relación ManyToMany estructurada). Documenta si el reto fue superado (`isCompleted`) y guarda el código exacto introducido por el usuario (`codeSubmitted`) permitiendo una completa auditoría.

## 4. Especificaciones Técnicas
- **Backend - Symfony 7:** Seleccionado por su robustez, patrón MVC estricto y uso avanzado de atributos de PHP (`#[Route]`). Permite delegar la seguridad y el hashing a componentes probados de la industria, manteniendo los controladores ligeros.
- **Base de Datos - MySQL & Doctrine:** Motor relacional estándar para escalabilidad. Doctrine asegura migraciones automatizadas y sincronización del esquema E/R.
- **Frontend - Twig & Tailwind CSS (Mobile First):** Se elige Tailwind CSS por su enfoque de utilidades, permitiendo crear una estética cyberpunk coherente, responsiva y adaptada a móviles, tablets y escritorio. Twig facilita la renderización jerárquica con `base.html.twig`. Los formularios cuentan con validación tanto en cliente como en servidor.
- **Infraestructura - Docker Compose:** Contenerización innegociable. Garantiza que el proyecto levante de manera automática (`docker compose up -d`) con todas sus dependencias sin necesidad de configuraciones manuales en el entorno anfitrión.

## 5. Manual de Despliegue
Para levantar el proyecto de forma 100% reproducible en cualquier máquina mediante contenedores:

1. Extraer el código fuente proporcionado en el archivo comprimido (que no incluye dependencias `vendor`).
2. Abrir una terminal de comandos en el directorio raíz del proyecto extraído.
3. Levantar los contenedores en segundo plano:
   `docker compose up -d`
4. El contenedor ejecutará automáticamente la configuración necesaria:
   - Instalación de dependencias de PHP y Frontend.
   - Ejecución de migraciones de la base de datos (`doctrine:migrations:migrate` o actualización de esquema).
   - Carga de los datos de prueba (`doctrine:fixtures:load`).
5. Abrir el navegador web y acceder a `http://localhost/` o al puerto asignado.

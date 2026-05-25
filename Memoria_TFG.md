# Memoria Técnica del Trabajo de Fin de Grado

**Título del Proyecto:** Hello World! Party - Plataforma Gamificada de Aprendizaje de Lógica de Programación
**Autor:** Fernando (fercoelsano)
**Tecnologías Principales:** Symfony 7, Tailwind CSS, Docker, MySQL, JavaScript

---

## 1. Introducción y Justificación

La programación se ha convertido en una competencia fundamental en el siglo XXI. Sin embargo, los estudiantes sin conocimientos previos a menudo se enfrentan a una curva de aprendizaje pronunciada caracterizada por la abstracción de los conceptos lógicos y la frustración ante los errores de sintaxis.

El proyecto **"Hello World! Party"** nace con el objetivo de mitigar esta barrera de entrada mediante la creación de un entorno inmersivo y seguro. A través de una narrativa post-apocalíptica y el uso intensivo de dinámicas de gamificación, la plataforma transforma el proceso de aprendizaje del lenguaje JavaScript en una experiencia interactiva ("Game Feel"), similar a un videojuego de resolución de puzzles.

## 2. Objetivos del Proyecto

### 2.1. Objetivos Generales
- Diseñar y desarrollar una plataforma web educativa interactiva capaz de evaluar código fuente introducido por el alumno en tiempo real.
- Aumentar la retención y el *engagement* del estudiante mediante mecánicas de gamificación.

### 2.2. Objetivos Específicos
- Implementar un sistema de autenticación y gestión de sesiones seguro.
- Desarrollar un "Clean Editor" embebido basado en Ace Editor que ofrezca una experiencia de programación real en el navegador.
- Diseñar un motor de evaluación en JavaScript puro (Vanilla JS) que evalúe tanto errores de sintaxis (`try-catch`) como errores lógicos (comparación de `console.log` con la salida esperada).
- Migrar y adaptar el diseño de interfaces utilizando el framework **Tailwind CSS** para dotar a la plataforma de una estética "Gamer" moderna y *responsive*.
- Desplegar la arquitectura técnica sobre contenedores **Docker** para garantizar la portabilidad y la independencia del entorno operativo.

## 3. Metodología

Para la consecución de los objetivos se ha adoptado un enfoque de desarrollo ágil basado en entregas incrementales (Fases):
1. **Fase de Configuración:** Preparación del entorno Docker y Symfony.
2. **Fase de Backend y BD:** Diseño de la arquitectura relacional e implementación de entidades Doctrine.
3. **Fase de Frontend:** Diseño del esqueleto UI, posteriormente migrado íntegramente a Tailwind CSS.
4. **Fase de Lógica Core:** Integración del editor y desarrollo del algoritmo de evaluación y captura de salida estándar.
5. **Fase de Pulido (Game Feel):** Incorporación de animaciones CSS (Glitch), sonidos sintetizados (Web Audio API) y narrativa (Storytelling).

## 4. Arquitectura y Análisis del Sistema

### 4.1. Arquitectura a Nivel de Sistema
El proyecto emplea una arquitectura de contenedores orquestada mediante Docker Compose:
- **Nginx (Servidor Web):** Actúa como proxy inverso y servidor de archivos estáticos.
- **PHP-FPM (Procesador):** Ejecuta el núcleo de la aplicación Symfony 7.
- **MySQL 8 (Base de Datos):** Gestiona la persistencia relacional.

### 4.2. Arquitectura de Software
Se sigue rigurosamente el patrón **MVC (Modelo-Vista-Controlador)**:
- **Modelos:** Entidades gestionadas por Doctrine ORM (`User`, `Course`, `Lesson`, `UserProgress`).
- **Controladores:** Clases PHP ligeras enrutadas mediante atributos de PHP 8 (Ej. `LessonController` para procesar la subida del código).
- **Vistas:** Plantillas Twig renderizadas en el servidor, potenciadas con Tailwind CSS y JavaScript para la interactividad cliente-servidor.

### 4.3. Modelo de Datos (Diagrama Entidad-Relación)
- **`User`**: Almacena las credenciales (hasheadas), el rol (Alumno/Profesor) y los Puntos de Experiencia (XP).
- **`Course`**: Modela un "Mundo" o conjunto temático de retos.
- **`Lesson`**: Representa un desafío individual. Almacena el código inicial (`initialCode`), la narrativa introductiva (`lore`) y la validación (`expectedOutput`).
- **`UserProgress`**: Tabla resolutiva (Muchos a Muchos) que enlaza `User` y `Lesson`, documentando si el reto ha sido superado y guardando el `codeSubmitted` para auditoría docente.

## 5. Implementación y Tecnologías Clave

### 5.1. Backend (Symfony & PHP)
Se ha seleccionado Symfony por su arquitectura modular basada en componentes y su robustez empresarial. La carga de datos inicial (Fixtures) asegura que cualquier profesor pueda desplegar el proyecto y probarlo inmediatamente sin configuraciones previas de la base de datos.

### 5.2. Frontend (Tailwind CSS & Twig)
Inicialmente conceptualizado con Bootstrap, el proyecto fue migrado exitosamente a **Tailwind CSS**. Esta migración ha permitido crear componentes modulares (`card-gamer`, `btn-neon-run`) en un archivo CSS central (`app.css`), aplicando directivas `@apply`. El resultado es una interfaz con fondos oscuros, neones dinámicos y sombras difuminadas que aumentan la inmersión del jugador.

### 5.3. Interacción "En Vivo" y Motor de Evaluación
El corazón pedagógico del proyecto reside en `play.html.twig`. Mediante la manipulación del objeto `console` nativo de JavaScript, se interceptan las salidas por terminal del código introducido por el estudiante y se evalúan mediante la función constructora `new Function()`.
Además, se aplican Expresiones Regulares (RegEx) para realizar análisis de código estático ligero, advirtiendo sobre malas prácticas (como el uso de `var`) antes de que el código sea ejecutado.

### 5.4. Aspectos Narrativos y Feedback
Se ha desarrollado un Asistente Inteligente ("El Padre") que detecta la inactividad del alumno (45 segundos) y sus errores consecutivos. Tras 3 intentos fallidos de ejecución, el sistema interviene reproduciendo animaciones CSS tipo Glitch y mostrando mensajes de apoyo en la terminal web para reducir la frustración. Las cinemáticas de entrada emplean la `Web Audio API` para simular la telegrafía antigua.

## 6. Pruebas y Validación

La plataforma ha sido validada siguiendo los casos de uso principales:
- **Flujo de Autenticación:** Verificación de encriptación y acceso restringido (Firewalls).
- **Ejecución Segura:** Comprobación de que el código escrito por el usuario se confina correctamente en el frontend, y que los errores de sintaxis se reportan amigablemente sin romper el UI.
- **Progresión de XP:** Validación de las lógicas transaccionales en el controlador al asignar bonificaciones de XP (+75 por código sin fallos) y actualizarlas en la base de datos de forma asíncrona (Fetch API).

## 7. Conclusiones

La integración de Symfony, Docker y Tailwind CSS ha posibilitado la creación de una plataforma robusta, fácilmente mantenible y altamente atractiva. El proyecto no solo cumple con el requisito de ser un entorno técnico funcional, sino que aporta un valor añadido fundamental al abordar el factor psicológico del aprendizaje de la programación, convirtiendo la frustración del error en una mecánica lúdica superable.

## 8. Manual de Despliegue Rápido (Tribunal)

Dado que el proyecto está contenerizado, los evaluadores solo necesitan seguir estos pasos para iniciar el Búnker 42 en cualquier ordenador:

1. Extraer el código fuente proporcionado en el archivo `.zip`.
2. Abrir una terminal en el directorio extraído.
3. Ejecutar el comando de Docker:
   ```bash
   docker compose up -d
   ```
4. El script `entrypoint.sh` se encargará de forma autónoma de:
   - Instalar las dependencias de PHP (`composer install`).
   - Sincronizar el esquema de la BD MySQL (`php bin/console doctrine:schema:update --force`).
   - Cargar el contenido formativo ("Fixtures").
5. Abrir el navegador web en: `http://localhost/`

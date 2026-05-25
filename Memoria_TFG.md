# Memoria Técnica del Proyecto

**Título del Proyecto:** Hello World! Party — Simulador Hacker Educativo  
**Autor:** Fernando Coelsano (sustituir por nombre completo real)  
**Ciclo Formativo:** (indicar ciclo)  
**Fecha de Entrega:** Mayo 2026  

---

## 1. Descripción del Proyecto

### 1.1 Objetivos

El objetivo principal de este proyecto es el diseño, desarrollo y despliegue de una plataforma de aprendizaje interactiva que enseñe los fundamentos de la lógica de programación mediante una experiencia gamificada e inmersiva.

Los objetivos específicos son los siguientes:

- Ofrecer un entorno seguro de ejecución de código JavaScript directamente en el navegador, sin riesgo para el sistema del usuario.
- Reducir la barrera de entrada a la programación para perfiles sin experiencia técnica previa, mediante una narrativa absorbente y un sistema de progresión por niveles que premie el aprendizaje progresivo.
- Implementar un sistema de evaluación automática que proporcione retroalimentación instantánea sobre la corrección del código introducido por el alumno.
- Garantizar la reproducibilidad total del entorno de ejecución mediante contenedores Docker, asegurando que el proyecto sea desplegable en cualquier máquina sin configuraciones manuales.

### 1.2 Alcance

El proyecto constituye un desarrollo Full Stack completo. Sus módulos principales son:

- **Sistema de autenticación y gestión de usuarios:** Registro, inicio de sesión, edición de perfil y gestión de roles con el componente de seguridad de Symfony.
- **Motor de progresión gamificada:** Sistema de Experiencia (XP), rangos dinámicos, desbloqueo progresivo de mundos y clasificación global (leaderboard).
- **Editor de código integrado:** Integración de Monaco Editor (el motor de Visual Studio Code) directamente en el navegador, con resaltado de sintaxis y autocompletado.
- **Sandbox de evaluación de código:** Motor de validación en JavaScript que intercepta y compara la salida estándar (`console.log`) del código del alumno con la salida esperada, de forma aislada y segura.
- **Panel de administración:** Interfaz back-office completa basada en EasyAdmin para la gestión de cursos, lecciones, usuarios y progreso.
- **Infraestructura contenerizada:** Entorno Docker Compose con Nginx, PHP-FPM y MySQL listo para despliegue en un único comando.

### 1.3 Público Objetivo

La plataforma está orientada a:

- Estudiantes de ciclos formativos de informática o similares que se inician en la programación.
- Cualquier persona sin experiencia técnica previa que desee aprender lógica de programación de forma autodidacta y entretenida.
- Docentes que busquen una herramienta interactiva para complementar sus clases con ejercicios prácticos guiados.

---

## 2. Arquitectura del Sistema

La aplicación sigue una **arquitectura de tres capas** completamente contenerizada mediante Docker Compose, lo que garantiza el aislamiento de cada capa y la reproducibilidad del entorno en cualquier máquina.

```
┌─────────────────────────────────────────────┐
│              NAVEGADOR (Cliente)            │
│  HTML5 · Tailwind CSS · Monaco Editor · JS  │
└───────────────────┬─────────────────────────┘
                    │ HTTP
┌───────────────────▼─────────────────────────┐
│         CONTENEDOR WEB (Nginx:alpine)        │
│      Proxy inverso · Puerto 80               │
└───────────────────┬─────────────────────────┘
                    │ FastCGI (php-fpm)
┌───────────────────▼─────────────────────────┐
│       CONTENEDOR PHP (PHP 8.2-FPM)          │
│   Symfony 7 · MVC · Servicios · Seguridad   │
└───────────────────┬─────────────────────────┘
                    │ PDO / Doctrine ORM
┌───────────────────▼─────────────────────────┐
│      CONTENEDOR BD (MySQL 8.0)              │
│   Esquema normalizado · Volumen persistente  │
└─────────────────────────────────────────────┘
```

- **Capa Cliente (Frontend):** El navegador web interpreta las plantillas Twig renderizadas por Symfony. Los estilos se gestionan con Tailwind CSS (Mobile First) y la interactividad se implementa con Vanilla JavaScript. El editor de código Monaco y el motor sandbox de evaluación operan íntegramente en el cliente.
- **Capa Servidor (Backend):** Contenedor PHP-FPM ejecutando Symfony 7 bajo el patrón MVC estricto. Los controladores son ligeros y delegan la lógica de negocio a servicios. Nginx actúa como proxy inverso, sirviendo los assets estáticos directamente y redirigiendo las peticiones PHP al contenedor de aplicación.
- **Capa de Persistencia:** MySQL 8.0 gestionado exclusivamente a través de Doctrine ORM. Los datos se persisten en un volumen Docker dedicado, garantizando que no se pierdan entre reinicios del contenedor.

> **Nota:** El diagrama de arquitectura de alto nivel debe incluirse como imagen en el documento PDF entregado.

---

## 3. Modelo de Datos

El esquema de la base de datos está totalmente normalizado. Las entidades principales gestionadas a través de Doctrine ORM son las siguientes:

### 3.1 Diagrama Entidad-Relación (E/R)

```
┌──────────┐       ┌──────────────┐       ┌──────────┐
│   User   │───────│ UserProgress │───────│  Lesson  │
└──────────┘  1:N  └──────────────┘  N:1  └──────────┘
                                               │ N:1
                                           ┌───▼──────┐
                                           │  Course  │
                                           └──────────┘
```

> **Nota:** El diagrama E/R completo con todos los atributos debe incluirse como imagen en el documento PDF entregado.

### 3.2 Diccionario de Datos

#### Entidad `User`
| Atributo | Tipo | Descripción |
|---|---|---|
| `id` | INT (PK) | Identificador único auto-incremental |
| `email` | VARCHAR (UNIQUE) | Correo electrónico. Usado como identificador de login |
| `username` | VARCHAR | Alias visible del jugador en la plataforma |
| `password` | VARCHAR | Contraseña hasheada con el algoritmo bcrypt nativo de Symfony |
| `roles` | JSON | Array de roles (`ROLE_USER`, `ROLE_ADMIN`) |
| `xp` | INT | Puntos de experiencia acumulados |
| `avatar` | VARCHAR (nullable) | Semilla para la generación del avatar en DiceBear |

#### Entidad `Course` (Mundo)
| Atributo | Tipo | Descripción |
|---|---|---|
| `id` | INT (PK) | Identificador único |
| `title` | VARCHAR | Título del mundo (ej. "Prueba 1: Restauración Básica") |
| `description` | TEXT | Descripción narrativa del mundo |
| `difficulty` | VARCHAR | Nivel de dificultad (Fácil / Media / Difícil) |

**Relaciones:** `OneToMany` con `Lesson` (un curso contiene múltiples lecciones).

#### Entidad `Lesson` (Misión)
| Atributo | Tipo | Descripción |
|---|---|---|
| `id` | INT (PK) | Identificador único |
| `title` | VARCHAR | Título de la lección |
| `lore` | TEXT | Narrativa inmersiva de la misión (formato HTML) |
| `content` | TEXT | Instrucciones técnicas del manual (formato HTML) |
| `initialCode` | TEXT | Código de partida preescrito en el editor |
| `expectedOutput` | VARCHAR | Cadena de texto exacta que debe producir el código correcto |
| `course_id` | INT (FK) | Referencia al curso al que pertenece |

**Relaciones:** `ManyToOne` con `Course`.

#### Entidad `UserProgress` (Progreso)
| Atributo | Tipo | Descripción |
|---|---|---|
| `id` | INT (PK) | Identificador único |
| `user_id` | INT (FK) | Referencia al usuario |
| `lesson_id` | INT (FK) | Referencia a la lección completada |
| `isCompleted` | BOOLEAN | Indica si el reto fue superado correctamente |
| `codeSubmitted` | TEXT | Código exacto enviado por el usuario (auditoría completa) |

**Relaciones:** `ManyToOne` con `User` y `ManyToOne` con `Lesson`. Implementa una relación ManyToMany estructurada con datos adicionales.

---

## 4. Especificaciones Técnicas

### 4.1 Backend — Symfony 7

Symfony 7 es el framework PHP seleccionado por su madurez, su estricta adherencia al patrón MVC y su ecosistema de componentes de calidad industrial. Las decisiones técnicas clave son:

- **Controladores ligeros con `#[Route]`:** La lógica de negocio compleja se delega a servicios, manteniendo los controladores como simples puntos de entrada HTTP.
- **Seguridad nativa:** El componente `symfony/security-bundle` gestiona la autenticación, la autorización por roles y el hashing de contraseñas (bcrypt), sin implementaciones manuales propensas a errores.
- **Validaciones con `Assert`:** Las entidades cuentan con restricciones declarativas (`#[Assert\NotBlank]`, `#[Assert\Email]`, etc.) que se aplican tanto en los formularios del servidor como a nivel de ORM.
- **Panel de Administración — EasyAdmin:** Se integra `EasyCorp/EasyAdminBundle` para ofrecer un back-office CRUD completo para la gestión de todas las entidades, accesible exclusivamente a usuarios con `ROLE_ADMIN`.

### 4.2 Base de Datos — MySQL 8.0 y Doctrine ORM

MySQL 8.0 es el motor relacional seleccionado por su amplia adopción en el sector y su compatibilidad con Doctrine. Doctrine ORM permite:

- Definir el esquema de base de datos directamente desde las entidades PHP (enfoque Code-First).
- Gestionar las migraciones de forma automatizada (`doctrine:migrations`).
- Abstraer las consultas SQL mediante el lenguaje DQL y el QueryBuilder, desacoplando la lógica de negocio del motor de base de datos específico.

### 4.3 Frontend — Twig, Tailwind CSS y Monaco Editor

- **Twig:** Motor de plantillas de Symfony que permite una estructura jerárquica sólida basada en `base.html.twig`. Facilita la separación de responsabilidades y la reutilización de componentes de interfaz mediante herencia de plantillas y bloques (`{% block %}`).
- **Tailwind CSS (Mobile First):** Framework de utilidades CSS seleccionado por su flexibilidad para construir una estética cyberpunk coherente y completamente responsiva. El diseño se ha validado en dispositivos móviles desde 320px hasta monitores de escritorio. **No se emplean estilos en línea arbitrarios**; los únicos valores dinámicos en línea son los generados por la lógica de negocio de Twig (como el porcentaje de la barra de progreso de XP).
- **Monaco Editor:** El motor del editor de código de Visual Studio Code, integrado vía CDN. Proporciona al alumno una experiencia de edición profesional con resaltado de sintaxis JavaScript, autocompletado y detección de errores en tiempo real.
- **Sandbox de Evaluación (Vanilla JS):** Motor de evaluación seguro implementado en JavaScript del lado del cliente. Intercepta la función nativa `console.log` para capturar la salida estándar del código del alumno, ejecuta el código en un contexto controlado con `try/catch` para gestionar excepciones, y compara el resultado obtenido con el `expectedOutput` almacenado en la base de datos. Si la salida coincide, se registra el progreso vía una petición al backend de Symfony.

### 4.4 Infraestructura — Docker Compose

La contenerización con Docker Compose es un requisito innegociable del proyecto. El archivo `docker-compose.yaml` define tres servicios:

| Servicio | Imagen | Función |
|---|---|---|
| `web` | `nginx:alpine` | Servidor web y proxy inverso. Sirve assets estáticos y redirige peticiones PHP a php-fpm |
| `php` | `php:8.2-fpm` (custom) | Ejecuta la aplicación Symfony. El `entrypoint.sh` automatiza el arranque |
| `database` | `mysql:8.0` | Motor de base de datos con healthcheck y volumen persistente |

El `entrypoint.sh` del contenedor PHP automatiza completamente el arranque: instala dependencias con Composer, crea la base de datos si no existe, ejecuta las migraciones o actualización de esquema, carga los datos de prueba (Fixtures) y limpia la caché de Symfony. Esto garantiza que `docker compose up -d` sea el único comando necesario.

### 4.5 Dependencias Clave

| Paquete | Versión | Propósito |
|---|---|---|
| `symfony/framework-bundle` | ^7.0 | Núcleo del framework |
| `symfony/security-bundle` | ^7.0 | Autenticación y autorización |
| `doctrine/orm` | ^3.0 | ORM y gestión de entidades |
| `doctrine/doctrine-fixtures-bundle` | ^3.0 | Datos de prueba automatizados |
| `easycorp/easyadmin-bundle` | ^4.0 | Panel de administración |
| `symfony/twig-bundle` | ^7.0 | Motor de plantillas |
| `tailwindcss` | via CDN | Framework de estilos |
| Monaco Editor | via CDN | Editor de código en el navegador |

---

## 5. Manual de Despliegue

El proyecto es 100% reproducible en cualquier máquina con Docker instalado. No se requiere PHP, Composer, Node.js ni MySQL en el sistema anfitrión.

### 5.1 Requisitos previos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado y en ejecución.
- Git (opcional, para clonar el repositorio).

### 5.2 Pasos de despliegue

**Paso 1 — Obtener el código fuente**

Descomprimir el archivo `.zip` de entrega en el directorio deseado. El archivo no incluye las carpetas `vendor` ni `node_modules` (se instalan automáticamente).

```bash
# Alternativa: clonar desde el repositorio
git clone https://github.com/Fercosano/tfg.git
cd tfg/tfg_auth
```

**Paso 2 — Levantar los contenedores**

Abrir una terminal en el directorio raíz del proyecto (donde se encuentra el archivo `docker-compose.yaml`) y ejecutar:

```bash
docker compose up -d
```

**Paso 3 — Esperar al arranque automático**

El contenedor PHP ejecutará automáticamente, en orden, los siguientes procesos:
1. `composer install` — Instalación de dependencias PHP.
2. `doctrine:database:create --if-not-exists` — Creación de la base de datos.
3. `doctrine:schema:update --force` — Sincronización del esquema E/R.
4. `doctrine:fixtures:load` — Carga de datos de prueba.
5. `cache:clear` — Limpieza de la caché de Symfony.

Este proceso tarda aproximadamente **2-3 minutos** en la primera ejecución.

**Paso 4 — Acceder a la aplicación**

Una vez que los contenedores estén en estado `healthy`, abrir el navegador y acceder a:

- **Aplicación principal:** [http://localhost](http://localhost)
- **Panel de administración:** [http://localhost/admin](http://localhost/admin)

### 5.3 Credenciales de prueba

| Rol | Email | Contraseña |
|---|---|---|
| Administrador (Padre) | `admin@bunker42.com` | `admin` |
| Alumno de prueba | `alumno@bunker42.com` | `123456` |

### 5.4 Detener los contenedores

```bash
docker compose down
```

Para detener y eliminar también el volumen de la base de datos (reinicio completo):

```bash
docker compose down -v
```

---

*Fin de la Memoria Técnica*

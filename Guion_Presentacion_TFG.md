# Guion Estricto para la Defensa del TFG (15 minutos)

Este guion está cronometrado y adaptado **exactamente** a los requisitos exigidos por el tribunal en el último documento (duración máxima 15 minutos).
*Recuerda: Tu presentación de diapositivas debe ser formato 16:9, usar esquemas/diagramas en lugar de mucho texto, y si muestras código, debe estar resaltado y con fuente monoespaciada.*

---

## 1. Introducción (2 min)
- **El Problema (1 min):** "Buenos días al tribunal. Aprender a programar suele ser un proceso abstracto y frustrante para principiantes. El índice de abandono es altísimo porque las consolas no perdonan errores sintácticos y carecen de un feedback amable o humano."
- **La Solución Propuesta (1 min):** "Para solucionar esto y acercar el código a todos los públicos, he desarrollado *Hello World! Party*, una aplicación web Full Stack que transforma el aprendizaje de la lógica en un videojuego inmersivo. Utilizo mecánicas de gamificación, una narrativa inmersiva (donde el usuario es un aprendiz de hacker que debe relevar a su padre agotado) y un motor de evaluación en tiempo real."

## 2. Arquitectura y Tecnologías (3 min)
- **Backend (Symfony):** "El núcleo del sistema está construido sobre Symfony siguiendo estrictamente el patrón MVC. He utilizado Controladores muy ligeros enrutados mediante atributos `#[Route]` y el componente Security para encriptar contraseñas mediante hashing robusto y separar los roles de Usuario (Jugador) y Administrador (Game Master)."
- **Frontend (Twig + Tailwind CSS):** "La interfaz no es un simple formulario. Utilicé el motor Twig con una estructura jerárquica modular y un `base.html.twig` sólido. Elegí integrar Tailwind CSS bajo la filosofía Mobile First. Esta decisión tecnológica me permitió crear una experiencia de usuario (UX) única y una interfaz de usuario 'Dark/Gamer' sumamente pulida, sin estilos en línea ni archivos desorganizados."
- **Contenerización (Docker):** "La aplicación es 100% reproducible. Todo está encapsulado utilizando Docker Compose. La infraestructura levanta automáticamente el servidor web, PHP-FPM y la base de datos de manera aislada, sin requerir intervención manual para su despliegue."

## 3. Modelo de Datos (2 min)
*(Asegúrate de mostrar el Diagrama Entidad-Relación final en esta diapositiva).*
- "A nivel de base de datos, el proyecto utiliza Doctrine ORM y está fuertemente normalizado con relaciones sólidas (OneToMany y ManyToMany). Consta de 4 entidades clave:"
- **User:** "Almacena la identidad y aplica las aserciones de validación (`Assert`). También guarda los puntos de experiencia (XP) base de la gamificación."
- **Course y Lesson:** "Relacionados One-to-Many. Agrupan los mundos y almacenan el contenido didáctico y el *lore* narrativo de cada nivel."
- **UserProgress:** "Esta es la tabla fundamental. Una relación Many-to-Many entre usuario y lección que funciona como tabla de auditoría. No solo registra que el nivel fue superado, sino que guarda exactamente el `codeSubmitted` (código enviado) por el usuario para prevenir fraudes y auditar su nivel."

## 4. Demostración Práctica / Demo (6 min)
*(Abre el navegador, todo debe estar corriendo previamente).*
1. **Registro y Login (1 min):** Muestra cómo el formulario cuenta con validación HTML5. Regístrate en directo. Muestra cómo el login seguro redirige al Dashboard.
2. **Dashboard de Juego (1 min):** Enseña el cálculo dinámico del nivel, el Rango (ej. Chatarrero del Búnker), la barra de progreso de XP y la capacidad de modificar tu Avatar y Alias (UX inmersiva).
3. **El Motor Central (3 min):**
   - Entra a una lección. Deja que se aprecie la UI, el Lore (historia de tu padre) y el Editor limpio.
   - Demuestra robustez: Equivócate a propósito. Escribe código inválido. Muestra cómo el motor del cliente atrapa el error (`try/catch`) y "El Padre" avisa del error de sintaxis sin que el servidor se caiga y sin errores de consola visibles.
   - Resuelve el nivel. Muestra cómo se evalúa el código frente al `expectedOutput` y cómo la app celebra y otorga experiencia dinámica.
4. **Backend/Auditoría (1 min):** Inicia sesión como Admin. Entra en el panel de control y enséñale al tribunal cómo la tabla de "Progreso" ha registrado en base de datos la línea de código exacta que acabas de ejecutar. Esto demuestra que "cumples lo prometido en la memoria".

## 5. Conclusiones y Trabajo Futuro (2 min)
- **Lecciones aprendidas:** "A lo largo de este proyecto he conseguido dominar el ciclo completo de un desarrollador Full Stack: desde el diseño de la arquitectura y la contenerización con Docker, hasta la creación de un motor evaluador seguro en Vanilla JS interactuando con un backend Symfony sólido."
- **Mejoras Futuras:** "El código limpio y la arquitectura MVC dejan la puerta abierta a escalar el proyecto rápidamente, por ejemplo añadiendo un sistema de WebSockets para visualizar a otros usuarios programando en tiempo real, o una API REST completa para una futura app móvil."
- "Gracias por su atención. Quedo a disposición del tribunal para las preguntas."

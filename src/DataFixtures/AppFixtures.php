<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // ==============================================
        // 1. CREACIÓN DE USUARIOS DE PRUEBA
        // ==============================================
        $admin = new \App\Entity\User();
        $admin->setEmail('admin@bunker42.com');
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setUsername('Ingeniero Jefe (Padre)');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setXp(9999);
        $manager->persist($admin);

        $student = new \App\Entity\User();
        $student->setEmail('alumno@bunker42.com');
        $student->setRoles(['ROLE_USER']);
        $student->setUsername('Novato42');
        $student->setPassword($this->hasher->hashPassword($student, '123456'));
        $student->setXp(0);
        $manager->persist($student);

        // ==============================================
        // PRUEBA 1: RESTAURACIÓN BÁSICA
        // ==============================================
        $course1 = new Course();
        $course1->setTitle('Prueba 1: Restauración Básica');
        $course1->setDescription('La infraestructura del Búnker 42 ha fallado. Aprende a manipular el terminal central usando la sintaxis olvidada (Variables y Salidas de texto).');
        $course1->setDifficulty('Fácil');
        $manager->persist($course1);

        $lesson1_1 = new Lesson();
        $lesson1_1->setTitle('1.1. Reinicio del Terminal');
        $lesson1_1->setLore('<p><strong>Señal de Radio:</strong></p><p>Hijo, los generadores principales han colapsado y el sistema de soporte vital está cayendo. Necesito que restaures la consola principal.</p><p>La IA del Búnker requiere que le hables usando el comando de impresión clásico para saber que sigues con vida.</p>');
        $lesson1_1->setContent('<strong>Manual Técnico:</strong><br/>- Usa el comando <code>console.log()</code> para imprimir texto.<br/>- Escribe exactamente: <code>"Hola Bunker"</code>.<br/>- Recuerda que el texto puro (strings) debe ir entre comillas.');
        $lesson1_1->setInitialCode('// Inicia la terminal saludando a la IA' . "\n\n");
        $lesson1_1->setExpectedOutput('Hola Bunker');
        $lesson1_1->setCourse($course1);
        $manager->persist($lesson1_1);

        $lesson1_2 = new Lesson();
        $lesson1_2->setTitle('1.2. Inventario de Sobrevivientes');
        $lesson1_2->setLore('<p><strong>Señal de Radio:</strong></p><p>Bien hecho. El terminal ha despertado. Ahora necesitamos saber a cuánta gente tenemos que alimentar. Usa una "variable" para almacenar ese número en la memoria de la máquina.</p>');
        $lesson1_2->setContent('<strong>Manual Técnico:</strong><br/>- Usa <code>let</code> para declarar una variable llamada <code>sobrevivientes</code>.<br/>- Asígnale el valor numérico <code>42</code>.<br/>- Imprime la variable usando <code>console.log(sobrevivientes)</code>.');
        $lesson1_2->setInitialCode("let sobrevivientes = \n\n");
        $lesson1_2->setExpectedOutput('42');
        $lesson1_2->setCourse($course1);
        $manager->persist($lesson1_2);

        $lesson1_3 = new Lesson();
        $lesson1_3->setTitle('1.3. Cálculo de Raciones');
        $lesson1_3->setLore('<p><strong>Señal de Radio:</strong></p><p>Tenemos a los sobrevivientes, pero las raciones son escasas. Tenemos cajas de latas de comida y botellas de agua. Haz que la terminal calcule el total de suministros combinados.</p>');
        $lesson1_3->setContent('<strong>Manual Técnico:</strong><br/>- Crea una variable <code>comida</code> con valor 15.<br/>- Crea una variable <code>agua</code> con valor 10.<br/>- Imprime la suma matemática de ambas variables.');
        $lesson1_3->setInitialCode("let comida = 15;\nlet agua = 10;\n\n// Imprime la suma de los suministros\n");
        $lesson1_3->setExpectedOutput('25');
        $lesson1_3->setCourse($course1);
        $manager->persist($lesson1_3);

        // ==============================================
        // PRUEBA 2: REDIRECCIÓN ENERGÉTICA
        // ==============================================
        $course2 = new Course();
        $course2->setTitle('Prueba 2: Redirección Energética');
        $course2->setDescription('La energía es limitada. Debes aprender a tomar decisiones automáticas usando la lógica condicional (IF / ELSE) para desviar la energía donde se necesita.');
        $course2->setDifficulty('Media');
        $manager->persist($course2);

        $lesson2_1 = new Lesson();
        $lesson2_1->setTitle('2.1. Sellado de Cuarentena');
        $lesson2_1->setLore('<p><strong>Alarma del Sistema:</strong></p><p>¡Peligro biológico en el Sector C! Necesitamos que la puerta se bloquee automáticamente si detecta radiación.</p>');
        $lesson2_1->setContent('<strong>Manual Técnico:</strong><br/>- Si la variable <code>radiacion</code> es verdadera (<code>true</code>), imprime "Puerta Sellada".<br/>- Usa una estructura condicional <code>if () { ... }</code>.');
        $lesson2_1->setInitialCode("let radiacion = true;\n\n// Escribe tu condicional aquí\n");
        $lesson2_1->setExpectedOutput('Puerta Sellada');
        $lesson2_1->setCourse($course2);
        $manager->persist($lesson2_1);

        $lesson2_2 = new Lesson();
        $lesson2_2->setTitle('2.2. Distribuidor de Energía');
        $lesson2_2->setLore('<p><strong>Señal de Radio:</strong></p><p>Hijo, el generador no da para todo. Si la energía cae por debajo de 50, enciende el motor auxiliar. Si no, mantén el modo ahorro.</p>');
        $lesson2_2->setContent('<strong>Manual Técnico:</strong><br/>- La variable <code>energia</code> vale 40.<br/>- Si es menor que 50 (<code>< 50</code>), imprime "Motor Auxiliar".<br/>- De lo contrario (<code>else</code>), imprime "Modo Ahorro".');
        $lesson2_2->setInitialCode("let energia = 40;\n\n// Completa la lógica\nif (energia < 50) {\n  \n} else {\n  \n}");
        $lesson2_2->setExpectedOutput('Motor Auxiliar');
        $lesson2_2->setCourse($course2);
        $manager->persist($lesson2_2);

        $lesson2_3 = new Lesson();
        $lesson2_3->setTitle('2.3. Acceso Restringido');
        $lesson2_3->setLore('<p><strong>Panel de Seguridad:</strong></p><p>Para entrar al búnker VIP, no basta con tener la llave, además hay que tener la huella digital autorizada. Requerimos doble confirmación.</p>');
        $lesson2_3->setContent('<strong>Manual Técnico:</strong><br/>- Usa el operador lógico AND (<code>&&</code>) para comprobar múltiples condiciones.<br/>- Si <code>tieneLlave</code> es true Y <code>tieneHuella</code> es true, imprime "Acceso Permitido".');
        $lesson2_3->setInitialCode("let tieneLlave = true;\nlet tieneHuella = true;\n\nif (tieneLlave && tieneHuella) {\n  console.log(\"Acceso Permitido\");\n}\n");
        $lesson2_3->setExpectedOutput('Acceso Permitido');
        $lesson2_3->setCourse($course2);
        $manager->persist($lesson2_3);

        // ==============================================
        // PRUEBA 3: ALGORITMO CENTRAL
        // ==============================================
        $course3 = new Course();
        $course3->setTitle('Prueba 3: Algoritmo Central');
        $course3->setDescription('Para automatizar las defensas del Búnker, tendrás que entender cómo repetir acciones masivamente (Bucles) y empaquetar código (Funciones).');
        $course3->setDifficulty('Difícil');
        $manager->persist($course3);

        $lesson3_1 = new Lesson();
        $lesson3_1->setTitle('3.1. Secuencia de Calentamiento');
        $lesson3_1->setLore('<p><strong>Señal de Radio:</strong></p><p>Los motores están fríos. Para arrancarlos, necesitamos enviar una secuencia de impulsos del 1 al 3. Si lo haces a mano, tardarás demasiado. ¡Usa un bucle!</p>');
        $lesson3_1->setContent('<strong>Manual Técnico:</strong><br/>- Usa un bucle <code>for</code> que vaya del 1 al 3 (inclusive).<br/>- Dentro del bucle, usa <code>console.log()</code> para imprimir el número de impulso actual.');
        $lesson3_1->setInitialCode("// Inicia el bucle for aquí\nfor(let i = 1; i <= 3; i++) {\n  \n}");
        $lesson3_1->setExpectedOutput("1\n2\n3");
        $lesson3_1->setCourse($course3);
        $manager->persist($lesson3_1);

        $lesson3_2 = new Lesson();
        $lesson3_2->setTitle('3.2. Purga de Toxinas');
        $lesson3_2->setLore('<p><strong>Alarma del Sistema:</strong></p><p>Aire contaminado. Tienes 3 filtros de purga. Usa un bucle while para purgar mientras te queden filtros, y luego avisa de que has terminado.</p>');
        $lesson3_2->setContent('<strong>Manual Técnico:</strong><br/>- Usa un bucle <code>while (filtros > 0)</code>.<br/>- Imprime el número del filtro, réstale 1 a la variable, y al terminar el bucle, imprime "Aire Limpio".');
        $lesson3_2->setInitialCode("let filtros = 3;\n\nwhile (filtros > 0) {\n  console.log(filtros);\n  // No olvides restar 1 a filtros (filtros--)\n  \n}\n\n// Imprime Aire Limpio al acabar");
        $lesson3_2->setExpectedOutput("3\n2\n1\nAire Limpio");
        $lesson3_2->setCourse($course3);
        $manager->persist($lesson3_2);

        $lesson3_3 = new Lesson();
        $lesson3_3->setTitle('3.3. Protocolo de Reparación');
        $lesson3_3->setLore('<p><strong>Señal de Radio:</strong></p><p>Hijo, estoy muy orgulloso. Eres oficialmente un Arquitecto del Refugio. Ahora encapsula tu conocimiento en una función reutilizable para que la IA la ejecute cuando no estemos.</p>');
        $lesson3_3->setContent('<strong>Manual Técnico:</strong><br/>- Crea una función llamada <code>reparar</code>.<br/>- Haz que la función retorne (<code>return</code>) el texto "Sistema Operativo".<br/>- Finalmente, imprime el resultado ejecutando <code>console.log(reparar());</code>.');
        $lesson3_3->setInitialCode("function reparar() {\n  // Retorna el string pedido\n}\n\n");
        $lesson3_3->setExpectedOutput("Sistema Operativo");
        $lesson3_3->setCourse($course3);
        $manager->persist($lesson3_3);

        $manager->flush();
    }
}

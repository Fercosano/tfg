<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear Curso de JavaScript
        $course = new Course();
        $course->setTitle('Fundamentos de JavaScript');
        $course->setDescription('Aprende la lógica básica de programación utilizando JavaScript. Ideal para principiantes absolutos.');
        $course->setDifficulty('Fácil');
        $manager->persist($course);

        // Lección 1: Hola Mundo
        $lesson1 = new Lesson();
        $lesson1->setTitle('1. Tu primer Hola Mundo');
        $lesson1->setContent('En programación, lo primero que aprendemos es a saludar. Utiliza la función console.log("Hola Mundo") para imprimir este mensaje clásico.');
        $lesson1->setInitialCode('// Escribe tu código aquí debajo' . "\n\n");
        $lesson1->setExpectedOutput('Hola Mundo');
        $lesson1->setCourse($course);
        $manager->persist($lesson1);

        // Lección 2: Variables
        $lesson2 = new Lesson();
        $lesson2->setTitle('2. Variables y Almacenamiento');
        $lesson2->setContent('Las variables nos permiten guardar datos. Crea una variable llamada "edad", asígnale el valor 25, e imprímela utilizando console.log(edad).');
        $lesson2->setInitialCode("let edad = \n\n");
        $lesson2->setExpectedOutput('25');
        $lesson2->setCourse($course);
        $manager->persist($lesson2);

        // Lección 3: Operaciones Básicas
        $lesson3 = new Lesson();
        $lesson3->setTitle('3. Operaciones Matemáticas');
        $lesson3->setContent('Crea dos variables: "a" con valor 10 y "b" con valor 5. Luego imprime la suma de ambas usando console.log(a + b).');
        $lesson3->setInitialCode("let a = 10;\nlet b = 5;\n\n// Imprime la suma\n");
        $lesson3->setExpectedOutput('15');
        $lesson3->setCourse($course);
        $manager->persist($lesson3);

        $manager->flush();
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            \EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField::new('course', 'Curso Asignado'),
            TextField::new('title', 'Título de la Lección'),
            TextEditorField::new('lore', 'Lore (Cinemática y Contexto de la Misión)'),
            TextEditorField::new('content', 'Pistas y Soporte Técnico (Consola)'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField::new('initialCode', 'Código Inicial')->setLanguage('js'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField::new('expectedOutput', 'Salida Esperada en Consola (Exacta)'),
        ];
    }
}

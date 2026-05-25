<?php

namespace App\Controller\Admin;

use App\Entity\UserProgress;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserProgressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserProgress::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            \EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField::new('user', 'Usuario'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField::new('lesson', 'Reto/Lección'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField::new('isCompleted', '¿Completado?'),
            \EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField::new('codeSubmitted', 'Código Enviado')
                ->setLanguage('javascript')
                ->hideOnIndex(), // Lo ocultamos en la lista para que no ocupe mucho espacio
        ];
    }
}

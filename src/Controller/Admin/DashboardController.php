<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // Redirigir al CRUD de Cursos por defecto
        $adminUrlGenerator = $this->container->get(\EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CourseCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hello World! Party - Backend');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Aprendizaje');
        yield MenuItem::linkTo(CourseCrudController::class, 'Cursos', 'fas fa-book');
        yield MenuItem::linkTo(LessonCrudController::class, 'Lecciones (Retos)', 'fas fa-code');
        
        yield MenuItem::section('Usuarios y Progreso');
        yield MenuItem::linkTo(UserCrudController::class, 'Usuarios', 'fas fa-users');
        yield MenuItem::linkTo(UserProgressCrudController::class, 'Progreso', 'fas fa-chart-line');
        
        yield MenuItem::section('Volver');
        yield MenuItem::linkToRoute('Ir al Frontend', 'fas fa-arrow-left', 'app_home');
    }
}

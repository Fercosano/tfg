<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function root(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/home', name: 'app_home')]
    public function index(CourseRepository $courseRepository, \App\Repository\UserProgressRepository $progressRepo): Response
    {
        // Obtenemos todos los cursos para listarlos en el Dashboard
        $courses = $courseRepository->findBy([], ['id' => 'ASC']);
        
        $completedLessons = [];
        $rankName = 'Chatarrero del Búnker'; // Rango inicial por defecto
        
        if ($this->getUser()) {
            $progresses = $progressRepo->findBy(['user' => $this->getUser(), 'isCompleted' => true]);
            foreach ($progresses as $p) {
                $completedLessons[] = $p->getLesson()->getId();
            }
            
            // Lógica dinámica de Rangos Narrativos
            $numCompleted = count($completedLessons);
            if ($numCompleted >= 9) {
                $rankName = 'Arquitecto del Refugio';
            } elseif ($numCompleted >= 7) {
                $rankName = 'Administrador de la Red';
            } elseif ($numCompleted >= 4) {
                $rankName = 'Ingeniero de Sistemas';
            } elseif ($numCompleted >= 1) {
                $rankName = 'Técnico de Mantenimiento';
            }
        }

        return $this->render('home/index.html.twig', [
            'courses' => $courses,
            'completedLessons' => $completedLessons,
            'rankName' => $rankName,
        ]);
    }

    #[Route('/change-username', name: 'app_change_username', methods: ['POST'])]
    public function changeUsername(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $newUsername = $request->request->get('username');
        if ($newUsername && trim($newUsername) !== '') {
            $user->setUsername(trim($newUsername));
            $em->flush();
        }

        return $this->redirectToRoute('app_home');
    }
}

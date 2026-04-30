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
    public function index(CourseRepository $courseRepository): Response
    {
        // Obtenemos el primer curso disponible para mostrar la introducción al nivel 1
        $firstCourse = $courseRepository->findOneBy([], ['id' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'course' => $firstCourse,
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

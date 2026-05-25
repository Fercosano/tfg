<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\UserProgress;
use App\Repository\LessonRepository;
use App\Repository\UserProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lesson')]
final class LessonController extends AbstractController
{
    #[Route('/{id}/story', name: 'app_lesson_story')]
    public function story(Lesson $lesson): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('lesson/story.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/{id}/play', name: 'app_lesson_play')]
    public function play(Lesson $lesson): Response
    {
        // Obligamos a estar logueado para jugar
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('lesson/play.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    #[Route('/{id}/submit', name: 'app_lesson_submit', methods: ['POST'])]
    public function submit(Lesson $lesson, Request $request, EntityManagerInterface $em, UserProgressRepository $upRepository): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        
        $codeSubmitted = $data['code'] ?? '';
        $success = $data['success'] ?? false;
        $failedAttempts = $data['failedAttempts'] ?? 0;

        if ($success) {
            // Buscamos si ya existe el progreso para no duplicarlo (y no dar XP infinitos)
            $progress = $upRepository->findOneBy(['user' => $user, 'lesson' => $lesson]);
            
            $xpEarned = 0;
            if (!$progress) {
                // Nuevo progreso, asignar XP
                $progress = new UserProgress();
                $progress->setUser($user);
                $progress->setLesson($lesson);
                
                // Bonificación por Excelencia: Si lo resuelve a la primera (0 fallos), x1.5 XP
                $xpEarned = ($failedAttempts === 0) ? 75 : 50;
                $user->setXp($user->getXp() + $xpEarned);
            }
            
            $progress->setCompleted(true);
            $progress->setCodeSubmitted($codeSubmitted);
            
            $em->persist($progress);
            $em->flush();
            
            return new JsonResponse(['status' => 'success', 'xp_earned' => $xpEarned, 'total_xp' => $user->getXp()]);
        }

        return new JsonResponse(['status' => 'error'], 400);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ScoreController extends AbstractController
{

    //LISTE DES SCORES
    #[Route('/score', name: 'app_score')]
    public function listScores(ScoreRepository $scoreRepository): Response
    {
        $scores = $scoreRepository->findAll();

        return $this->render('score/index.html.twig', [
            'scores' => $scores,
        ]);
    }
}

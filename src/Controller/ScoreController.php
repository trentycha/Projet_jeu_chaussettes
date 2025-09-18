<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Score;
use App\Form\ScoreType;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ScoreController extends AbstractController
{

    //LISTE DES SCORES
    #[Route('/score', name: 'score')]
    public function listScores(ScoreRepository $scoreRepository): Response
    {
        $scores = $scoreRepository->findAll();

        return $this->render('score/index.html.twig', [
            'scores' => $scores,
        ]);
    }

    //AJOUTER UN SCORE
    #[Route('/score/add', name: 'add_score')]
    public function addScore(Request $request, EntityManagerInterface $entityManager): Response
    {
        $score = new Score();
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($score);
            $entityManager->flush();

            $this->addFlash('success', 'Le score a été ajouté avec succès !');

            return $this->redirectToRoute('app_score');
        }

        return $this->render('score/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
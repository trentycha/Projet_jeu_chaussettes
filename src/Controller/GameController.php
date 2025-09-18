<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ScoreRepository;
use App\Entity\Score;
use App\Form\ScoreType;


final class GameController extends AbstractController
{
    #[Route('/game', name: 'game')]
    public function index(Request $request, EntityManagerInterface $entityManager, ScoreRepository $scoreRepository): Response
    {

        $score = new Score();

    

        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le score dans la base de données
            $entityManager->persist($score);
            $entityManager->flush();

            $this->addFlash('success', 'Score ajouté avec succès !');

        }

        $bestScores = $scoreRepository->findBy([], ['time' => 'ASC'], 4);

        return $this->render('game/index.html.twig', [
            'form' => $form->createView(),
            'bestScores' => $bestScores,
        ]);
    }
}

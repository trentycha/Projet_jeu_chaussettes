<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class ArticleController extends AbstractController
{

    //LISTE DES ARTICLES
    #[Route('/article', name: 'article')]
    public function listArticles(ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    //CREER UN ARTICLE
    
    #[Route('/article/create', name: 'create_article')]
    #[IsGranted('ROLE_USER')]
    public function createArticle(Request $request,EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setUser($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'L\'article a été créé avec succès !');
            return $this->redirectToRoute('article');
        }

        $formView = $form->createView();
        $user = $this->getUser();

        return $this->render('article/create.html.twig', [
            'user' => $user,
            'form' => $formView,
        ]);
    }   

    //SUPPRIMER UN ARTICLE
    #[Route('/article/delete/{id}', name: 'delete_article')]
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = $articleRepository->find($id);

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'L\'article a été supprimé avec succès !');

        return $this->redirectToRoute('article');
}

    //MODIFIER UN ARTICLE
    #[Route('/article/update/{id}', name: 'update_article')]
    public function updateArticle($id, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = $articleRepository->find($id);

        if(!$article){
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('success', 'L\'article a été modifié avec succès !');
            return $this->redirectToRoute('article');
        }


        $formView = $form->createView();
        $user = $this->getUser();

        return $this->render('article/update.html.twig', [
            'user' => $user,
            'form' => $formView,
        ]);
    }

    //VOIR UN ARTICLE
    #[Route('/article/show/{id}', name: 'show_article')]
    public function showArticle($id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);

        if(!$article){
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        $user = $this->getUser();

        return $this->render('article/show.html.twig', [
            'user' => $user,
            'article' => $article,
        ]);
    }
}
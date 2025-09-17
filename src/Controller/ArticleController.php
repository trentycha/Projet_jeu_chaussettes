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
    public function createArticle(Request $request,EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article created successfully!');
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

        $this->addFlash('success', 'Article deleted successfully!');

        return $this->redirectToRoute('article');
}

    //MODIFIER UN ARTICLE
    #[Route('/article/update/{id}', name: 'update_article')]
    public function updateArticle($id, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = $articleRepository->find($id);

        if(!$article){
            throw $this->createNotFoundException('The article does not exist');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('success', 'Article updated successfully!');
            return $this->redirectToRoute('article');
        }


        $formView = $form->createView();
        $user = $this->getUser();

        return $this->render('article/update.html.twig', [
            'user' => $user,
            'form' => $formView,
        ]);
    }
}


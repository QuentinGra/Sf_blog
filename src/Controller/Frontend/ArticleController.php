<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles', name: 'app.articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('Frontend/Articles/index.html.twig', [
            'articles' => $articleRepository->findActive(),
        ]);
    }
}

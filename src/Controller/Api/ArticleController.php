<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api/articles', name: 'api.articles')]
class ArticleController extends AbstractController
{
    private Serializer $serializer;

    public function __construct(
        private ArticleRepository $articleRepository,
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
    ) {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $this->serializer = new Serializer([$normalizer]);
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $articles = $this->articleRepository->findAll();

        $data = $this->serializer->normalize($articles, 'json', [
            'groups' => 'article:read',
        ]);

        return $this->json([
            'articles' => $data,
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(?Article $article): JsonResponse
    {
        if (!$article) {
            return $this->json([
                'status' => '404',
                'message' => 'Article not found',
            ], 404);
        }

        $data = $this->serializer->normalize($article, 'json', [
            'groups' => 'article:read',
        ]);

        return $this->json([
            'article' => $data,
        ]);
    }

    #[Route('/create', name: '.create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        $user = $this->userRepository->find($data->user);

        if (!$user) {
            return $this->json([
                'status' => '404',
                'message' => 'User not found',
            ], 404);
        }

        $article = (new Article())
            ->setTitle($data->title)
            ->setContent($data->content)
            ->setEnable($data->enable)
            ->setUser($user);

        $this->em->persist($article);
        $this->em->flush();

        return $this->json([
            'status' => '201',
            'message' => 'Article created successfully',
        ], 201);
    }

    #[Route('/{id}/update', name: '.update', methods: ['PATCH'])]
    public function update(?Article $article, Request $request): JsonResponse
    {
        if (!$article) {
            return $this->json([
                'status' => '404',
                'message' => 'Article not found',
            ], 404);
        }

        $data = json_decode($request->getContent());

        $user = $this->userRepository->find($data->user);

        if (!$user) {
            return $this->json([
                'status' => '404',
                'message' => 'User not found',
            ], 404);
        }

        $article
            ->setTitle($data->title)
            ->setContent($data->content)
            ->setEnable($data->enable)
            ->setUser($user);

        $this->em->persist($article);
        $this->em->flush();

        return $this->json([
            'status' => '201',
            'message' => 'Artcticle updated successfully',
        ], 201);
    }
}

<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news', methods:['GET'])]
    public function allArticles(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(News::class);
        $allArticles = $repository->findAll();
        $articleArray = [];
        foreach ($allArticles as $article) {
            $articleArray[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'authors' => $article->getAuthors(),
                'create_date' => $article->getCreateDate()
            ];
        }
        return $this->json($articleArray);
    }

    #[Route('/news/{id}', name: 'app_news_article', methods:['GET'])]
    public function article(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $repository = $entityManager->getRepository(News::class);
        $article = $repository->findByIdWithAuthors(['id' => $id]);

        return $this->json($article);
    }
}

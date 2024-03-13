<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\News;
use App\Validator\FormValidator;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news', methods:['GET'])]
    public function allArticles(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(News::class);
        $news = $repository->findAllWithAuthors();
        return $this->json($news);
    }

    #[Route('/news/{id}', name: 'app_news_article', methods:['GET'])]
    public function article(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $repository = $entityManager->getRepository(News::class);
        $article = $repository->findByIdWithAuthors(['id' => $id]);

        return $this->json($article);
    }

    #[Route('/news/add', name: 'app_news_article_add', methods:['POST'])]
    public function articleAdd(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $news = new News;
        $authorRepository = $entityManager->getRepository(Author::class);
        $formValidator = new FormValidator;

        $data = json_decode($request->getContent(), true);
        $errors['title'] = $formValidator->nameField($data['title']) ? : $formValidator->nameField($data['title']);
        $errors['content'] = $formValidator->contentField($data['content']);
        $errors['authors'] = $formValidator->authorsField($data['authors']);
        if(count($errors['title']) <= 0 && count($errors['content']) <= 0  && count($errors['authors']) <= 0) {
            $news->setTitle($data['title']);
            $news->setContent($data['content']);
            $news->setCreateDate(new DateTimeImmutable());
            foreach ($data['authors'] as $id) {
                $author = $authorRepository->find($id);
                if($author){
                    $news->addAuthor($author);
                }
            }

            return $this->send($news, $entityManager);
        } else {
            return new JsonResponse([
                'status' => '400',
                'message' => $errors
            ], 400);
        }
    }

    #[Route('/news/{id}', name: 'app_news_article_edit', methods:['POST'])]
    public function articleEdit(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $formValidator = new FormValidator;

        $repository = $entityManager->getRepository(News::class);
        $authorRepository = $entityManager->getRepository(Author::class);

        $article = $repository->find($id);
        $data = json_decode($request->getContent(), true);

        $errors['title'] = $formValidator->nameField($data['title']);
        $errors['content'] = $formValidator->contentField($data['content']);
        $errors['authors'] = $formValidator->authorsField($data['authors']);

        if(count($errors['title']) <= 0 && count($errors['content']) <= 0 && count($errors['authors']) <= 0) {
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            foreach ($data['authors'] as $id) {
                $author = $authorRepository->find($id);
                if($author){
                    $article->addAuthor($author);
                }
            }
            return $this->send($article, $entityManager);
        } else {
            return new JsonResponse([
                'status' => '400',
                'message' => $errors,
            ], 400);
        }
    }

    private function send(News $news, EntityManagerInterface $entityManager) : JsonResponse
    {
        $entityManager->beginTransaction();
        try {
            $entityManager->persist($news);
            $entityManager->flush();
            $entityManager->commit();
        } catch (\Exception $exception) {
            $entityManager->rollback();
            return new JsonResponse([
                'status' => 'Faliure',
                'message' => $exception->getMessage()
            ]);
        }
        return new JsonResponse([
            'status' => '201',
            'message' => 'Success'
        ], 201);
    }
}

<?php

namespace App\Controller;

use App\Entity\Author;
use App\Validator\FormValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'app_authors', methods: ['GET'])]
    public function authors(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(Author::class);
        $authors = $repository->findAllWithNews();
        
        return $this->json($authors);
    }

    #[Route('/author/{id}', name: 'app_author', methods: ['GET'])]
    public function author(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $repository = $entityManager->getRepository(Author::class);
        $author = $repository->findByIdWithNews($id);

        return $this->json($author);
    }

    #[Route('/author/{id}', name: 'app_author_edit', methods:['POST'])]
    public function articleEdit(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $formValidator = new FormValidator;
        $repository = $entityManager->getRepository(Author::class);

        $author = $repository->find($id);
        $data = json_decode($request->getContent(), true);

        $errors = $formValidator->nameField($data['name']);

        if(count($errors) <= 0) {
            $author->setName($data['name']);
            return $this->send($author, $entityManager);
        } else {
            return new JsonResponse([
                'status' => '400',
                'message' => $errors,
            ], 400);
        }
    }

    #[Route('/author/add', name: 'app_author_add', methods: ['POST'])]
    public function authorAdd(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $author = new Author;
        $formValidator = new FormValidator;

        $data = json_decode($request->getContent(), true);
        $errors = $formValidator->nameField($data['name']);

        if(count($errors) <= 0) {
            $author->setName($data['name']);
            return $this->send($author, $entityManager);
        } else {
            return new JsonResponse([
                'status' => '400',
                'message' => $errors
            ], 400);
        }
    }

    #[Route('/author/top/{top}', name: 'app_author', methods: ['GET'])]
    public function topAuthors(EntityManagerInterface $entityManager, int $top): JsonResponse
    {
        $repository = $entityManager->getRepository(Author::class);
        $authors = $repository->findTopAuthorsOfTheWeek($top, $entityManager);

        return $this->json($authors);
    }

    private function send(Author $author, EntityManagerInterface $entityManager) : JsonResponse
    {
        $entityManager->beginTransaction();
        try {
            $entityManager->persist($author);
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
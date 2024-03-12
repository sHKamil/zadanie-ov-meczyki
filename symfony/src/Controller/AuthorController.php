<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'app_authors')]
    public function authors(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(Author::class);
        $authors = $repository->findAll();
        $authorsArray = [];
        
        foreach ($authors as $author) {
            $authorsArray[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
            ];
        }

        return $this->json($authorsArray);
    }

    #[Route('/author/{id}', name: 'app_author')]
    public function author(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $repository = $entityManager->getRepository(Author::class);
        $author = $repository->findByIdWithNews($id);

        return $this->json($author);
    }
}

<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findAllWithAuthors(): array
    {
        $news = $this->findAll();
        $newsWithAuthors = [];

        foreach ($news as $article) {
            $newsCollection = $article->getAuthors();
            $authorsArray = [];
            foreach ($newsCollection as $news) {
                $authorsArray[] = [
                    'id' => $news->getId(),
                    'name' => $news->getName(),
                ];
            }
            $newsWithAuthors[] = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'create_date' => $article->getCreateDate(),
                'authors' => $authorsArray
            ];
        }

        return $newsWithAuthors;
    }

    public function findByIdWithAuthors(int $id): array
    {
        $news = $this->find($id);
        if($news) {
            $authorsCollection = $news->getAuthors();

            $authorsArray = [];
            foreach ($authorsCollection as $author) {
            $authorsArray[] = [
                    'id' => $author->getId(),
                    'name' => $author->getName()
                ];
            }
            
            return [
                'id' => $news->getId(),
                'title' => $news->getTitle(),
                'content' => $news->getContent(),
                'create_date' => $news->getCreateDate(),
                'authors' => $authorsArray
            ];
        }
        return [];
    }
}

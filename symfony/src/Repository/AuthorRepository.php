<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findAllWithNews(): array
    {
        $authors = $this->findAll();
        $authorsWithNews = [];

        foreach ($authors as $author) {
            $newsCollection = $author->getNews();
            $newsArray = [];
            foreach ($newsCollection as $news) {
                $newsArray[] = [
                    'id' => $news->getId(),
                    'title' => $news->getTitle(),
                    'content' => $news->getContent(),
                    'create_date' => $news->getCreateDate()
                ];
            }
            $authorsWithNews[] = [
                'id' => $author->getId(),
                'name' => $author->getName(),
                'articles' => $newsArray
            ];
        }

        return $authorsWithNews;
    }

    public function findByIdWithNews(int $id): array
    {
        $author = $this->find($id);
        if($author) {
            $newsCollection = $author->getNews();

            $newsArray = [];
            foreach ($newsCollection as $news) {
            $newsArray[] = [
                    'id' => $news->getId(),
                    'title' => $news->getTitle(),
                    'content' => $news->getContent(),
                    'create_date' => $news->getCreateDate()
                ];
            }
            
            return [
                'id' => $author->getId(),
                'name' => $author->getName(),
                'articles' => $newsArray
            ];
        }
        return [];
    }

    public function findByIdOnlyNews(int $id): array
    {
        $author = $this->find($id);
        if($author) {
            $newsCollection = $author->getNews();

            $newsArray = [];
            foreach ($newsCollection as $news) {
            $newsArray[] = [
                    'id' => $news->getId(),
                    'title' => $news->getTitle(),
                    'content' => $news->getContent(),
                    'create_date' => $news->getCreateDate()
                ];
            }
            
            return [
                'articles' => $newsArray
            ];
        }
        return [];
    }

    public function findTopAuthorsOfTheWeek(int $top, EntityManagerInterface $entityManager)
    {
        $weekStartDate = new \DateTime('monday this week');
        $weekEndDate = new \DateTime('sunday this week');

        $query = $entityManager->createQueryBuilder();

        $query
        ->select('a.id AS id, a.name AS name, COUNT(n.id) AS news_count')
        ->from('App\Entity\Author', 'a')
        ->join('a.news', 'n')
        ->where($query->expr()->between('n.create_date', ':weekStart', ':weekEnd'))
        ->groupBy('a.id')
        ->orderBy('news_count', 'DESC')
        ->setMaxResults($top)
        ->setParameter('weekStart', $weekStartDate)
        ->setParameter('weekEnd', $weekEndDate);

        $authorsOfTheWeek = $query->getQuery()->getResult();

        return $authorsOfTheWeek;
    }
}

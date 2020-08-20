<?php

namespace App\Repository;

use App\Entity\Trick;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    // /**
    //  * @return an array with all tricks plus its featured image if it has one
    //  */
    public function findAllWithFeatured(int $currentPage = 1): Paginator
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder()
            ->select('t.id', 't.title', 't.lastUpdate', 'i.content')
            ->from('App\Entity\Trick', 't')
            ->leftJoin('t.images', 'i', 'WITH', 't.featured = i.id')
            ->orderBy('t.lastUpdate', 'DESC')
        ;

        return (new Paginator($query))->paginate($currentPage);
    }

    public function findOneByIdWithCategoryAndFeatured(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT t.id, t.title, t.description, t.created, t.lastUpdate, c.name, i.content AS featured
            FROM App\Entity\Trick t
            LEFT JOIN App\Entity\Image i
            WITH t.featured = i.id
            JOIN App\Entity\Category c
            WHERE t.id = :id
            AND t.category = c.id'
        )->setParameter('id', $id);

        return $query->getSingleResult();
    }
}

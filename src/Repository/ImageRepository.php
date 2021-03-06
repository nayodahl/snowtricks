<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function getImagesFromTrick(int $trickId): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Image i
            JOIN App\Entity\Trick t
            WHERE i.trick = t.id
            AND t.id = :id'
        )->setParameter('id', $trickId);

        return $query->getResult();
    }
}

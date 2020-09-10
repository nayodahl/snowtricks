<?php

namespace App\Repository;

use App\Entity\Trick;
use App\Service\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    private $params;

    public function __construct(ManagerRegistry $registry, ParameterBagInterface $params)
    {
        parent::__construct($registry, Trick::class);
        $this->params = $params;
    }

    // /**
    //  * @return an array with all tricks plus its featured image if it has one
    //  */
    public function findAllWithFeatured(int $currentPage = 1): Paginator
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder('t')
            ->select('t, i')
            ->from('App\Entity\Trick', 't')
            ->leftJoin('t.images', 'i', 'WITH', 'i.featured = 1')
            ->orderBy('t.lastUpdate', 'DESC')
        ;

        return (new Paginator($query, $this->params->get('app.max_trick_number')))->paginate($currentPage);
    }

    public function findOneByIdWithCategoryAndFeatured(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT t.id, t.title, t.description, t.created, t.lastUpdate, t.slug, c.name AS category, i AS featured
            FROM App\Entity\Trick t
            LEFT JOIN App\Entity\Image i
            WITH i.featured = true
            AND i.trick = :id
            JOIN App\Entity\Category c
            WHERE t.id = :id
            AND t.category = c.id'
        )->setParameter('id', $id);

        return $query->getSingleResult();
    }
}

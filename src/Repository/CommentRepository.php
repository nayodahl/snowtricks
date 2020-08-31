<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findAllCommentsFromTrick(int $trickId, int $currentPage = 1): Paginator
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQueryBuilder()
            ->select('c.content', 'c.created', 'u.photo', 'u.username')
            ->from('App\Entity\Comment', 'c')
            ->join('c.user', 'u')
            ->where('c.user = u.id')
            ->andWhere('c.trick = :id')
            ->orderBy('c.created', 'DESC')
            ->setParameter('id', $trickId)
        ;

        return (new Paginator($query))->paginate($currentPage);
    }
}

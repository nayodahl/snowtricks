<?php

namespace App\Service;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator
{
    private $queryBuilder;
    private $currentPage;
    private $pageSize;
    private $results;
    private $numResults;

    public function __construct(DoctrineQueryBuilder $queryBuilder, int $pageSize)
    {
        $this->queryBuilder = $queryBuilder;
        $this->pageSize = $pageSize;
    }

    public function paginate(int $page = 1): self
    {
        $this->pageSize = $this->pageSize * $page;
        $this->currentPage = max(1, $page);
        $firstResult = 0;

        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->pageSize)
            ->getQuery();

        $paginator = new DoctrinePaginator($query, true);
        $paginator->setUseOutputWalkers(false);
        $this->results = $paginator->getIterator();
        $this->numResults = $paginator->count();

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return (int) ceil($this->numResults / $this->pageSize);
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    public function getNextPage(): int
    {
        return $this->currentPage + 1;
    }

    public function hasToPaginate(): bool
    {
        return $this->numResults > $this->pageSize;
    }

    public function getNumResults(): int
    {
        return $this->numResults;
    }

    public function getResults(): \Traversable
    {
        return $this->results;
    }
}

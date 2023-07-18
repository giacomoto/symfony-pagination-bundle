<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\Trait;

use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\Pagination;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

trait TRepositoryHasPagination
{
    /**
     * @param Pagination $pagination
     * @param QueryBuilder $queryBuilder
     * @return array
     */
    function paginated(Pagination $pagination, QueryBuilder $queryBuilder): array
    {
        return $queryBuilder
            ->setFirstResult(($pagination->getPage() - 1) * $pagination->getSize())
            ->setMaxResults(($pagination->getPage() * $pagination->getSize()) - (($pagination->getPage() - 1) * $pagination->getSize()))
            ->getQuery()
            ->getResult();
    }

    /**
     * @param QueryBuilder|null $queryBuilder
     * @return int
     */
    function paginatedTotal(?QueryBuilder $queryBuilder = null): int
    {
        if (!$queryBuilder) {
            $queryBuilder = $this->createQueryBuilder('xx')
                ->select('count(xx)');
        }

        try {
            return $queryBuilder
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException|NoResultException $e) {
            return 0;
        }
    }
}

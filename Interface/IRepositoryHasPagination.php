<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\Interface;

use Doctrine\ORM\QueryBuilder;
use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\Pagination;

interface IRepositoryHasPagination {
    /**
     * @param Pagination $pagination
     * @param QueryBuilder $queryBuilder
     * @return array
     */
    function paginated(Pagination $pagination, QueryBuilder $queryBuilder): array;

    /**
     * @param QueryBuilder|null $queryBuilder
     * @return int
     */
    function paginatedTotal(?QueryBuilder $queryBuilder = null): int;
}

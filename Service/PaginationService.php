<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\Service;

use Giacomoto\Bundle\GiacomotoPaginationBundle\Class\Pagination;
use Symfony\Component\HttpFoundation\Request;

class PaginationService
{
    protected array $allowedSizes = [];

    public function __construct(
        protected int $defaultSize,
        string        $allowedSizes,
    )
    {
        $this->allowedSizes = array_map(static fn($size) => (int)$size, explode(',', trim($allowedSizes)));
    }

    public function createFromRequest(Request $request): Pagination
    {
        $page = $request->query->get('page', 1);
        $size = $request->query->get('size', $this->defaultSize);

        $page = is_numeric($page) ? (int)$page : 1;
        $size = is_numeric($size) ? (int)$size : $this->defaultSize;

        if (!in_array($size, $this->allowedSizes)) {
            $size = $this->defaultSize;
        }

        return new Pagination($page, $size);
    }
}

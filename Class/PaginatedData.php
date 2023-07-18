<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\Class;

class PaginatedData {
    public function __construct(
        private readonly array $data,
        private readonly int $total,
    )
    {
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}

<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\Class;

use JetBrains\PhpStorm\ArrayShape;

class Pagination
{
    public function __construct(
        private readonly int $page,
        private readonly int $size,
    )
    {
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    #[ArrayShape(['page' => "int", 'size' => "int"])]
    public function serialize(): array
    {
        return [
            "page" => $this->getPage(),
            "size" => $this->getSize(),
        ];
    }
}

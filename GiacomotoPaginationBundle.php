<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GiacomotoPaginationBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}

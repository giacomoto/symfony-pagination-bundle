<?php

namespace Giacomoto\Bundle\GiacomotoPaginationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Bundle\MakerBundle\DependencyInjection\Configuration;

class GiacomotoPaginationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $loader = new YamlFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $containerBuilder->setParameter('giacomoto_pagination.default_size', $configs[0]['default_size']);
        $containerBuilder->setParameter('giacomoto_pagination.allowed_sizes', $configs[0]['allowed_sizes']);
    }
}

<?php

namespace Yrial\Simrandom\Infrastructure\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class YrialSimrandomExtension extends Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('generator.challenges', $config['generator']['challenges']);
        $container->setParameter('generator.randomizers', $config['generator']['randomizers']);
    }
}
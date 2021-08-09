<?php

namespace Yrial\Simrandom\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

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
        $container->setParameter('generator.randomizers.list', array_keys($config['generator']['randomizers']));
        foreach ($config['generator']['randomizers'] as $randomizer => $value) {
            $container->setParameter("generator.randomizers.$randomizer", $value);
        }
    }
}
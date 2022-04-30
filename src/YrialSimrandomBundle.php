<?php

namespace Yrial\Simrandom;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Yrial\Simrandom\Infrastructure\DependencyInjection\YrialSimrandomExtension;

class YrialSimrandomBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new YrialSimrandomExtension();
    }
}
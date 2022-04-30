<?php

namespace Yrial\Simrandom\Tests\Infrastructure\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Yrial\Simrandom\Infrastructure\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{

    public function testGetConfigTreeBuilder()
    {
        $conf = new Configuration();
        $this->assertInstanceOf(TreeBuilder::class, $conf->getConfigTreeBuilder());
    }
}

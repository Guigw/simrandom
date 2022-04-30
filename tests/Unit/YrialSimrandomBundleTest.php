<?php

namespace Yrial\Simrandom\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Infrastructure\DependencyInjection\YrialSimrandomExtension;
use Yrial\Simrandom\YrialSimrandomBundle;

class YrialSimrandomBundleTest extends TestCase
{

    public function testGetContainerExtension()
    {
        $bundle = new YrialSimrandomBundle();
        $this->assertInstanceOf(YrialSimrandomExtension::class, $bundle->getContainerExtension());
    }
}

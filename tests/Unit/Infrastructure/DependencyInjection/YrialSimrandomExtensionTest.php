<?php
namespace Yrial\Simrandom\Tests\Unit\Infrastructure\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yrial\Simrandom\Infrastructure\DependencyInjection\Configuration;
use Yrial\Simrandom\Infrastructure\DependencyInjection\YrialSimrandomExtension;

class YrialSimrandomExtensionTest extends TestCase
{

    use ProphecyTrait;

    /**
     * @throws ReflectionException
     */
    public function testLoad()
    {
        $conf = [
            'yrial_simrandom' => [
                'generator' => [
                    'challenges' => [],
                    'randomizers' => [
                        'letter' => [],
                        'budget' => []
                    ]
                ]
            ]
        ];

        $mockedContainer = $this->prophesize(ContainerBuilder::class);
        $mockedContainer->getReflectionClass(Argument::is(Configuration::class))->shouldBeCalledOnce()->willReturn(new ReflectionClass(Configuration::class));
        $mockedContainer->setParameter(Argument::any(), Argument::any())->shouldBeCalledTimes(2);
        $extension = new YrialSimrandomExtension();
        $extension->load($conf, $mockedContainer->reveal());


    }
}

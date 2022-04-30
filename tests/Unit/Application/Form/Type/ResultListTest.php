<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Form\Type;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yrial\Simrandom\Application\Form\Type\ResultList;
use Yrial\Simrandom\Domain\Dto\Input\ResultListDTO;

class ResultListTest extends TestCase
{
    use ProphecyTrait;

    public function testBuildForm()
    {
        $type = new ResultList();
        $mock = $this->prophesize(FormBuilderInterface::class);
        $mock->add(Argument::is('name'), Argument::is(TextType::class))->shouldBeCalledOnce()->willReturn($mock);
        $mock->add(Argument::is('resultList'), Argument::is(EntityType::class), Argument::type('array'))->shouldBeCalledOnce()->willReturn($mock);;
        $type->buildForm($mock->reveal(), []);

    }

    public function testConfigureOptions()
    {
        $type = new ResultList();
        $mock = $this->prophesize(OptionsResolver::class);
        $mock->setDefaults(Argument::is([
            'data_class' => ResultListDTO::class,
            'csrf_protection' => false,
        ]))->shouldBeCalledOnce()->willReturn($mock);
        $type->configureOptions($mock->reveal());
    }
}

<?php

namespace Yrial\Simrandom\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\HttpFoundation\Request;
use Yrial\Simrandom\Controller\RandomizerController;
use Yrial\Simrandom\Generator\BudgetGenerator;
use Yrial\Simrandom\Generator\BuildingsGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\RoomsGenerator;
use Yrial\Simrandom\Generator\ShapeLetterGenerator;

class RandomizerControllerTest extends TestCase
{
    use ProphecyTrait;

    public function testBudget()
    {
        $controller = new RandomizerController();
        $mockedRandomizer = $this->prophesize(BudgetGenerator::class);
        $mockedRandomizer->getRandom()->shouldBeCalled()->willReturn(12345);
        $this->assertEquals(12345, $controller->budget($mockedRandomizer->reveal()));
    }

    public function testLetter()
    {
        $controller = new RandomizerController();
        $mockedRandomizer = $this->prophesize(ShapeLetterGenerator::class);
        $mockedRandomizer->getRandom()->shouldBeCalled()->willReturn('X');
        $this->assertEquals('X', $controller->letter($mockedRandomizer->reveal()));
    }

    public function testColors()
    {
        $controller = new RandomizerController();
        $request = new Request(['number' => 42]);
        $mockedRandomizer = $this->prophesize(ColorsGenerator::class);
        $mockedRandomizer->setNumber(Argument::is(42))->shouldBeCalledOnce()->willReturn($mockedRandomizer);
        $mockedRandomizer->getRandom()->shouldBeCalledOnce()->willReturn([1, 2, 3, 4, 5]);
        $this->assertEquals('1, 2, 3, 4, 5', $controller->colors($mockedRandomizer->reveal(), $request, 0));
    }

    public function testColorsDefaultNumber()
    {
        $controller = new RandomizerController();
        $request = new Request();
        $mockedRandomizer = $this->prophesize(ColorsGenerator::class);
        $mockedRandomizer->setNumber(Argument::is(3))->shouldBeCalledOnce()->willReturn($mockedRandomizer);
        $mockedRandomizer->getRandom()->shouldBeCalledOnce()->willReturn([1, 2, 3, 4, 5]);
        $this->assertEquals('1, 2, 3, 4, 5', $controller->colors($mockedRandomizer->reveal(), $request, 3));
    }

    public function testRooms()
    {
        $controller = new RandomizerController();
        $mockedRandomizer = $this->prophesize(RoomsGenerator::class);
        $mockedRandomizer->getRandom()->shouldBeCalled()->willReturn(12345);
        $this->assertEquals(12345, $controller->rooms($mockedRandomizer->reveal()));
    }

    public function testBuildings()
    {
        $controller = new RandomizerController();
        $mockedRandomizer = $this->prophesize(BuildingsGenerator::class);
        $mockedRandomizer->getRandom()->shouldBeCalled()->willReturn('Empire State Building');
        $this->assertEquals('Empire State Building', $controller->buildings($mockedRandomizer->reveal()));
    }
}

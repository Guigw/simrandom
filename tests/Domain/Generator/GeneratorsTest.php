<?php

namespace Yrial\Simrandom\Tests\Domain\Generator;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Generator\BudgetGenerator;
use Yrial\Simrandom\Domain\Generator\BuildingGenerator;
use Yrial\Simrandom\Domain\Generator\ColorsGenerator;
use Yrial\Simrandom\Domain\Generator\Generators;
use Yrial\Simrandom\Domain\Generator\RoomsGenerator;
use Yrial\Simrandom\Domain\Generator\ShapeGenerator;

class GeneratorsTest extends TestCase
{

    public function testGetGenerator()
    {
        $this->assertInstanceOf(BudgetGenerator::class, Generators::Budget->getGenerator());
        $this->assertInstanceOf(RoomsGenerator::class, Generators::Rooms->getGenerator());
        $this->assertInstanceOf(ShapeGenerator::class, Generators::Shape->getGenerator());
        $this->assertInstanceOf(BuildingGenerator::class, Generators::Buildings->getGenerator());
        $this->assertInstanceOf(ColorsGenerator::class, Generators::Colors->getGenerator());
    }

    public function testValues()
    {
        $values = Generators::cases();
        $this->assertCount(5, $values);
        $this->assertContains(Generators::Budget, $values);
        $this->assertContains(Generators::Rooms, $values);
        $this->assertContains(Generators::Shape, $values);
        $this->assertContains(Generators::Buildings, $values);
        $this->assertContains(Generators::Colors, $values);
    }
}

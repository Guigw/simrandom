<?php

namespace Yrial\Simrandom\Domain\Generator;

enum Generators: string
{
    case Budget = "budget";
    case Buildings = "buildings";
    case Shape = "letter";
    case Rooms = "rooms";
    case Colors = "colors";

    public function getGenerator(): AbstractGenerator
    {
        return match ($this) {
            Generators::Budget => new BudgetGenerator(),
            Generators::Rooms => new RoomsGenerator(),
            Generators::Shape => new ShapeGenerator(),
            Generators::Buildings => new BuildingGenerator(),
            Generators::Colors => new ColorsGenerator(),
        };
    }
}
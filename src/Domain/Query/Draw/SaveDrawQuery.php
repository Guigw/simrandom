<?php

namespace Yrial\Simrandom\Domain\Query\Draw;

use DateTimeImmutable;
use DateTimeInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class SaveDrawQuery implements CommandInterface
{
    public readonly DrawQuery $drawQuery;
    public readonly DateTimeInterface $rollingDate;

    /**
     * @param string $title
     * @param mixed ...$params
     * @throws RandomizerNotFoundException
     */
    public function __construct(string $title, mixed ...$params)
    {
        $this->drawQuery = new DrawQuery($title, ...$params);
        $this->rollingDate = new DateTimeImmutable();
    }


    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->drawQuery;
    }
}

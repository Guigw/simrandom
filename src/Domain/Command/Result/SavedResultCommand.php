<?php

namespace Yrial\Simrandom\Domain\Command\Result;

use DateTimeImmutable;
use DateTimeInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class SavedResultCommand implements CommandInterface
{

    public readonly GenerateResultCommand $generateResultCommand;
    public readonly DateTimeInterface $rollingDate;

    /**
     * @param string $title
     * @param mixed ...$params
     * @throws RandomizerNotFoundException
     */
    public function __construct(string $title, mixed ...$params)
    {
        $this->generateResultCommand = new GenerateResultCommand($title, ...$params);
        $this->rollingDate = new DateTimeImmutable();
    }


    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->generateResultCommand;
    }
}
<?php

namespace Yrial\Simrandom\Domain\Command\Result;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class JsonResultCommand implements CommandInterface
{
    public readonly SavedResultCommand $savedResultCommand;

    /**
     * @param string $title
     * @param mixed ...$params
     * @throws RandomizerNotFoundException
     */
    public function __construct(string $title, mixed ...$params)
    {
        $this->savedResultCommand = new SavedResultCommand($title, ...$params);
    }

    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->savedResultCommand;
    }
}
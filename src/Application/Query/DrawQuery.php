<?php

namespace Yrial\Simrandom\Application\Query;

use Yrial\Simrandom\Domain\Contract\UseCase\CommandInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Domain\Query\Draw\SaveDrawQuery;

class DrawQuery implements CommandInterface
{
    public readonly SaveDrawQuery $saveDrawQuery;

    /**
     * @param string $title
     * @param mixed ...$params
     * @throws RandomizerNotFoundException
     */
    public function __construct(string $title, mixed ...$params)
    {
        $this->saveDrawQuery = new SaveDrawQuery($title, ...$params);
    }

    /**
     * @return CommandInterface|null
     */
    public function next(): ?CommandInterface
    {
        return $this->saveDrawQuery;
    }
}

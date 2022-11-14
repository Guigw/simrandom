<?php

namespace Yrial\Simrandom\Application\Handler\Draw;

use Yrial\Simrandom\Application\Dto\Draw\DrawDto;
use Yrial\Simrandom\Application\Query\DrawQuery;
use Yrial\Simrandom\Domain\Contract\HandlerInterface;

class DrawHandler implements HandlerInterface
{
    public function handle(DrawQuery $query, mixed $result): DrawDto
    {
        return new DrawDto(
            $query->saveDrawQuery->drawQuery->type->value,
            $result->getResults(),
            $query->saveDrawQuery->drawQuery->type->getGenerator()->getDependencies(),
            empty($result->getResults()) ? null : $result->getId()
        );
    }
}

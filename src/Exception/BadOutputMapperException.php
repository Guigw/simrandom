<?php

namespace Yrial\Simrandom\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class BadOutputMapperException extends Exception
{
    #[Pure]
    public function __construct(
        public string $dto = '',
        public string $entity = '',
        public string $actual = ''
    )
    {
        return parent::__construct(sprintf("expected to map %s into %s got %s instead", $this->dto, $this->entity, $this->actual));
    }
}
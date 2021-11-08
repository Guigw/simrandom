<?php

namespace Yrial\Simrandom\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class MissingConfigurationException extends Exception
{
    #[Pure]
    public function __construct(string $configuration)
    {
        return parent::__construct(sprintf("the %s configuration is missing", $configuration));
    }
}
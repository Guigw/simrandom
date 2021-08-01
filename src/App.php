<?php

namespace Yrial\Simrandom;

use Yrial\Simrandom\Reader\ConfigReader;

class App
{
    private Controller $controller;

    private ConfigReader $config;

    public function __construct(string $confPath)
    {
        $this->config = new ConfigReader($confPath);
        $this->controller = new Controller($this->config);

    }

    public function terminate(): void {
        $this->controller->generateRender();
    }

}
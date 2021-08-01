<?php
require_once ("../vendor/autoload.php");
use Yrial\Simrandom\App;

$app = new App("../config/generator.xml");
$app->terminate();


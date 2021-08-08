<?php
require_once ("../vendor/autoload.php");
use Yrial\Simrandom\App;

?>
<!DOCTYPE html>
<html lang='fr'>
    <head>
        <meta charset="utf-8" />
        <title>Sims Randomizer</title>
    </head>
    <body>
    <div id="root"></div>
    <?php
    $app = new App("../config/generator.xml");
    $app->terminate();
    ?>
    <script src="./dist/main.js"></script>
    </body>
</html>


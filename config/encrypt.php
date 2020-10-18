<?php
include __DIR__ . "/../util.php";
echo encrypt($argv[1], $ini["secret_key"]) . PHP_EOL;
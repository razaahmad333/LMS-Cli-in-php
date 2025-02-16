<?php

require_once './library.php';
require_once './cli.php';


if ($argc > 1) {
    $library = new Library();
    $cli = new CLI($library);
    $cli->init($argv);
} else {
    CLI::guide();
}

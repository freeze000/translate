<?php

// Autoloader relative path to this PHP file
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Application;
use src\Command\IbmTranslateCommand;


$finder = new Finder();
$finder->in(__DIR__);


$application = new Application();

// ... register commands
$application->add(new IbmTranslateCommand());

$application->run();

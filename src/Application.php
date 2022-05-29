#!/usr/bin/env php
<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector;

// Autoloader relative path to this PHP file
require_once dirname(__DIR__) . '/vendor/autoload.php';

use DI\ContainerBuilder;
use GonzaloRodriguez\SuspiciousReadingDetector\application\command\DetectSuspiciousReadingsFromResourceCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Console\Application;

$dotenv = new Dotenv();
// loads .env, .env.local, and .env.$APP_ENV.local or .env.$APP_ENV
$dotenv->loadEnv(dirname(__DIR__) . '/.env');

$environment = $_ENV['APP_ENV'];

// PHP-DI
$builder = new ContainerBuilder();
$builder->useAnnotations(true);
if ('prod' === $environment) {
    // https://php-di.org/doc/container-configuration.html#production-environment
    $builder->enableCompilation(dirname(__DIR__) . '/var/tmp');
    $builder->writeProxiesToFile(true, dirname(__DIR__) . '/var/tmp/proxies');
    echo "Configuring container for: " . $environment;
}
$container = $builder->build();

$application = new Application();

// ... register commands
$application->add(
    (new DetectSuspiciousReadingsFromResourceCommand())
);

$application->run();
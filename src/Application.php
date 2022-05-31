#!/usr/bin/env php
<?php

namespace GonzaloRodriguez\SuspiciousReadingDetector;

// Autoloader relative path to this PHP file
require_once dirname(__DIR__) . '/vendor/autoload.php';

use DI\ContainerBuilder;
use GonzaloRodriguez\SuspiciousReadingDetector\Application\Command\DetectSuspiciousReadingsFromResourceCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
// loads .env, .env.local, and .env.$APP_ENV.local or .env.$APP_ENV
$dotenv->loadEnv(dirname(__DIR__) . '/.env');

$environment = $_ENV['APP_ENV'];

// PHP-DI
$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/Config/config.php');
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
    $container->get(DetectSuspiciousReadingsFromResourceCommand::class)
);

$application->run();
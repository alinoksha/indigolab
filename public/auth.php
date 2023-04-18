<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alinoksha\Indigolab\Actions\AuthAction;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(require_once __DIR__ . '/../app/container.php');
$container = $containerBuilder->build();

$container->get(AuthAction::class)->handle();

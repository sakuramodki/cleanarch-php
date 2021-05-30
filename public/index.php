<?php

use App\Application\Action\DirtyIndexAction;
use App\Domain\Repositories\RecordRepository;
use App\Infrastructure\repositories\RecordsRepositoryImpl;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    Twig::class => fn () => TWig::create(__DIR__ . '/../templates'),
    \PDO::class => fn () => new \PDO('mysql:host=mysql;dbname=sample;port=3306', 'root', 'my-secret-pw'),
    RecordRepository::class => \DI\autowire(RecordsRepositoryImpl::class),
]);

// Instantiate App
AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes
$app->get('/', DirtyIndexAction::class);

$app->run();
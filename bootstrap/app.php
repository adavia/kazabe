<?php 

session_start();

use Slim\Factory\AppFactory;
use League\Container\Container;
use App\Exceptions\ExceptionHandler;
use Psr\Http\Message\ServerRequestInterface;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

require __DIR__ . '/container.php';
require __DIR__ . '/middleware.php';
require __DIR__ . '/dependencies.php';
require __DIR__ . '/exceptions.php';

require __DIR__ . '/../routes/web.php';
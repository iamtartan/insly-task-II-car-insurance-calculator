<?php
declare(strict_types = 1);

use DI\ContainerBuilder;
use App\Home;
use App\Calculator;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';
$config = require_once dirname(__DIR__) . '/config/config.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

$containerBuilder->addDefinitions([
    Home::class => create(Home::class)
        ->constructor(get('config'), get('Response')),
    'config'    => $config,
    'Response'  => function () {
        return new Response();
    },
]);

$containerBuilder->addDefinitions([
    Calculator::class => create(Calculator::class)
        ->constructor(get('config'), get('Response')),
    'config'          => $config,
    'Response'        => function () {
        return new Response();
    },
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/', Home::class);
    $r->post('/calculator', Calculator::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response       = $requestHandler->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();

return $emitter->emit($response);
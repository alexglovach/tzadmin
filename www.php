<?php
require_once __DIR__ . '/vendor/autoload.php';

$env = require __DIR__ . '/config/env.php';
$routes = require __DIR__ . '/config/routes.php';
$services = require __DIR__ . '/config/services.php';
$container = new League\Container\Container;

// Services to Container
foreach ($services as $service => $val) {
    $container->share($service, $val)
        ->withArgument($env)
        ->withArgument($container);
}

// PSR7 Request
$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

// router (controller)
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($routes) {
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], [$route[2], $route[3]]);
    }
});
$routeInfo = $dispatcher->dispatch(strtoupper($request->getMethod()), $request->getUri()->getPath());
if ($routeInfo[0] !== FastRoute\Dispatcher::FOUND) {
    echo 'not found';
    die;
}


// controller (result[])
$instance = new $routeInfo[1][0]($container, $request);
$result = call_user_func_array([$instance, $routeInfo[1][1]], []);


// template
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader);
$html = $twig->load($instance->template)->render($result);

// Response
$response = new \GuzzleHttp\Psr7\Response(200, [], $html);

$response = $response->withAddedHeader('X-data', 'manata');


// ----------
// Sending response
$statusCode = $response->getStatusCode();
$reasonPhrase = $response->getReasonPhrase();
$protocolVersion = $response->getProtocolVersion();
header("HTTP/{$protocolVersion} $statusCode $reasonPhrase");
// Sending headers
foreach ($response->getHeaders() as $name => $values) {
    header(sprintf('%s: %s', $name, $response->getHeaderLine($name)));
}
// Prepare body
echo $response->getBody()->__toString();

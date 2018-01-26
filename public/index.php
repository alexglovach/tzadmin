<?php
define('APP_DIR', __DIR__ . '/../');

require_once APP_DIR . 'vendor/autoload.php';

$env = require APP_DIR . 'config/env.php';
$routes = require APP_DIR . 'config/routes.php';
$services = require APP_DIR . 'config/services.php';
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
$dispatcher = FastRoute\simpleDispatcher(/**
 * @param \FastRoute\RouteCollector $r
 */
    function (FastRoute\RouteCollector $r) use ($routes) {
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
$controller = new $routeInfo[1][0]($container, $request);
$result = call_user_func_array([$controller, $routeInfo[1][1]],$routeInfo[2]);

// template
$loader = new Twig_Loader_Filesystem(APP_DIR . 'templates');
$twig = new Twig_Environment($loader);
$html = $twig->load($controller->template)->render($result);

// Response
$response = new \GuzzleHttp\Psr7\Response(200, [], $html);

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

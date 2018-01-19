<?php


namespace App\Controllers;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class BaseController
{
    private $container;
    protected $request;
    public $template = '';

    function __construct(ContainerInterface $container, ServerRequestInterface $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    public function __get($name)
    {
        if ($this->container->has($name)) {
            return $this->container->get($name);
        }
    }
}
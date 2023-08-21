<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace FrontController;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FrontController
{
    private $dispatcher;

    public function __construct(string $uri, string $httpRequestMethod)
    {
        $this->dispatcher = new Dispatcher($uri, strtoupper($httpRequestMethod));
    }

    public function dispatchRequest(ServerRequestInterface $request, array $routeResources): ?ResponseInterface
    {
        return $this->dispatcher->dispatch($request, $routeResources);
    }
}

<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace FrontController;

class FrontController
{
    private $dispatcher;

    public function __construct(string $uri, string $method)
    {
        $this->dispatcher = new Dispatcher($uri, $method);
    }

    public function dispatchRequest(string $pathResources): void
    {
        $resources = require $pathResources;
        $this->dispatcher->dispatch($resources);
    }
}

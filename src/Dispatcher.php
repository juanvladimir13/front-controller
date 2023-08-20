<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace FrontController;

use Psr\Http\Message\RequestInterface;

class Dispatcher
{
    private $params;
    private $method;
    private $url;

    public function __construct(string $uri, string $method)
    {
        $this->url = '';
        $this->params = [];
        $this->method = $method;

        $this->load($uri);
    }

    private function load(string $uri): void
    {
        $url = parse_url($uri, PHP_URL_PATH) ?? '';
        $url = trim(trim($url), '/');
        $this->url = $url;
    }

    private function getEndpoint(array $endpoints): array
    {
        foreach ($endpoints as $keyController => $controller) {
            foreach ($controller as $keyEndpoint => $endpoint) {
                $results = preg_match('/' . $endpoint . '/', $this->url);
                if ($results) return [$keyController, $keyEndpoint];
            }
        }
        return [];
    }

    private function getParamValuesOfUrl(array $urlParams): void
    {
        if (!$urlParams) return;

        $params = explode('/', $this->url);
        if (!$params) return;

        $data = [];
        foreach ($urlParams as $key => $index) {
            $data[$key] = array_key_exists($index, $params) ? $params[$index] : '';
        }

        $this->params = $data;
    }

    public function dispatch(RequestInterface $request, array $routes)
    {
        $endpoints = $routes['endpoint'] ?? [];
        $httpRequestMethods = $routes['httpRequestMethod'] ?? [];
        $controllersNamespace = $routes['controllersNamespace'] ?? [];

        $endpointAndFunctionValues = $this->getEndpoint($endpoints);
        if (count($endpointAndFunctionValues) != 2) return null;

        list($controllerKey, $endpointKey) = $endpointAndFunctionValues;
        $endpoint = $controllerKey . '.' . $endpointKey;

        if (!array_key_exists($endpoint, $httpRequestMethods)) return null;
        if (!array_key_exists($this->method, $httpRequestMethods[$endpoint])) return null;

        $endpointData = $httpRequestMethods[$endpoint][$this->method];

        $functionName = $endpointData['function'] ?? '';
        $paramNameAndPositions = $endpointData['urlParams'] ?? [];

        if (!$functionName) return null;
        $this->getParamValuesOfUrl($paramNameAndPositions);

        if (!array_key_exists($controllerKey, $controllersNamespace)) return null;
        $className = $controllersNamespace[$controllerKey];

        if (class_exists($className)) {
            $reflector = new \ReflectionClass($className);
            if ($reflector->hasMethod($functionName)) {
                return call_user_func_array([new  $className(), $functionName], [$request, $this->params]);
            }
        }

        return null;
    }

}

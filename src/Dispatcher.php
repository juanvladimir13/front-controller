<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

namespace FrontController;

class Dispatcher
{
    private $controller;
    private $action;
    private $params;
    private $method;

    public function __construct(string $uri, string $method)
    {
        $this->controller = '';
        $this->action = '';
        $this->params = [];
        $this->method = $method;

        $this->load($uri);
    }

    private function load(string $uri): void
    {
        $url = parse_url($uri, PHP_URL_PATH) ?? '';
        $url = trim(trim($url), '/');

        $isApi = strpos($url, 'api', 0) === false;
        $index = !$isApi ? 2 : 0;

        $data = explode('/', $url, $index + 3);

        if (count($data) > $index + 0)
            $this->controller = $data[$index + 0];

        if (count($data) > $index + 1)
            $this->action = $data[$index + 1];

        if (count($data) > $index + 2)
            $this->params = explode('/', $data[$index + 2]);
    }

    public function dispatch(array $resources): void
    {
        $resource = $resources[$this->controller] ?? '';
        if (!$resource) return;

        $className = $resource['className'];
        $pathClass = $resource['pathClass'] ?? '';
        $endpoint = $resource['endpoints'][$this->method];

        $methodName = '';
        foreach ($endpoint as $item) {
            if ($this->action == $item['url']) {
                $methodName = $item['endpoint'];
                break;
            }
        }

        $nameSpace = $resource['namespace'] ?? '';
        !$nameSpace ? require_once $pathClass : $className = "$nameSpace\\$className";

        if (class_exists($className)) {
            $reflector = new \ReflectionClass($className);
            if ($reflector->hasMethod($methodName)) {
                echo call_user_func_array([new  $className(), $methodName], $this->params);
                return;
            }
        }

        echo 'error 404';
    }
}

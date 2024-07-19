<?php

namespace Amir\Todolist\Request;

class Router
{
    private $request;
    private $supportedHttpMethods = [
        "GET",
        "POST",
        "DELETE",
        "PUT"
    ];

    function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = [
            "method" => $method,
        ];
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    private function formatRoute($route)
    {
        return $route;
    }

    function __destruct()
    {
        $this->resolve();
    }

    function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        $method = null;

        foreach ($methodDictionary as $key => $item) {
            if (preg_match($key, $formatedRoute, $matches)) {
                $method = $item["method"];

                foreach ($matches as $key_match => $match) {
                    if (is_int($key_match))
                        unset($matches[$key_match]);
                }

                $params = $matches;

                break;
            }
        }


        if (is_null($method)) {
            $this->defaultRequestHandler();

            return;
        }

        $args = array_merge([$this->request], $params);

        echo call_user_func_array($method, $args);
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }
}
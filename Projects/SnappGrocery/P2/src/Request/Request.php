<?php

namespace Amir\Todolist\Request;

class Request implements IRequest
{
    function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody()
    {

        if ($this->requestMethod === "GET") {
            return;
        }

        if ($this->requestMethod == "POST" or $this->requestMethod == "PATCH") {
            $body = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ['error' => 'Invalid JSON'];
            }

            $sanitizedBody = [];
            foreach ($body as $key => $value) {
                $sanitizedBody[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $sanitizedBody;
        }

    }

    public function getHeader()
    {
        return getallheaders();
    }
}
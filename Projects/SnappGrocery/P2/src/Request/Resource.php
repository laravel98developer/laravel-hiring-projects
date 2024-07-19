<?php


namespace Amir\Todolist\Request;

class Resource
{

    private $status;
    private $message;

    private $http_status_code;
    private $items;

    public function __construct($http_status_code, $status, $message, $items = [])
    {

        $this->http_status_code = $http_status_code;
        $this->status = $status;
        $this->message = $message;
        $this->items = $items;
    }

    public function __toString()
    {
        http_response_code($this->http_status_code);

        $data = [
            "status" => $this->status,
            "message" => $this->message,
        ];


        if (!empty($this->items)) {
            $data['items'] = $this->items;
        }

        return json_encode($data);
    }

}
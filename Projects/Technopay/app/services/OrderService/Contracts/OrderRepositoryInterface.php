<?php

namespace App\services\OrderService\Contracts;

interface OrderRepositoryInterface
{
    public function filterBy($data);
}

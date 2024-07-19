<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case WAITING = 1;
    case ACCEPTED = 2;
    case DELIVERING = 3;
    case DELIVERED = 4;
}

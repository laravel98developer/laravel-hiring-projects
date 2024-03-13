<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case SUCCESS = "Success";
    case FAILED = "Failed";
}

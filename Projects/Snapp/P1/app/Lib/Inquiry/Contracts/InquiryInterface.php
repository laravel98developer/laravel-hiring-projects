<?php

declare(strict_types=1);

namespace App\Lib\Inquiry\Contracts;

interface InquiryInterface
{
    public function validateCardNumber(string $cardNumber);
}

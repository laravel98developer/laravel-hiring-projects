<?php

namespace App\Foundation\Utils;

use Exception;
use Illuminate\Support\Facades\Validator;

trait ResponseValidator
{
    /**
     * @throws Exception
     */
    protected function validateResponse(array $rules, $data): void
    {
        if (! is_array($data) || Validator::make($data, $rules)->fails()) {
            $message = Validator::make($data, $rules)->errors()->first();
            throw new Exception("invalid provider service api response: {$message}");
        }
    }
}

<?php

namespace App\Http\Requests;

use App\Utils\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    const DEFAULT_MESSAGE = "Validation failed";

    protected function failed(Validator $validator, $status = 422 , $message = self::DEFAULT_MESSAGE){
        throw new HttpResponseException(Response::error($message, $status, $validator->errors()));
    }

    protected function failedValidation(Validator $validator)
    {
        return $this->failed($validator);
    }
}

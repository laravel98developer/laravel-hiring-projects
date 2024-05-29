<?php

namespace AliSalehi\Task\Http\Controllers\Api;

use AliSalehi\Task\Trait\ApiResponseTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiController extends BaseController
{
    use ApiResponseTrait, AuthorizesRequests, ValidatesRequests;
}

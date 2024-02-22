<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel(): Product;
}

<?php

namespace App\Contracts\Services;

use App\DTOs\OrderWithOrderProductShowDto;
use App\DTOs\OrderWithOrderProductStoreDto;
use App\DTOs\ProductStoreDto;
use Illuminate\Support\Collection;

interface OrderServiceInterface
{

    /**
     * @return Collection<ProductStoreDto>
     */
    public function all(): Collection;

    public function store(OrderWithOrderProductStoreDto $dto): OrderWithOrderProductShowDto;
}
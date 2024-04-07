<?php

namespace App\Services;

use App\Repositories\BasketRepository;

class BasketService
{
    private $basketRepository;

    public function __construct(BasketRepository $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function getAll($basketData)
    {
        return $this->basketRepository->getAll($basketData);
    }

    public function addBasket($basketData)
    {
        return $this->basketRepository->create($basketData);
    }

    public function getBasket($basketId)
    {
        return $this->basketRepository->getById($basketId);
    }

    public function updateBasket($basketId, $basketData)
    {
        return $this->basketRepository->update($basketId, $basketData);
    }

    public function deleteBasket($basketId)
    {
        return $this->basketRepository->delete($basketId);
    }

    public function checkUserBoughtProduct($productId): bool
    {
        return $this->basketRepository->getUserBasketByProductId($productId);
    }

}

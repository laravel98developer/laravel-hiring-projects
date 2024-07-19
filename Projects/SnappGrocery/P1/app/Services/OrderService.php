<?php

namespace App\Services;

use App\Contracts\Repositories\OrderProductRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Services\OrderServiceInterface;
use App\DTOs\OrderWithOrderProductShowDto;
use App\DTOs\OrderWithOrderProductStoreDto;
use App\Enums\OrderStatus;
use App\Helpers\DtoHelper;
use Illuminate\Support\Collection;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        protected OrderRepositoryInterface        $orderRepository,
        protected OrderProductRepositoryInterface $orderProductRepository,
    )
    {

    }

    /**
     * @return Collection<OrderWithOrderProductShowDto>
     */
    public function all(): Collection
    {
        return collect();
    }

    public function store(OrderWithOrderProductStoreDto $dto): OrderWithOrderProductShowDto
    {
        $orderStoreDto = DtoHelper::dataToOrderStoreDto(userId: $dto->getUserId(), status: OrderStatus::PENDING);
        $order = $this->orderRepository->store($orderStoreDto);

        $orderProductShowDtos = [];
        foreach ($dto->getOrderProductWithoutOrderIdDtos() as $orderProductWithoutOrderIdDto) {
            $orderProductStoreDto = DtoHelper::orderProductWithoutOrderIdStoreDtoToOrderProductStoreDto(
                orderProductWithoutOrderIdStoreDto: $orderProductWithoutOrderIdDto, orderId: $order->id
            );
            $orderProductShowDtos[] = $this->orderProductRepository->store($orderProductStoreDto);
        }

        return DtoHelper::orderAndOrderProductDtosToOrderShowDto(order: $order, orderProductShowDtos: collect($orderProductShowDtos));
    }
}
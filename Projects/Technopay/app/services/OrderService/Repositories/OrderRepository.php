<?php

namespace App\services\OrderService\Repositories;

use App\Jobs\SendEmailNotification;
use App\Jobs\SendSmsNotification;
use App\Models\Order;
use App\services\OrderService\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(public Order $order)
    {
    }

    public function filterBy($data): Collection
    {

        try {

            $query = $this->order::query();

            if (isset($data['status'])) {
             //   $b=$data['nan'];
                $query->where('status', (bool)$data['status']);
            }

            if (isset($data['mobile'])) {
                $query->where('mobile_number', $data['mobile']);
            }
            if (isset($data['national_code'])) {
                $query->where('national_code', $data['national_code']);
            }

            if (isset($data['min']) && isset($data['max'])) {

                $query->whereBetween('amount', [$data['min'], $data['max']]);
            } elseif (isset($data['min'])) {
                $query->where('amount', '>=', $data['min']);
            } elseif (isset($data['max'])) {
                $query->where('amount', '<=', $data['max']);
            }

            return $query->get();
        } catch (\Exception $e) {

            SendEmailNotification::dispatch(['exception' => $e->getMessage()]);
            SendSmsNotification::dispatch(['exception' => $e->getMessage()]);

            Log::error($e);

            return Collection::empty();
        }
    }
}





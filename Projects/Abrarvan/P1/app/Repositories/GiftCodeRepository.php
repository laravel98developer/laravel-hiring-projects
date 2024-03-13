<?php

namespace App\Repositories;


use App\Models\GiftCode;
use Illuminate\Support\Collection;

class GiftCodeRepository
{
    public function create(array $request): Collection
    {
        $giftCode = GiftCode::query()->create($request);

        return collect($giftCode);
    }

    public function all(array $request): Collection
    {
        return GiftCode::query()
            ->when(!empty($request['code']), fn($query) => $query->where('code' , $request['code']))
            ->get()
            ->collect();
    }
}

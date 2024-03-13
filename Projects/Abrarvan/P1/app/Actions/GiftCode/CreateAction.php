<?php

namespace App\Actions\GiftCode;

use Illuminate\Support\Collection;
use App\Repositories\GiftCodeRepository;

class CreateAction
{
    private GiftCodeRepository $giftCodeRepository;

    public function __construct(GiftCodeRepository $giftCodeRepository)
    {
        $this->giftCodeRepository = $giftCodeRepository;
    }

    public function handle(array $request): Collection
    {
        return $this->giftCodeRepository->create($request);
    }
}

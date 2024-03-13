<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddGiftCodeRequest;
use App\Http\Requests\GiftCodeRequest;
use App\Http\Resources\GiftCodeResource;
use App\Services\GiftCodeService;
use Illuminate\Http\JsonResponse;

class GiftCodeController extends Controller
{
    private GiftCodeService $giftCodeService;

    public function __construct(GiftCodeService $giftCodeService)
    {
        $this->giftCodeService = $giftCodeService;
    }

    public function create(GiftCodeRequest $request): GiftCodeResource
    {
        $response = $this->giftCodeService->create($request->validated());

        return new GiftCodeResource($response);
    }

    public function add(AddGiftCodeRequest $request): JsonResponse
    {
        return $this->giftCodeService->add($request->validated());
    }
}

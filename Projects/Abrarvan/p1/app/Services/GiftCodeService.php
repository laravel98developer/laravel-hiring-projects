<?php

namespace App\Services;

use App\Actions\GiftCode\CreateAction;
use App\Actions\Redis\SubscribeAction;
use App\Actions\Wallet\ChargeAction;
use App\Jobs\Transaction\AddTransactionJob;
use App\Jobs\Wallet\ChargeWalletJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class GiftCodeService
{
    private static $lotteryNumberWinners;
    private CreateAction $createAction;
    private SubscribeAction $subscribeAction;

    public function __construct(CreateAction $createAction, SubscribeAction $subscribeAction)
    {
        $this->createAction = $createAction;
        $this->subscribeAction = $subscribeAction;
    }

    public function create(array $request): Collection
    {
        return $this->createAction->handle($request);
    }

    private function getNumberLotteryWinners(array $request): int
    {
        return Cache::remember(env('GIFT_CODE_CACHE_KEY'), env('GIFT_CODE_KEY_EXPIRE_TIME'), function () use ($request) {
            Cache::put(env('GIFT_CODE_CACHE_KEY'), 1, env('GIFT_CODE_KEY_EXPIRE_TIME'));

            return 0;
        });
    }

    private function userWon(): bool
    {
        return self::$lotteryNumberWinners <= env('GIFT_CODE_NUMBER_WINNERS');
    }

    private function setLotteryData(array $data): array
    {
        return [
            'phone' => $data['phone'],
            'code' => $data['code'],
        ];
    }

    public function add(array $request): JsonResponse
    {
        self::$lotteryNumberWinners = $this->getNumberLotteryWinners($request) + 1;

        if(!$this->userWon()) {
            return response()->json(['status' => 'failed'], Response::HTTP_OK);
        }

        // add to cache
        Cache::increment(env('GIFT_CODE_CACHE_KEY'));
        $caheKey = env('GIFT_CODE_USER_DATA_CACHE_KEY').'_'.$request['phone'];
        $data = $this->setLotteryData($request);
        Cache::put($caheKey, json_encode($data), env('GIFT_CODE_KEY_EXPIRE_TIME'));

        // publish to channel
        $this->subscribeAction->handle(env('GIFT_CODE_CHANNEL'), $data);

        return response()->json(['status' => 'success'], Response::HTTP_OK);
    }
}

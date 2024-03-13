<?php

namespace App\Jobs\Transaction;

use App\Models\Transaction;
use App\Repositories\GiftCodeRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private GiftCodeRepository $giftCodeRepository;
    private WalletRepository $walletRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->giftCodeRepository = app('GiftCodeRepository');
        $this->walletRepository = app('WalletRepository');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Transaction::query()->insert([
            'wallet_id' => $this->walletRepository->getByPhone($this->data['phone'])->id,
            'code' => $this->data['code'],
            'price' => $this->giftCodeRepository->all(['code' => $this->data['code']])->first()->price,
            'created_at' => Carbon::now(),
        ]);
    }
}

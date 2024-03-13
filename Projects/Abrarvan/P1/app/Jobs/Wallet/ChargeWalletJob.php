<?php

namespace App\Jobs\Wallet;

use App\Actions\Wallet\ChargeAction;
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

class ChargeWalletJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private ChargeAction $chargeAction;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->chargeAction = app('ChargeAction');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->chargeAction->handle($this->data['phone'], env('GIFT_CODE_PRICE'));
    }
}

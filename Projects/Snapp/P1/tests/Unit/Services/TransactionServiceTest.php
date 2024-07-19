<?php

namespace Tests\Unit\Services;

use App\Exceptions\InsufficientBalanceTransactionException;
use App\Exceptions\SameAccountTransactionException;
use App\Models\BankAccount;
use App\Models\BankAccountCard;
use App\Models\Enums\TransactionStatusEnum;
use App\Models\User;
use App\Notifications\DepositTransactionNotification;
use App\Notifications\WithdrawTransactionNotification;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected User $senderUser;
    protected BankAccount $senderBankAccount;
    protected BankAccountCard $senderBankAccountCard;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->senderUser = User::factory()->create();
        $this->senderBankAccount = BankAccount::factory()->for($this->senderUser)->create();
        $this->senderBankAccountCard = BankAccountCard::factory()->for($this->senderUser)->for($this->senderBankAccount)->create();
    }

    /**
     * A basic unit test example.
     */
    public function test_can_deposit_money_to_another_bank_account(): void
    {
        $receiverUser = User::factory()->create();
        $receiverBankAccount = BankAccount::factory()->for($receiverUser)->create();
        $receiverBankAccountCard = BankAccountCard::factory()->for($receiverUser)->for($receiverBankAccount)->create();

        $service = new TransactionService;

        $service->create(
            $this->senderUser,
            $this->senderBankAccountCard,
            $receiverBankAccountCard->card_number,
            $amount = mt_rand(10_000, $this->senderBankAccount->balance)
        );

        $this->assertDatabaseCount('transactions', 1)
            ->assertDatabaseHas('transactions', [
                'sender_card_id' => $this->senderBankAccountCard->id,
                'receiver_card_id' => $receiverBankAccountCard->id,
                'amount' => $amount,
                'status' => TransactionStatusEnum::Done,
            ])
            ->assertDatabaseHas('bank_accounts', [
                'id' => $this->senderBankAccount->id,
                'balance' => $this->senderBankAccount->balance - $amount,
            ])
            ->assertDatabaseHas('bank_accounts', [
                'id' => $receiverBankAccount->id,
                'balance' => $receiverBankAccount->balance + $amount,
            ]);

        Notification::assertSentTo(
            [$this->senderUser],
            WithdrawTransactionNotification::class
        );
        Notification::assertSentTo(
            [$receiverUser],
            DepositTransactionNotification::class
        );
    }

    public function test_cant_use_same_bank_account(): void
    {
        $receiverBankAccountCard = BankAccountCard::factory()->for($this->senderUser)->for($this->senderBankAccount)->create();

        $service = new TransactionService;

        try {
            $service->create(
                $this->senderUser,
                $this->senderBankAccountCard,
                $receiverBankAccountCard->card_number,
                mt_rand(10_000, 500_000_000)
            );
            $this->fail('The exception was not thrown.');
        } catch (SameAccountTransactionException $exception) {
            $this->assertDatabaseCount('transactions', 0)
                ->assertDatabaseHas('bank_accounts', [
                    'id' => $this->senderBankAccount->id,
                    'balance' => $this->senderBankAccount->balance,
                ]);

            Notification::assertNotSentTo(
                [$this->senderUser],
                WithdrawTransactionNotification::class
            );
            Notification::assertNotSentTo(
                [$this->senderUser],
                DepositTransactionNotification::class
            );
        }
    }

    public function test_cant_do_transaction_if_balance_is_insufficient(): void
    {
        $receiverUser = User::factory()->create();
        $receiverBankAccount = BankAccount::factory()->for($receiverUser)->create();
        $receiverBankAccountCard = BankAccountCard::factory()->for($receiverUser)->for($receiverBankAccount)->create();

        $service = new TransactionService;

        try {
            $service->create(
                $this->senderUser,
                $this->senderBankAccountCard,
                $receiverBankAccountCard->card_number,
                $this->senderBankAccount->balance + 1
            );

            $this->fail('The exception was not thrown.');
        } catch (InsufficientBalanceTransactionException $exception) {
            $this->assertDatabaseCount('transactions', 0)
                ->assertDatabaseHas('bank_accounts', [
                    'id' => $this->senderBankAccount->id,
                    'balance' => $this->senderBankAccount->balance,
                ]);

            Notification::assertNotSentTo(
                [$this->senderUser],
                WithdrawTransactionNotification::class
            );
            Notification::assertNotSentTo(
                [$receiverUser],
                DepositTransactionNotification::class
            );
        }
    }
}

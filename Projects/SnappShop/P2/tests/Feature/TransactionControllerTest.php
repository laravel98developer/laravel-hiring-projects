<?php

namespace Tests\Feature;

use App\Jobs\SendSms;
use App\Models\Account;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public $sourceAccount;

    public $sourceCard;

    public $destinationAccount;

    public $destinationCard;

    public $sourceUser;

    public $destinationUser;

    public function setUp(): void
    {
        parent::setUp();
        Http::fake(['https://api.kavenegar.com/v1/*' => Http::response(['status' => 200, 'message' => 'successful'], 200)]);
        $this->sourceAccount = Account::factory()->create(['user_id' => $this->sourceUser = User::factory()->create(), 'current_balance' => 30_000]);
        $this->sourceCard = Card::factory()->create(['account_id' => $this->sourceAccount->id, 'balance' => 30_000]);
        $this->destinationAccount = Account::factory()->create(['user_id' => $this->destinationUser = User::factory()->create(), 'current_balance' => 50_000]);
        $this->destinationCard = Card::factory()->create(['account_id' => $this->destinationAccount->id, 'balance' => 50_000]);
    }

    /** @test */
    public function user_can_send_money_to_another_person()
    {
        Queue::fake();

        $response = $this->postJson(route('v1.transfer'), [
            'source_card_number' => $this->sourceCard->card_number,
            'destination_card_number' => $this->destinationCard->card_number,
            'amount' => $transferAmount = 10_000,
        ]);

        $response->assertOk();
        $response->assertJson(['message' => __('messages.transfer.success')]);
        $this->assertDatabaseHas('transactions', [
            'source_card_id' => $this->sourceCard->id,
            'destination_card_id' => $this->destinationCard->id,
            'amount' => $transferAmount,
        ]);
        $this->assertDatabaseHas('wages', [
            'transaction_id' => 1,
            'wage_amount' => Wage::AMOUNT,
        ]);
        $this->assertDatabaseHas('cards', [
            'account_id' => $this->sourceAccount->id,
            'balance' => 30_000 - ($transferAmount + Wage::AMOUNT),
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $this->sourceAccount->id,
            'current_balance' => 30_000 - ($transferAmount + Wage::AMOUNT),
        ]);
        $this->assertDatabaseHas('cards', [
            'account_id' => $this->destinationCard->id,
            'balance' => 50_000 + $transferAmount,
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $this->destinationAccount->id,
            'current_balance' => 50_000 + $transferAmount,
        ]);
        Queue::assertPushed(SendSms::class);
    }

    /** @test */
    public function user_should_have_enough_credit_for_transfer()
    {
        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => $this->sourceCard->card_number,
                'destination_card_number' => $this->destinationCard->card_number,
                'amount' => 30_000 + 1000,
            ],
        );

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson(['message' => __('messages.transfer.insufficient-balance')]);
    }

    /** @test */
    public function source_card_number_should_be_in_iranian_bank_format()
    {
        $sourceAccount = Account::factory()->create(['user_id' => $this->sourceUser = User::factory()->create()]);
        $sourceCard = Card::factory()->create(['account_id' => $this->sourceAccount->id, 'balance' => 30_000, 'card_number' => 2343453452234]);

        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => $sourceCard->card_number,
                'destination_card_number' => $this->destinationCard->card_number,
                'amount' => Transaction::MAX,
            ],
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(['message' => 'The source card number format is not supported by iranian banks.']);
    }

    /** @test */
    public function destination_card_number_should_be_exist()
    {
        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => $this->sourceCard->card_number,
                'destination_card_number' => 60379923445345,
                'amount' => Transaction::MAX,
            ],
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(['message' => 'The selected destination card number is invalid.']);
    }

    /** @test */
    public function max_amount_for_transfer()
    {
        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => $this->sourceCard->card_number,
                'destination_card_number' => $this->destinationCard->card_number,
                'amount' => Transaction::MAX + 1000,
            ],
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function min_amount_for_transfer()
    {
        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => $this->sourceCard->card_number,
                'destination_card_number' => $this->destinationCard->card_number,
                'amount' => Transaction::MIN - 1000,
            ],
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_could_use_arabic_and_persian_card_number()
    {
        $response = $this->postJson(
            route('v1.transfer'),
            [
                'source_card_number' => convert2arabic($this->sourceCard->card_number),
                'destination_card_number' => $this->destinationCard->card_number,
                'amount' => 10_000,
            ],
        );

        $response->assertOk();
    }
}

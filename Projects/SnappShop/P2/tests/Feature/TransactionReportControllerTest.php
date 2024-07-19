<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TransactionReportControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function it_could_return_three_top_user_with_their_ten_transaction_list()
    {
        $accountOne = Account::factory()->create(['user_id' => $userOne = User::factory()->create()]);
        $cardOne = Card::factory()->create(['account_id' => $accountOne->id, 'balance' => 30_000]);

        $accountTwo = Account::factory()->create(['user_id' => $userTwo = User::factory()->create()]);
        $cardTwo = Card::factory()->create(['account_id' => $accountTwo->id, 'balance' => 30_000]);

        $accountThree = Account::factory()->create(['user_id' => $userThree = User::factory()->create()]);
        $cardThree = Card::factory()->create(['account_id' => $accountThree->id, 'balance' => 30_000]);

        $accountFour = Account::factory()->create(['user_id' => $userFour = User::factory()->create()]);
        $cardFour = Card::factory()->create(['account_id' => $accountFour->id, 'balance' => 30_000]);

        $userOneTransactions = Transaction::factory()->count(4)->create(['source_card_id' => $cardOne->id]);
        $userTwoTransactions = Transaction::factory()->count(3)->create(['source_card_id' => $cardTwo->id]);
        $userThreeTransactions = Transaction::factory()->count(2)->create(['source_card_id' => $cardThree->id]);
        $userFourTransactions = Transaction::factory()->create(['source_card_id' => $cardFour->id]);

        $response = $this->getJson(route('v1.top_users'));

        $response->assertOk();
        $this->assertSame($userOne->id, $response->decodeResponseJson()[0]['id']);
        $this->assertSame($userTwo->id, $response->decodeResponseJson()[1]['id']);
        $this->assertSame($userThree->id, $response->decodeResponseJson()[2]['id']);
    }
}

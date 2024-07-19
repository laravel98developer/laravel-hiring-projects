<?php

namespace App\Services;

use App\Jobs\SmsJob;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\Repositories\CardRepositoryInterface;
use App\Interfaces\Repositories\WageRepositoryInterface;
use App\Interfaces\Services\DoTransactionServiceInterface;
use App\Interfaces\Repositories\AccountRepositoryInterface;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class DoTransactionService implements DoTransactionServiceInterface {

    private $card;
    private $destinationCard;
    private $transaction;

    // repository properties
    private TransactionRepositoryInterface $transactionRepository;
    private CardRepositoryInterface $cardRepository;
    private WageRepositoryInterface $wageRepository;
    private AccountRepositoryInterface $accountRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository, WageRepositoryInterface $wageRepository, AccountRepositoryInterface $accountRepository) {

        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->wageRepository = $wageRepository;
        $this->accountRepository = $accountRepository;
    }

    /**
     * 
     * property getter
     */
    public function __get($property) {

        if (property_exists($this, $property)) {

          return $this->$property;
        }
    }

    /**
     * 
     * ready method call the needed repositories and make new transaction record on database
     */
    public function ready(TransactionRequest $request) : void
    {
        
        // get first card info from db
        $this->card = $this->cardRepository->findByCardNumber($request->card_number);

        // get the destination transaction card info
        $this->destinationCard = $this->cardRepository->findByCardNumber($request->destination_card_number);

        // create new transaction
        $this->transaction = $this->transactionRepository->create($this->card->id, $this->destinationCard->id, $request->amount);
    }

    /**
     * 
     * ceck the user account balance and return a boolean
     */
    public function checkBalance($amount) : bool
    {

        // chack sum of the account balance and and the wage
        if($this->card->account->balance < ($amount + TRANSACTION_WAGE)){

            $this->transaction = $this->transactionRepository->changeStatus($this->transaction, TRANSACTION_STATUS_NO_BALANCE);

            return false;
        }

        return true;
    }

    /**
     * 
     * execute the creation process of transaction
     */
    public function execute(TransactionRequest $request) : void
    {
        
        DB::transaction(function () use ($request) {

            // create wage in db for this transaction
            $this->wageRepository->create($this->transaction->id);

            // sub and sum operation on the first card and destionation card accounts on db 
            $this->accountRepository->subBalance($this->card->account, $request->amount);
            $this->accountRepository->sumBalance($this->destinationCard->account, $request->amount);

            // send sms after transaction commited to users on the queueu
            dispatch(new SmsJob($this->card, $request->amount, GIVE_MONNY_SMS_MESSAGE))->delay(now()->addSeconds(10))->afterCommit();
            dispatch(new SmsJob($this->destinationCard, $request->amount, GET_MONNY_SMS_MESSAGE))->delay(now()->addSeconds(10))->afterCommit();
        });
    }

    /**
     * 
     * change the transaction status to error on database
     */
    public function conflict() : void
    {
        
        // change transaction status to error on database
        $this->transactionRepository->changeStatus($this->transaction, TRANSACTION_STATUS_ERROR);
    }
}
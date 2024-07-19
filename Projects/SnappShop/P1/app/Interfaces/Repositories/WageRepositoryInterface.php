<?php

namespace App\Interfaces\Repositories;

use App\Models\Wage;

interface WageRepositoryInterface {

    public function create($transactionID) : Wage;
}
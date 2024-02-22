<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use App\Repositories\BaseRepositoryInterface;

interface VoteRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel(): Vote;
}

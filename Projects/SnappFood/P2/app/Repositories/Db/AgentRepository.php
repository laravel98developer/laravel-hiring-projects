<?php

namespace App\Repositories\Db;

use App\Models\Agent;

class AgentRepository extends BaseRepository implements \App\Contracts\Repository\AgentRepository
{
    protected function model(): string
    {
        return Agent::class;
    }
}

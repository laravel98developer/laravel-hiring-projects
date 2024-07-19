<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repository\AgentRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgentStoreRequest;
use App\Http\Resources\Admin\AgentCollection;
use App\Http\Resources\Admin\AgentResource;

class AgentController extends Controller
{
    public function __construct(
        private readonly AgentRepository $agentRepository,
    )
    {
    }

    public function store(AgentStoreRequest $agentRequest): AgentResource
    {
        return AgentResource::make(
            $this->agentRepository->create(
                $agentRequest->validated()
            )
        );
    }

    public function index(): AgentCollection
    {
        return AgentCollection::make(
            $this->agentRepository->all()
        );
    }
}

<?php

namespace App\Services;

use App\Repositories\ProviderRepository;

class ProviderService
{
    private $providerRepository;

    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function getAll($providerData)
    {
        return $this->providerRepository->getAll($providerData);
    }

    public function addProvider($providerData)
    {
        return $this->providerRepository->create($providerData);
    }

    public function getProvider($providerId)
    {
        return $this->providerRepository->getById($providerId);
    }

    public function updateProvider($providerId, $providerData)
    {
        return $this->providerRepository->update($providerId, $providerData);
    }

    public function deleteProvider($providerId)
    {
        return $this->providerRepository->delete($providerId);
    }

}

<?php

namespace App\Repositories;

use App\Models\Provider;

class ProviderRepository
{
    private $model;

    public function __construct(Provider $provider)
    {
        $this->model = $provider;
    }

    public function getAll($showDataOptions)
    {
        $providers = $this->model->query();
        if (isset($showDataOptions['title'])) {
            $providers->where('title', 'like', '%' . $showDataOptions['title'] . '%');
        }

        $sort_column = $showDataOptions['sort_column'] ?? 'created_at';
        $providers->orderBy($sort_column, isset($showDataOptions['is_sort_dir_desc']) && $showDataOptions['is_sort_dir_desc']=='true' ? 'desc' : 'asc');
        return $providers->paginate($showDataOptions['per_page'] ?? 10);
    }

    public function create($providerData)
    {
        return $this->model->create($providerData);
    }

    public function getById($providerId)
    {
        return $this->model->findOrFail($providerId);
    }

    public function update($providerId, $providerData)
    {
        $provider = $this->getById($providerId);
        return $provider->update($providerData);
    }

    public function delete($providerId)
    {
        $provider = $this->getById($providerId);
        return $provider->delete();
    }


}

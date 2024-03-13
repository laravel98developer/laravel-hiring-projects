<?php

namespace App\Repositories;

use App\Models\ImportData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImportDataRepository
{

    /**
     * @param $data
     * @return Builder|Model
     */
    public function create($data): Model|Builder
    {
        return ImportData::query()->create($data);
    }

    /**
     * @param $typeId
     * @param $providerId
     * @return Model|Builder|null
     */
    public function search($typeId, $providerId): Model|Builder|null
    {
        return ImportData::query()
            ->where('type_id', $typeId)
            ->where('provider_id', $providerId)
            ->first();
    }


}

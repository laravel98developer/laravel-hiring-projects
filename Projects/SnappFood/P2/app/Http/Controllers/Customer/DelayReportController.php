<?php

namespace App\Http\Controllers\Customer;

use App\Actions\StoreDelayReportAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\DelayReportStoreRequest;
use App\Http\Resources\Customer\DelayReportResource;

class DelayReportController extends Controller
{
    public function store(DelayReportStoreRequest $request): DelayReportResource
    {
        return DelayReportResource::make(
            StoreDelayReportAction::make()->handle(
                $request->get('order_id')
            )
        );
    }
}

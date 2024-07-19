<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repository\VendorRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorStoreRequest;
use App\Http\Resources\Admin\VendorCollection;
use App\Http\Resources\Admin\VendorResource;

class VendorController extends Controller
{
    public function __construct(
        private readonly VendorRepository $vendorRepository,
    )
    {
    }

    public function store(VendorStoreRequest $vendorRequest): VendorResource
    {
        return VendorResource::make(
            $this->vendorRepository->create(
                $vendorRequest->validated()
            )
        );
    }

    public function index(): VendorCollection
    {
        return VendorCollection::make(
            $this->vendorRepository->all()
        );
    }
}

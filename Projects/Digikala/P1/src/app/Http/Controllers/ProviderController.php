<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
use App\Http\Resources\ProviderCollection;
use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\Response;

class ProviderController extends Controller
{

    private $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProviderRequest $providerRequest
     * @return Response
     */
    public function index(ProviderRequest $providerRequest)
    {
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProviderCollection($this->providerService->getAll($providerRequest->validated()))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProviderRequest $providerRequest
     * @return JsonResponse
     */
    public function store(ProviderRequest $providerRequest)
    {

        $result = $this->providerService->addProvider($providerRequest->validated());
        if(!$result){
            return response()->error(
                __('messages.error_in_created'),
                Response::HTTP_BAD_REQUEST
            );
        }
        return response()->success(
            __('messages.created'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $provider = $this->providerService->getProvider($id);
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProviderResource($provider)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProviderRequest $providerRequest
     * @param int $id
     * @return Response
     */
    public function update(ProviderRequest $providerRequest, int $id)
    {
        $this->providerService->updateProvider($id, $providerRequest->validated());
        return response()->success(
            __('messages.update_successfully'),
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $this->providerService->deleteProvider($id);
        return response()->success(
            __('messages.delete_successfully'),
            Response::HTTP_OK
        );
    }
}

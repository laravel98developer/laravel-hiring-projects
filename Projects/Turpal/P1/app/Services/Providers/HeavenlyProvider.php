<?php


namespace App\Services\Providers;

use App\Abstracts\AbstractProvider;
use App\Constants\ProductTypeConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HeavenlyProvider extends AbstractProvider
{
    public bool $hasTour = true;
    public string $baseUrl = 'https://b3faff8e-f2fb-4066-a1b9-220744499e8e.mock.pstmn.io/api';

    public function getTours(): void
    {
        $response = Http::get("{$this->baseUrl}/tours");
        if ($response->failed()) {
            Log::error('provider -> heavenly, request -> get tours , response code -> ' . $response->status() . ' message -> ' . $response->body());
            return;
        }

        $toursBody = json_decode($response->body(), true);
        if (count($toursBody) === 0) return;

        foreach ($toursBody as $tour) {
            $tourId = $tour['id'];
            $tour['name'] = $tour['title'];
            unset($tour['title'], $tour['id'], $tour['city'], $tour['excerpt']);

            //check Availability
            $availabilityResponse = Http::get("{$this->baseUrl}/tours/{$tourId}/availability", [
                'travelDate' => "2022-01-01"
            ]);

            if ($availabilityResponse->failed()) {
                Log::error('provider -> heavenly, request -> get tour availability , response code -> ' . $availabilityResponse->status() . ' message -> ' . $availabilityResponse->body());
                continue;
            }

            $availabilityResponse = json_decode($availabilityResponse->body());
            if (!$availabilityResponse->available) {
                continue;
            }

            //get tour detail
            $detailResponse = Http::get("{$this->baseUrl}/tours/{$tourId}");

            if ($detailResponse->failed()) {
                Log::error('provider -> heavenly, request -> get tour detail , response code -> ' . $detailResponse->status() . ' message -> ' . $detailResponse->body());
                continue;
            }

            $detailResponse = json_decode($detailResponse->body());
            $tour['description'] = $detailResponse->description;
            $tour['thumbnail'] = $detailResponse->photos[0]->url;

            //search in importData
            $importData = $this->importDataRepo->search(ProductTypeConstant::getId(ProductTypeConstant::TOUR), $tourId);

            //update product if exist
            if ($importData) {
                $this->productRepo->updateWithId($importData->product_id, $tour);
                continue;
            }

            //create new product if not exist
            $productId = $this->productRepo->create($tour)->id;
            $this->importDataRepo->create([
                'product_id' => $productId,
                'provider_id' => $tourId,
                'type_id' => ProductTypeConstant::getId(ProductTypeConstant::TOUR)
            ]);
        }

        //get price
        $priceResponse = Http::get("{$this->baseUrl}/tour-prices", [
            'travelDate' => "2022-01-01"
        ]);

        if ($priceResponse->failed()) {
            Log::error('provider -> heavenly, request -> get prices, response code -> ' . $priceResponse->status() . ' message -> ' . $priceResponse->body());
            return;
        }

        $priceResponse = json_decode($priceResponse->body());

        foreach ($priceResponse as $price) {
            $importData = $this->importDataRepo->search(
                ProductTypeConstant::getId(ProductTypeConstant::TOUR),
                $price->tourId
            );

            if (!$importData) {
                continue;
            }

            //todo update Availability if exist in date period
            $this->availabilityRepo->updateOrCreate([
                'product_id' => $importData->product_id,
                'start_time' => "2022-01-01",
                'end_time' => "2022-01-01"
            ], [
                'price' => $price->price,
            ]);
        }

    }

    public function getActivities(): void
    {
        if (!$this->hasActivity) return;
    }

    public function getEvents(): void
    {
        if (!$this->hasEvent) return;
    }
}

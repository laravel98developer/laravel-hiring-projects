<?php


namespace App\Services\Providers;

use App\Abstracts\AbstractProvider;
use App\Constants\ProductTypeConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MajestyProvider extends AbstractProvider
{
    public bool $hasActivity = true;
    public bool $hasEvent = true;
    public string $baseUrl = 'https://865e1af9-1234-4f91-8b51-4ef9abbd3bf3.mock.pstmn.io';

    public function getTours(): void
    {
        if (!$this->hasTour) return;
    }

    public function getActivities(): void
    {
        if (!$this->hasActivity) return;

        $activitiesResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post("{$this->baseUrl}/activity/search", [
            "startDate" => "2022-06-12",
            "endDate" => "2022-06-12"
        ]);

        if ($activitiesResponse->failed()) {
            Log::error('provider -> majesty, request -> get activities , response code -> ' . $activitiesResponse->status() . ' message -> ' . $activitiesResponse->body());
            return;
        }

        $activities = [];
        $activitiesResponse = json_decode($activitiesResponse->body(), true);
        foreach ($activitiesResponse['items'] as $activity) {
            $activityId = $activity['id'];
            $activity['name'] = $activity['title'];
            $activity['thumbnail'] = $activity['keyImage'];
            unset($activity['id'], $activity['title'], $activity['keyImage']);

            //search in importData
            $importData = $this->importDataRepo->search(
                ProductTypeConstant::getId(ProductTypeConstant::ACTIVITY),
                $activityId);

            //update product if exist
            if ($importData) {
                $this->productRepo->updateWithId($importData->product_id, $activity);
                continue;
            }

            //create new product if not exist
            $productId = $this->productRepo->create($activity)->id;
            $this->importDataRepo->create([
                'product_id' => $productId,
                'provider_id' => $activityId,
                'type_id' => ProductTypeConstant::getId(ProductTypeConstant::ACTIVITY)
            ]);

            $activities[] = $activity;
        }

        //todo get availabilities
    }

    public function getEvents(): void
    {
        if (!$this->hasEvent) return;

        $eventsResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])
            ->post("{$this->baseUrl}/events", [
                "startDate" => "2022-06-12",
                "endDate" => "2022-06-12"
            ]);

        if ($eventsResponse->failed()) {
            Log::error('provider -> majesty, request -> get events , response code -> ' . $eventsResponse->status() . ' message -> ' . $eventsResponse->body());
            return;
        }

        $eventsResponse = json_decode($eventsResponse->body(), true);
        foreach ($eventsResponse as $event) {
            $eventId = $event['id'];
            $event['name'] = $event['title'];
            unset($event['id'], $event['title'], $event['startsAt']);

            //get event details
            $detailResponse = Http::get("{$this->baseUrl}/events/{$eventId}");

            if ($detailResponse->failed()) {
                Log::error('provider -> majesty, request -> get event detail , response code -> ' . $detailResponse->status() . ' message -> ' . $detailResponse->body());
                continue;
            }

            $detailResponse = json_decode($detailResponse->body(), true);
            $event['description'] = $detailResponse['description'];

            $eventAvailability = [
                'price' => $detailResponse['pricing']['amount'],
                'start_time' => $detailResponse['timing']['startsAt'],
                'end_time' => $detailResponse['timing']['endsAt'],
            ];

            //search product
            $importData = $this->importDataRepo->search(
                ProductTypeConstant::getId(ProductTypeConstant::EVENT),
                $eventId);

            //update product if exist
            if ($importData) {
                $this->productRepo->updateWithId($importData->product_id, $event);
                $this->availabilityRepo->updateWithProductId($importData->product_id, $eventAvailability);
            } else {
                //create new product and availability if not exist
                $productId = $this->productRepo->create($event)->id;

                $eventAvailability['product_id'] = $productId;
                $this->availabilityRepo->create($eventAvailability);
                $this->importDataRepo->create([
                    'product_id' => $productId,
                    'provider_id' => $eventId,
                    'type_id' => ProductTypeConstant::getId(ProductTypeConstant::EVENT)
                ]);
            }
        }


    }
}

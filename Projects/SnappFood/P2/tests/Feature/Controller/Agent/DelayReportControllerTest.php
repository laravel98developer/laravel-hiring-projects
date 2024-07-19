<?php

namespace Tests\Feature\Controller\Agent;

use App\Enums\DeliveryReport\Status;
use App\Models\Agent;
use App\Models\DelayReport;
use App\Models\DelayReportStatus;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Ulid;
use Tests\TestCase;

class DelayReportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testAssignToAgent()
    {
        $agent = Agent::factory()->create();

        Vendor::factory()
            ->has(
                Order::factory()
                    ->has(
                        DelayReport::factory()
                            ->has(
                                DelayReportStatus::factory()
                                    ->state([
                                        'status' => Status::CREATED,
                                    ])
                            )
                            ->count(1)
                    )
                    ->count(1)
            )
            ->count(1)
            ->create();

        $this->post(
            route('agents.delay-reports.assign'), [
                'agent_id' => $agent->id,
            ]
        )
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'agent_id' => $agent->id,
                ],
            ]);
    }

    public function testAssignToAgentWithOutDelayReport()
    {
        $agent = Agent::factory()->create();

        $this->post(route('agents.delay-reports.assign'), [
            'agent_id' => $agent->id,
        ])->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'errors' => [
                    'detail' => 'delay report not found',
                ],
            ]);

        Vendor::factory()
            ->has(
                Order::factory()
                    ->has(
                        DelayReport::factory()
                            ->has(
                                DelayReportStatus::factory()
                                    ->state([
                                        'status' => Status::COMPLETED,
                                    ])
                            )
                            ->count(1)
                    )
                    ->count(1)
            )
            ->count(1)
            ->create();

        $this->post(
            route('agents.delay-reports.assign'), [
                'agent_id' => $agent->id,
            ]
        )
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'errors' => [
                    'detail' => 'delay report not found',
                ],
            ]);
    }

    public function testDoubleAssignToAgent()
    {
        $agent = Agent::factory()->create();

        Vendor::factory()
            ->has(
                Order::factory()
                    ->has(
                        DelayReport::factory()
                            ->has(
                                DelayReportStatus::factory()
                                    ->state([
                                        'status' => Status::CREATED,
                                    ])
                            )
                            ->count(1)
                    )
                    ->count(1)
            )
            ->count(1)
            ->create();

        $this->post(
            route('agents.delay-reports.assign'), [
                'agent_id' => $agent->id,
            ]
        )
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'agent_id' => $agent->id,
                ],
            ]);

        $this->post(
            route('agents.delay-reports.assign'), [
                'agent_id' => $agent->id,
            ]
        )
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => [
                    'detail' => 'agent has delay report',
                ],
            ]);
    }

    public function testAssignToAgentWithInvalidAgentId()
    {
        $this->post(
            route('agents.delay-reports.assign'), [
                'agent_id' => Ulid::generate(),
            ]
        )
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'errors' => [
                    'detail' => 'agent not found',
                ],
            ]);
    }

    public function testAnalytics()
    {
        Vendor::factory()
            ->has(
                Order::factory()->has(
                    DelayReport::factory()->has(
                        DelayReportStatus::factory()->state([
                            'status' => \App\Enums\DeliveryReport\Status::COMPLETED,
                        ])->count(1)
                    )->count(2)
                )->count(1)
            )->count(3)
            ->create();

        $items = $this->get(route('agents.delay-reports.analytics'))
            ->assertStatus(Response::HTTP_OK)
            ->json('data');

        foreach ($items as $item) {
            $sum = DB::table('delay_reports')
                ->where('vendor_id', $item['vendor_id'])
                ->join('orders', 'delay_reports.order_id', 'orders.id')
                ->join('vendors', 'orders.vendor_id', 'vendors.id')
                ->sum('delay_reports.delay_minute');

            $this->assertTrue($sum == $item['delay_minutes']);
        }
    }
}

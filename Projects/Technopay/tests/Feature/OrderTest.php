<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function get_all_data_with_out_any_filter(): void
    {
        Order::factory(10)->create();
        $this->get(route('orders.filter'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ]);

        $this->assertDatabaseCount(Order::class, 10);

    }

    public function filter_by_mobile(): void
    {
        $data = Order::factory(10)->create();

        $this->get(route('orders.filter', ['mobile' => $data[0]->mobile_number]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertJsonCount(1)
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $data[0]->mobile_number,
                        'national_code' => $data[0]->national_code,
                        'amount'        => $data[0]->amount,
                        'status'        => $data[0]->status ? 'success' : 'failed'
                    ]
                ]
            ]);

        $this->assertDatabaseCount(Order::class, 10);

    }

    public function test_filter_by_national_code(): void
    {
        $data = Order::factory(10)->create();

        $this->get(route('orders.filter', ['national_code' => $data[0]->national_code]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertJsonCount(1)
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $data[0]->mobile_number,
                        'national_code' => $data[0]->national_code,
                        'amount'        => $data[0]->amount,
                        'status'        => $data[0]->status ? 'success' : 'failed'
                    ]
                ]
            ]);
        $this->assertDatabaseCount(Order::class, 10);
    }

    public function test_filter_by_status(): void
    {
        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 20000,
            'status'        => false
        ]);

        $orderBetween = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 25000,
            'status'        => true,
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween['mobile_number'],
            'national_code' => $orderBetween['national_code'],
            'amount'        => $orderBetween['amount'],
            'status'        => $orderBetween['status'],
        ]);


        $orderBetween2 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 100000,
            'status'        => false,
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween2['mobile_number'],
            'national_code' => $orderBetween2['national_code'],
            'amount'        => $orderBetween2['amount'],
            'status'        => $orderBetween2['status'],
        ]);


        $this->get(route('orders.filter', ['status' => 'success']))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $orderBetween['mobile_number'],
                        'national_code' => $orderBetween['national_code'],
                        'amount'        => $orderBetween['amount'],
                        'status'        => 'success'
                    ]
                ]
            ]);;
        $this->assertDatabaseCount(Order::class, 3);

    }

    public function test_filter_by_min_amount(): void
    {
        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 20000,
            'status'        => rand(0, 1),
        ]);

        $order2 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 22000,
            'status'        => rand(0, 1),
        ];

        Order::query()->insert([
            'mobile_number' => $order2['mobile_number'],
            'national_code' => $order2['national_code'],
            'amount'        => $order2['amount'],
            'status'        => $order2['status'],
        ]);


        $res = $this->get(route('orders.filter', ['min' => 21000]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertJsonCount(1)
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $order2['mobile_number'],
                        'national_code' => $order2['national_code'],
                        'amount'        => $order2['amount'],
                        'status'        => $order2['status'] ? 'success' : 'failed'
                    ]
                ]
            ]);

        $this->assertDatabaseCount(Order::class, 2);
    }

    public function test_filter_by_max_amount(): void
    {
        $order1 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 20000,
            'status'        => rand(0, 1),
        ];
        Order::query()->insert([
            'mobile_number' => $order1['mobile_number'],
            'national_code' => $order1['national_code'],
            'amount'        => $order1['amount'],
            'status'        => $order1['status'],
        ]);


        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 30000,
            'status'        => rand(0, 1),
        ]);


        $res = $this->get(route('orders.filter', ['max' => 29000]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertExactJson([
                'data' => [
                    ['mobile_number' => $order1['mobile_number'],
                     'national_code' => $order1['national_code'],
                     'amount'        => $order1['amount'],
                     'status'        => $order1['status'] ? 'success' : 'failed',
                    ]
                ]
            ]);

        $this->assertDatabaseCount(Order::class, 2);

    }

    public function test_filter_by_min_max_amount(): void
    {
        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 20000,
            'status'        => rand(0, 1),
        ]);

        $orderBetween1 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 25000,
            'status'        => rand(0, 1),
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween1['mobile_number'],
            'national_code' => $orderBetween1['national_code'],
            'amount'        => $orderBetween1['amount'],
            'status'        => $orderBetween1['status'],
        ]);


        $orderBetween2 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 25000,
            'status'        => rand(0, 1),
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween2['mobile_number'],
            'national_code' => $orderBetween2['national_code'],
            'amount'        => $orderBetween2['amount'],
            'status'        => $orderBetween2['status'],
        ]);


        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 80000,
            'status'        => rand(0, 1),
        ]);


        $res = $this->get(route('orders.filter', ['min' => 21000, 'max' => 75000]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $orderBetween1['mobile_number'],
                        'national_code' => $orderBetween1['national_code'],
                        'amount'        => $orderBetween1['amount'],
                        'status'        => $orderBetween1['status'] ? 'success' : 'failed',
                    ],
                    [
                        'mobile_number' => $orderBetween2['mobile_number'],
                        'national_code' => $orderBetween2['national_code'],
                        'amount'        => $orderBetween2['amount'],
                        'status'        => $orderBetween2['status'] ? 'success' : 'failed',
                    ]
                ]
            ]);

        $this->assertDatabaseCount(Order::class, 4);
    }

    public function test_filter_by_mix_condition(): void
    {
        Order::query()->insert([
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 20000,
            'status'        => rand(0, 1),
        ]);

        $orderBetween = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 25000,
            'status'        => true,
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween['mobile_number'],
            'national_code' => $orderBetween['national_code'],
            'amount'        => $orderBetween['amount'],
            'status'        => $orderBetween['status'],
        ]);


        $orderBetween2 = [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => 100000,
            'status'        => rand(0, 1),
        ];
        Order::query()->insert([
            'mobile_number' => $orderBetween2['mobile_number'],
            'national_code' => $orderBetween2['national_code'],
            'amount'        => $orderBetween2['amount'],
            'status'        => $orderBetween2['status'],
        ]);


        $res = $this->get(route('orders.filter', ['min' => 21000, 'max' => 75000, 'status' => true, 'mobile' => $orderBetween['mobile_number'], 'national_code' => $orderBetween['national_code']]))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'mobile_number',
                        'national_code',
                        'amount',
                        'status'
                    ]
                ]
            ])
            ->assertExactJson([
                'data' => [
                    [
                        'mobile_number' => $orderBetween['mobile_number'],
                        'national_code' => $orderBetween['national_code'],
                        'amount'        => $orderBetween['amount'],
                        'status'        => 'success'
                    ],

                ]
            ]);

        $this->assertDatabaseCount(Order::class, 3);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Services\KhqrService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KhqrPayloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_khqr_payload_contains_merchant(): void
    {
        // Arrange: create a fake order
        $order = Order::factory()->create([
            'total'    => 5000,
            'currency' => 'USD',
        ]);

        // Act: build payload
        $payload = app(KhqrService::class)->makePayload($order);

        // Assert: merchant_id exists and matches env
        $this->assertArrayHasKey('merchant_id', $payload);
        $this->assertEquals(env('KHQR_MERCHANT_ID'), $payload['merchant_id']);
    }

    public function test_khqr_payload_contains_order_reference(): void
    {
        $order = Order::factory()->create([
            'total'    => 2500,
            'currency' => 'USD',
        ]);

        $payload = app(KhqrService::class)->makePayload($order);

        $this->assertArrayHasKey('reference', $payload);
        $this->assertEquals($order->order_number, $payload['reference']);
    }

    public function test_khqr_payload_amount_is_float(): void
    {
        $order = Order::factory()->create([
            'total'    => 1234,
            'currency' => 'USD',
        ]);

        $payload = app(KhqrService::class)->makePayload($order);

        $this->assertIsFloat($payload['amount']);
        $this->assertEquals(1234.0, $payload['amount']);
    }
}
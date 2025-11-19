<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderPlacedEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_placed_event_dispatched(): void
    {
        // Arrange: create an order
        $order = Order::factory()->create();

        // Act: dispatch the event
        event(new OrderPlaced($order));

        // Assert: event was dispatched
        Event::assertDispatched(OrderPlaced::class, function ($event) use ($order) {
            return $event->order->is($order);
        });
    }
}
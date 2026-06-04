<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Models\Order;
use App\Models\User;
use Livewire\Livewire;

it('requires auth for order routes', function () {
    $order = Order::factory()->create();

    $this->get('/admin/orders')->assertRedirect('/admin/login');
    $this->get("/admin/orders/{$order->id}")->assertRedirect('/admin/login');
    $this->get("/admin/orders/{$order->id}/edit")->assertRedirect('/admin/login');
});

it('lists orders', function () {
    $user = User::factory()->create();
    Order::factory()->count(3)->create();

    Livewire::actingAs($user)->test(ListOrders::class)
        ->assertSuccessful();
});

it('views order details', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create();

    Livewire::actingAs($user)->test(ViewOrder::class, ['record' => $order->id])
        ->assertSuccessful();
});

it('edits order status', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['status' => OrderStatus::Pending->value]);

    Livewire::actingAs($user)->test(EditOrder::class, ['record' => $order->id])
        ->set('data.status', OrderStatus::Shipped->value)
        ->call('save')
        ->assertHasNoErrors();

    expect($order->fresh()->status)->toBe(OrderStatus::Shipped);
});

it('ships order via table action', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['status' => OrderStatus::Pending->value]);

    Livewire::actingAs($user)->test(ListOrders::class)
        ->call('mountTableAction', 'ship', $order->id)
        ->call('callMountedTableAction')
        ->assertHasNoErrors();

    expect($order->fresh()->status)->toBe(OrderStatus::Shipped);
});

it('delivers and pays order via table action', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['status' => OrderStatus::Shipped->value]);

    Livewire::actingAs($user)->test(ListOrders::class)
        ->call('mountTableAction', 'deliver', $order->id)
        ->call('callMountedTableAction')
        ->assertHasNoErrors();

    $fresh = $order->fresh();
    expect($fresh->status)->toBe(OrderStatus::Delivered);
    expect($fresh->payment_status)->toBe(PaymentStatus::Paid);
});

it('cancels order via table action', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create(['status' => OrderStatus::Pending->value]);

    Livewire::actingAs($user)->test(ListOrders::class)
        ->call('mountTableAction', 'cancel', $order->id)
        ->call('callMountedTableAction')
        ->assertHasNoErrors();

    expect($order->fresh()->status)->toBe(OrderStatus::Cancelled);
});

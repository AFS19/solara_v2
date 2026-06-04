<?php

use App\Models\NewsletterSubscriber;

it('subscribes a new email', function () {
    $response = $this->post(route('newsletter.subscribe'), [
        'email' => 'test@example.com',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', trans('newsletter.success'));

    $this->assertDatabaseHas(NewsletterSubscriber::class, [
        'email' => 'test@example.com',
    ]);
});

it('rejects invalid email', function () {
    $response = $this->post(route('newsletter.subscribe'), [
        'email' => 'not-an-email',
    ]);

    $response->assertSessionHasErrors(['email']);
});

it('rejects duplicate email', function () {
    NewsletterSubscriber::factory()->create(['email' => 'dup@example.com']);

    $response = $this->post(route('newsletter.subscribe'), [
        'email' => 'dup@example.com',
    ]);

    $response->assertSessionHasErrors(['email']);
});

it('requires email', function () {
    $response = $this->post(route('newsletter.subscribe'), []);

    $response->assertSessionHasErrors(['email']);
});

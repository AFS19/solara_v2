<?php

use App\Models\Contact;

it('renders contact page', function () {
    $response = $this->get(route('contact'));

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Contact'));
});

it('stores contact submission', function () {
    $response = $this->post(route('contact.store'), [
        'full_name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'message' => 'Hello from the test suite.',
    ]);

    $response->assertRedirect(route('contact'));
    $response->assertInertiaFlash('toast');

    $this->assertDatabaseHas(Contact::class, [
        'full_name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);
});

it('rejects invalid contact submission', function () {
    $response = $this->post(route('contact.store'), []);

    $response->assertSessionHasErrors(['full_name', 'email', 'message']);
});

it('rejects invalid email', function () {
    $response = $this->post(route('contact.store'), [
        'full_name' => 'Jane Doe',
        'email' => 'not-an-email',
        'message' => 'Test',
    ]);

    $response->assertSessionHasErrors(['email']);
});

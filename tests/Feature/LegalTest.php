<?php

use App\Models\Page;

it('renders legal page', function () {
    Page::factory()->create([
        'slug' => 'mentions-legales',
        'title' => 'Mentions légales',
        'content' => '<p>Legal content.</p>',
    ]);

    $response = $this->get(route('legal'));

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Legal')
        ->has('page.title')
        ->has('page.content')
    );
});

it('returns 404 when legal page missing', function () {
    $response = $this->get(route('legal'));

    $response->assertStatus(404);
});

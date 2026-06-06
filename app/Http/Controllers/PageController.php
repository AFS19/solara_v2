<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageController extends Controller
{
    public function legal()
    {
        $page = Page::query()
            ->where('slug', 'mentions-legales')
            ->where('is_active', true)
            ->firstOrFail();

        return Inertia::render('Legal', [
            'page' => $page,
        ]);
    }
}

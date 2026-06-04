<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ], [
            'email.required' => trans('newsletter.validation.email.required'),
            'email.email' => trans('newsletter.validation.email.email'),
            'email.unique' => trans('newsletter.validation.email.unique'),
        ]);

        NewsletterSubscriber::create($validated);

        return redirect()->back()->with('success', trans('newsletter.success'));
    }
}

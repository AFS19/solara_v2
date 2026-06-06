<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact');
    }

    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => trans('home.contact.success', [], 'fr'),
        ]);

        return redirect()->route('contact');
    }
}

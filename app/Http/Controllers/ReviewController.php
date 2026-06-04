<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $rules = [
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ];

        if (! $request->user()) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'email', 'max:255'];
        }

        $validated = $request->validate($rules, [
            'rating.required' => trans('reviews.validation.rating.required'),
            'rating.between' => trans('reviews.validation.rating.between'),
            'comment.max' => trans('reviews.validation.comment.max'),
            'name.required' => trans('reviews.validation.name.required_without'),
            'email.required' => trans('reviews.validation.email.required_without'),
            'email.email' => trans('reviews.validation.email.email'),
        ]);

        $reviewData = [
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_approved' => false,
        ];

        if ($request->user()) {
            $reviewData['user_id'] = $request->user()->id;
            $reviewData['name'] = $request->user()->name;
            $reviewData['email'] = $request->user()->email;
        } else {
            $reviewData['name'] = $validated['name'];
            $reviewData['email'] = $validated['email'];
        }

        Review::create($reviewData);

        return redirect()->back()->with('success', trans('reviews.success'));
    }
}

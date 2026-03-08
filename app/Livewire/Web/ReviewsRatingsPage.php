<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\Review;
use Livewire\Component;

class ReviewsRatingsPage extends Component
{
    public function render()
    {
        return view('livewire.web.reviews-ratings-page', [
            'page' => Page::query()->where('slug', 'reviews-ratings')->first(),
            'reviews' => Review::query()->where('is_published', true)->latest()->get(),
        ])
            ->layout('layouts.web', ['title' => 'Reviews & Ratings | FrozenBytes']);
    }
}

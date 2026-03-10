<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\Review;
use Livewire\Component;

class ReviewsRatingsPage extends Component
{
    public string $reviewer_name = '';
    public string $company = '';
    public int $rating = 5;
    public string $review_text = '';

    public function submitReview(): void
    {
        $data = $this->validate([
            'reviewer_name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'max:1000'],
        ]);

        Review::query()->create([
            ...$data,
            'is_published' => false,
        ]);

        $this->reset(['reviewer_name', 'company', 'review_text']);
        $this->rating = 5;

        session()->flash('review_submitted', 'Thanks for your feedback. Your review has been submitted for approval.');
    }

    public function render()
    {
        return view('livewire.web.reviews-ratings-page', [
            'page' => Page::query()->where('slug', 'reviews-ratings')->first(),
            'reviews' => Review::query()->where('is_published', true)->latest()->get(),
        ])
            ->layout('layouts.web', ['title' => 'Reviews & Ratings | FrozenBytes']);
    }
}

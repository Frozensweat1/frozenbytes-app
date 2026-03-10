<?php

namespace App\Livewire\Web;

use App\Models\Review;
use Livewire\Component;

class ReviewDetailPage extends Component
{
    public Review $review;

    public function mount(Review $review): void
    {
        abort_unless($review->is_published, 404);
        $this->review = $review;
    }

    public function render()
    {
        return view('livewire.web.review-detail-page')
            ->layout('layouts.web', ['title' => "Review by {$this->review->reviewer_name} | FrozenBytes"]);
    }
}

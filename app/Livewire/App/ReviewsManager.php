<?php

namespace App\Livewire\App;

use App\Models\Review;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ReviewsManager extends Component
{
    public ?int $reviewId = null;
    public string $reviewer_name = '';
    public string $company = '';
    public int $rating = 5;
    public string $review_text = '';
    public bool $is_published = true;

    public function save(): void
    {
        $data = $this->validate([
            'reviewer_name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'max:1000'],
            'is_published' => ['required', 'boolean'],
        ]);

        Review::query()->updateOrCreate(['id' => $this->reviewId], $data);
        $this->resetForm();
        LivewireAlert::title('Review Saved')
            ->text('Review has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $review = Review::query()->findOrFail($id);

        $this->reviewId = $review->id;
        $this->reviewer_name = $review->reviewer_name;
        $this->company = $review->company ?? '';
        $this->rating = $review->rating;
        $this->review_text = $review->review_text;
        $this->is_published = $review->is_published;
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Review?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        Review::query()->findOrFail($id)->delete();
        $this->resetForm();
        LivewireAlert::title('Review Deleted')
            ->text('Review has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['reviewId', 'reviewer_name', 'company', 'review_text']);
        $this->rating = 5;
        $this->is_published = true;
    }

    public function render()
    {
        return view('livewire.app.reviews-manager', [
            'reviews' => Review::query()->latest()->get(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Manage Reviews | FrozenBytes',
                'heading' => 'Reviews and Ratings',
            ]);
    }
}

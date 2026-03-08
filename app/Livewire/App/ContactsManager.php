<?php

namespace App\Livewire\App;

use App\Models\ContactInquiry;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ContactsManager extends Component
{
    public function markInProgress(int $id): void
    {
        ContactInquiry::query()->findOrFail($id)->update(['status' => 'in_progress']);
        LivewireAlert::title('Inquiry Updated')
            ->text('Inquiry moved to in-progress.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function markResolved(int $id): void
    {
        ContactInquiry::query()->findOrFail($id)->update([
            'status' => 'resolved',
            'responded_at' => Carbon::now(),
        ]);
        LivewireAlert::title('Inquiry Updated')
            ->text('Inquiry marked as resolved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Inquiry?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        ContactInquiry::query()->findOrFail($id)->delete();
        LivewireAlert::title('Inquiry Deleted')
            ->text('Inquiry deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.app.contacts-manager', [
            'inquiries' => ContactInquiry::query()->latest()->get(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Manage Contacts | FrozenBytes',
                'heading' => 'Contact Requests',
            ]);
    }
}

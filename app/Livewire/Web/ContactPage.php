<?php

namespace App\Livewire\Web;

use App\Models\ContactInquiry;
use App\Models\Page;
use App\Models\SiteSetting;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ContactPage extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $message = '';

    public function submitInquiry(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        ContactInquiry::query()->create($data);

        LivewireAlert::title('Inquiry Sent')
            ->text('Your inquiry has been submitted.')
            ->info()
            ->toast()
            ->position('top-end')
            ->show();
        $this->reset(['name', 'email', 'phone', 'message']);
    }

    public function render()
    {
        return view('livewire.web.contact-page', [
            'page' => Page::query()->where('slug', 'contact-us')->first(),
            'site' => SiteSetting::current(),
        ])
            ->layout('layouts.web', ['title' => 'Contact Us | FrozenBytes']);
    }
}

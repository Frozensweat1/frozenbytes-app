<?php

namespace App\Livewire\App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class ProfileManager extends Component
{
    public string $name = '';
    public string $email = '';

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user?->name ?? '';
        $this->email = $user?->email ?? '';
    }

    public function updateProfile(): void
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $data = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($data);

        LivewireAlert::title('Profile Updated')
            ->text('Your profile information has been updated.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function updatePassword(): void
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $data = $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');

            return;
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        LivewireAlert::title('Password Updated')
            ->text('Your password has been changed successfully.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.app.profile-manager')
            ->layout('layouts.admin', [
                'title' => 'My Profile | FrozenBytes',
                'heading' => 'My Profile',
            ]);
    }
}

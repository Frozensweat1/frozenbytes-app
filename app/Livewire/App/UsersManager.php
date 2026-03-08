<?php

namespace App\Livewire\App;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersManager extends Component
{
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'editor';

    public function save(): void
    {
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($this->userId)],
            'role' => ['required', 'string', Rule::in(Role::query()->pluck('name')->all())],
        ];

        if ($this->userId) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $data = $this->validate($rules);

        $user = User::query()->find($this->userId);
        if (!$user) {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        } else {
            $payload = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $payload['password'] = Hash::make($data['password']);
            }

            $user->update($payload);
        }

        $user->syncRoles([$data['role']]);
        $this->resetForm();

        LivewireAlert::title('User Saved')
            ->text('User has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $user = User::query()->findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = $user->roles()->first()?->name ?? 'editor';
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete User?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        if (auth()->id() === $id) {
            LivewireAlert::title('Action Blocked')
                ->text('You cannot delete your own account.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();

            return;
        }

        User::query()->findOrFail($id)->delete();
        $this->resetForm();

        LivewireAlert::title('User Deleted')
            ->text('User has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['userId', 'name', 'email', 'password', 'password_confirmation']);
        $this->role = 'editor';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.app.users-manager', [
            'users' => User::query()->with('roles')->latest()->get(),
            'roles' => Role::query()->pluck('name'),
        ])->layout('layouts.admin', [
            'title' => 'Manage Users | FrozenBytes',
            'heading' => 'User Management',
        ]);
    }
}

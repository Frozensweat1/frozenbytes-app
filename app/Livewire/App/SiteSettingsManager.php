<?php

namespace App\Livewire\App;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteSettingsManager extends Component
{
    use WithFileUploads;

    public string $business_name = '';
    public string $logo_url = '';
    public ?string $logo_path = null;
    public ?string $background_one_path = null;
    public ?string $background_two_path = null;
    public $logo_file;
    public $background_one_file;
    public $background_two_file;
    public string $tagline = '';
    public string $support_email = '';
    public string $support_phone = '';
    public string $address = '';
    public string $google_map_url = '';
    public string $facebook_url = '';
    public string $instagram_url = '';
    public string $linkedin_url = '';
    public string $youtube_url = '';
    public string $tiktok_url = '';
    public string $gmail_url = '';
    public string $footer_text = '';

    public function mount(): void
    {
        $setting = SiteSetting::current();

        $this->business_name = $setting->business_name ?? '';
        $this->logo_url = $setting->logo_url ?? '';
        $this->logo_path = $setting->logo_path;
        $this->background_one_path = $setting->background_one_path;
        $this->background_two_path = $setting->background_two_path;
        $this->tagline = $setting->tagline ?? '';
        $this->support_email = $setting->support_email ?? '';
        $this->support_phone = $setting->support_phone ?? '';
        $this->address = $setting->address ?? '';
        $this->google_map_url = $setting->google_map_url ?? '';
        $this->facebook_url = $setting->facebook_url ?? '';
        $this->instagram_url = $setting->instagram_url ?? '';
        $this->linkedin_url = $setting->linkedin_url ?? '';
        $this->youtube_url = $setting->youtube_url ?? '';
        $this->tiktok_url = $setting->tiktok_url ?? '';
        $this->gmail_url = $setting->gmail_url ?? '';
        $this->footer_text = $setting->footer_text ?? '';
    }

    public function save(): void
    {
        $data = $this->validate([
            'business_name' => ['required', 'string', 'max:120'],
            'logo_url' => ['nullable', 'url', 'max:255'],
            'logo_file' => ['nullable', 'image', 'max:4096'],
            'background_one_file' => ['nullable', 'image', 'max:4096'],
            'background_two_file' => ['nullable', 'image', 'max:4096'],
            'tagline' => ['nullable', 'string', 'max:180'],
            'support_email' => ['nullable', 'email', 'max:120'],
            'support_phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'google_map_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'gmail_url' => ['nullable', 'url', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:180'],
        ]);

        $setting = SiteSetting::current();

        if ($this->logo_file) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }

            $data['logo_path'] = $this->logo_file->store('site-settings', 'public');
            $this->logo_path = $data['logo_path'];
        }

        if ($this->background_one_file) {
            if ($setting->background_one_path) {
                Storage::disk('public')->delete($setting->background_one_path);
            }

            $data['background_one_path'] = $this->background_one_file->store('site-settings', 'public');
            $this->background_one_path = $data['background_one_path'];
        }

        if ($this->background_two_file) {
            if ($setting->background_two_path) {
                Storage::disk('public')->delete($setting->background_two_path);
            }

            $data['background_two_path'] = $this->background_two_file->store('site-settings', 'public');
            $this->background_two_path = $data['background_two_path'];
        }

        $setting->update($data);
        $this->reset(['logo_file', 'background_one_file', 'background_two_file']);

        LivewireAlert::title('Settings Updated')
            ->text('Site settings have been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.app.site-settings-manager')
            ->layout('layouts.admin', [
                'title' => 'Site Settings | FrozenBytes',
                'heading' => 'Site Settings',
            ]);
    }
}

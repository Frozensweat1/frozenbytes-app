<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\SiteSetting;
use Livewire\Component;

class AboutPage extends Component
{
    public function render()
    {
        return view('livewire.web.about-page', [
            'aboutPage' => Page::query()->where('slug', 'about')->first(),
            'site' => SiteSetting::current(),
        ])
            ->layout('layouts.web', ['title' => 'About | FrozenBytes']);
    }
}

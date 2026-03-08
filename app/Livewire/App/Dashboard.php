<?php

namespace App\Livewire\App;

use App\Models\BlogPost;
use App\Models\ContactInquiry;
use App\Models\Page;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.app.dashboard', [
            'pagesCount' => Page::query()->count(),
            'servicesCount' => Service::query()->count(),
            'projectsCount' => Project::query()->count(),
            'blogCount' => BlogPost::query()->count(),
            'reviewsCount' => Review::query()->count(),
            'unreadContacts' => ContactInquiry::query()->where('status', 'new')->count(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Admin Dashboard | FrozenBytes',
                'heading' => 'Dashboard',
            ]);
    }
}

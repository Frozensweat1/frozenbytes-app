<?php

use App\Livewire\App\BlogManager;
use App\Livewire\App\ContactsManager;
use App\Livewire\App\Dashboard;
use App\Livewire\App\PagesManager;
use App\Livewire\App\ProjectsManager;
use App\Livewire\App\ProfileManager;
use App\Livewire\App\ReviewsManager;
use App\Livewire\App\ServicesManager;
use App\Livewire\App\SiteSettingsManager;
use App\Livewire\App\UsersManager;
use App\Livewire\Web\AboutPage;
use App\Livewire\Web\BlogPage;
use App\Livewire\Web\BlogPostDetailPage;
use App\Livewire\Web\ContactPage;
use App\Livewire\Web\HomePage;
use App\Livewire\Web\ProjectDetailPage;
use App\Livewire\Web\ProjectsPage;
use App\Livewire\Web\ReviewsRatingsPage;
use App\Livewire\Web\ServiceDetailPage;
use App\Livewire\Web\ServicesPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/media/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('media.show');

Route::get('/', HomePage::class)->name('web.home');
Route::get('/about', AboutPage::class)->name('web.about');
Route::get('/services', ServicesPage::class)->name('web.services');
Route::get('/services/{service}', ServiceDetailPage::class)->name('web.services.show');
Route::get('/projects', ProjectsPage::class)->name('web.projects');
Route::get('/projects/{project}', ProjectDetailPage::class)->name('web.projects.show');
Route::get('/blog', BlogPage::class)->name('web.blog');
Route::get('/blog/{post:slug}', BlogPostDetailPage::class)->name('web.blog.show');
Route::get('/contact-us', ContactPage::class)->name('web.contact');
Route::get('/reviews-ratings', ReviewsRatingsPage::class)->name('web.reviews');

Route::middleware(['auth', 'role:admin'])
    ->prefix('app')
    ->name('app.')
    ->group(function (): void {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/pages', PagesManager::class)->name('pages');
        Route::get('/services', ServicesManager::class)->name('services');
        Route::get('/projects', ProjectsManager::class)->name('projects');
        Route::get('/blog', BlogManager::class)->name('blog');
        Route::get('/reviews', ReviewsManager::class)->name('reviews');
        Route::get('/contacts', ContactsManager::class)->name('contacts');
        Route::get('/users', UsersManager::class)->name('users');
        Route::get('/profile', ProfileManager::class)->name('profile');
        Route::get('/settings', SiteSettingsManager::class)->name('settings');
    });

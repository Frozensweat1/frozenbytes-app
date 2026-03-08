<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $pages = [
            route('web.home'),
            route('web.about'),
            route('web.services'),
            route('web.projects'),
            route('web.blog'),
            route('web.contact'),
            route('web.reviews'),
            route('login'),
            route('register'),
        ];

        foreach ($pages as $page) {
            $this->get($page)->assertOk();
        }
    }
}

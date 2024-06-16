<?php

namespace App\Providers;

use App\Events\GifBookmarked;
use App\Events\GifGetByIdPerformed;
use App\Events\GifSearchPerformed;
use App\Listeners\LogGifBookmarked;
use App\Listeners\LogGifById;
use App\Listeners\LogGifSearch;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        GifSearchPerformed::class => [
            LogGifSearch::class,
        ],

        GifGetByIdPerformed::class => [
            LogGifById::class,
        ],

        GifBookmarked::class => [
            LogGifBookmarked::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

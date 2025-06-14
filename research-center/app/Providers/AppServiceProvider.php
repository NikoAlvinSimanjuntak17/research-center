<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Contact;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $groupedContacts = Contact::all()->groupBy('key');

        view()->composer('*', function ($view) use ($groupedContacts) {
            $totalPendingCollaborators = \App\Models\Collaborator::where('status', 'pending')->count();

            $view->with([
                'totalPendingCollaborators' => $totalPendingCollaborators,
                'groupedContacts' => $groupedContacts,
            ]);
        });
    }
}
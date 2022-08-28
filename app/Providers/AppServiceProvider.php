<?php

namespace App\Providers;

use App\Actions\FilterCountry;
use App\Actions\CreateNewHotel;
use App\Contracts\FilterCountries;
use App\Actions\AddressCreatorAction;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AddressCreatorActions;
use App\Contracts\CreateNewResidencyContarct;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // binding interfaces to implementations
        $this->app->bind(FilterCountries::class, FilterCountry::class);
        $this->app->bind(AddressCreatorActions::class, AddressCreatorAction::class);
        $this->app->bind(SingleResidencyActions::class, SingleResidencyAction::class);
        $this->app->bind(UpdateResidencies::class, UpdateHotel::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}

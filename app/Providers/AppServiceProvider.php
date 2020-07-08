<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $models = array(
            'Company',
            'ContactPerson',
            'Offer',
            'Product'
        );
        foreach ($models as $model) {
            $this->app->bind('App\Repositories\\'.$model.'Repository','App\Repositories\Impl\\'.$model.'RepositoryImpl');
            $this->app->bind('App\Services\\'.$model.'Service', 'App\Services\Impl\\'.$model.'ServiceImpl');
        }
    }
}

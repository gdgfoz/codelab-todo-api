<?php

namespace GDGFoz\Providers;

use GDGFoz\Events\UserCreateEvent;
use GDGFoz\Hooks\ResponseFractal\ResponseFractal;
use GDGFoz\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user) {
            event( new UserCreateEvent($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('League\Fractal\Serializer\SerializerAbstract', 'League\Fractal\Serializer\ArraySerializer');

        $this->app->bind('response_fractal', function($app)
        {
            return new ResponseFractal(
                $app['League\Fractal\Serializer\SerializerAbstract'],
                $app['Illuminate\Http\Request']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('response_fractal');
    }

}

<?php

namespace App\Providers;


use App\Repositories\OutOfficeRepository; 
use App\Repositories\ApproverRepository; 
use App\Repositories\OutOfficeRepositoryInterface;
use App\Repositories\ApproverRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
      }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(OutOfficeRepositoryInterface::class, OutOfficeRepository::class);
        $this->app->bind(ApproverRepositoryInterface::class, ApproverRepository::class);
      
    }
}

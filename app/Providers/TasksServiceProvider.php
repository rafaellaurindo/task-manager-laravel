<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Repositories\TaskRepositoryEloquent;
use App\Repositories\Contracts\TaskRepository;

class TasksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(TaskRepository::class, TaskRepositoryEloquent::class);
    }
}

<?php

namespace App\Providers;

use App\Interfaces\UserInterface;
use App\Interfaces\EmployeeInterface;
use App\Interfaces\ProjectInterface;
use App\Repositories\UserRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserInterface::class => UserRepository::class,
        EmployeeInterface::class => EmployeeRepository::class,
        ProjectInterface::class => ProjectRepository::class

    ];
    
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
    }
}
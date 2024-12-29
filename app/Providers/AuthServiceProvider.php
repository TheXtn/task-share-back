<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\TaskList;
use App\Policies\TaskListPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        TaskList::class => TaskListPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}


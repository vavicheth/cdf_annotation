<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        //role_id = 5 is Directors
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Departments
        Gate::define('department_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Titles
        Gate::define('title_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('title_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('title_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('title_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('title_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Positions
        Gate::define('position_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: User actions
        Gate::define('user_action_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Documents
        Gate::define('document_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('document_create', function ($user) {
            return in_array($user->role_id, [1, 2,4,5]);
        });
        Gate::define('document_edit', function ($user) {
            return in_array($user->role_id, [1, 2,4,5]);
        });
        Gate::define('document_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('document_delete', function ($user) {
            return in_array($user->role_id, [1, 2,5]);
        });

        // Auth gates for: Comments
        Gate::define('comment_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('comment_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('comment_edit', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('comment_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });
        Gate::define('comment_delete', function ($user) {
            return in_array($user->role_id, [1, 2, 3,4,5]);
        });

        // Auth gates for: Edit PDF file
        Gate::define('edit_pdf', function ($user) {
            return in_array($user->role_id, [1,5]);
        });

    }
}

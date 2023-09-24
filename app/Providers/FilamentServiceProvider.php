<?php

namespace App\Providers;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            if (auth()->user()) {
                if (auth()->user()->is_admin === 1 && auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator'])) {
                    Filament::registerUserMenuItems([
                        MenuItem::make()->label('Manage Users')->url(UserResource::getUrl())->icon('heroicon-o-users'),
                        MenuItem::make()->label('Manage Roles')->url(RoleResource::getUrl())->icon('heroicon-o-cog'),
                        MenuItem::make()->label('Manage Permissions')->url(PermissionResource::getUrl())->icon('heroicon-o-key'),
                    ]);
                }
            }
        });
    }
}

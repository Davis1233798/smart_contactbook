<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [

            // Menu::make(__('Users'))
            //     ->icon('bs.people')
            //     ->route('platform.systems.users')
            //     ->permission('platform.systems.users')
            //     ->title(__('Access Controls')),

            // Menu::make(__('Roles'))
            //     ->icon('bs.shield')
            //     ->route('platform.systems.roles')
            //     ->permission('platform.systems.roles')
            //     ->divider(),

            // Menu::make('Documentation')
            //     ->title('Docs')
            //     ->icon('bs.box-arrow-up-right')
            //     ->url('https://orchid.software/en/docs')
            //     ->target('_blank'),





            Menu::make('學生管理')
                ->title('學生管理')
                ->icon('bs.box-arrow-up-right')
                ->route('platform.students.list'),


            Menu::make('聯絡簿管理')
                ->title('聯絡簿管理')
                ->icon('bs.box-arrow-up-right')
                ->route('platform.contactbook.list'),

            // Menu::make('課表管理')
            //     ->title('課表管理')
            //     ->icon('bs.box-arrow-up-right')
            //     ->route('platform.subject-table.list'),




            // Menu::make('Changelog')
            //     ->icon('bs.box-arrow-up-right')
            //     ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
            //     ->target('_blank')
            //     ->badge(fn () => Dashboard::version(), Color::DARK),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}

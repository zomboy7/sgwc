<?php

use Illuminate\Database\Seeder;

class SModuleSeeder extends Seeder
{
    protected $module = [
        [
            'name' => 'report_system',
            'description' => 'Reporting system that allows you to create reports',
            'version' => '1.0',
            'is_enabled' => true,
            'menu_items' => [
                [
                    'text' => '<i class="fas fa-flag"></i> Подать жалобу',
                    'route' => 'page.reports.panel',
                    'route_params' => null,
                    'access' => null,
                    'access_params' => null,
                    'child' => null,
                    'position' => 4,
                    'type' => 'main'
                ],
                [
                    'text' => '<i class="fas fa-angry"></i> Репорты',
                    'route' => '#',
                    'route_params' => null,
                    'access' => 'permission',
                    'access_params' => 'page.reports.panel',
                    'child' => null,
                    'position' => 4,
                    'type' => 'adminpanel'
                ]
            ]
        ],
        [
            'name' => 'rules_list',
            'description' => 'Game project rules list',
            'version' => '1.0',
            'is_enabled' => true,
            'menu_items' => [
                [
                    'text' => '<i class="fas fa-book"></i> Правила',
                    'route' => 'rules.list',
                    'route_params' => null,
                    'access' => null,
                    'access_params' => null,
                    'child' => null,
                    'position' => 3,
                    'type' => 'main'
                ],
            ]
        ],
        [
            'name' => 'players_rating',
            'description' => 'Rating of players on game servers',
            'version' => '1.0',
            'is_enabled' => true,
            'menu_items' => [
                [
                    'text' => '<i class="fas fa-chart-line"></i> Рейтинг',
                    'route' => 'rating',
                    'route_params' => null,
                    'access' => null,
                    'access_params' => null,
                    'child' => null,
                    'position' => 2,
                    'type' => 'main'
                ],
            ]
        ]
    ];

    public function run()
    {
        foreach ($this->module as $module) {
            $siteModule = new \App\SiteModule();
            $siteModule->name = $module['name'];
            $siteModule->description = $module['description'];
            $siteModule->version = $module['version'];
            $siteModule->is_enabled = $module['is_enabled'];
            $siteModule->save();

            foreach ($module['menu_items'] as $menuElement) {
                $menuItem = new \App\MenuItem();
                $menuItem->site_module_id = $siteModule->id;
                $menuItem->text = $menuElement['text'];
                $menuItem->route = $menuElement['route'];
                $menuItem->route_params = $menuElement['route_params'];
                $menuItem->access = $menuElement['access'];
                $menuItem->access_params = $menuElement['access_params'];
                $menuItem->parent_id = null;
                $menuItem->position = $menuElement['position'];
                $menuItem->type = $menuElement['type'];
                $menuItem->save();

                if ($menuElement['child']) {
                    $childMenuItem = new \App\MenuItem();
                    $childMenuItem->text = $menuElement['child']['text'];
                    $childMenuItem->route = $menuElement['child']['route'];
                    $childMenuItem->route_params = $menuElement['child']['route_params'];
                    $childMenuItem->access = $menuElement['child']['access'];
                    $childMenuItem->access_params = $menuElement['child']['access_params'];
                    $childMenuItem->parent_id = $menuItem->id;
                    $childMenuItem->position = $menuElement['child']['position'];
                    $childMenuItem->type = $menuElement['child']['type'];
                    $childMenuItem->save();
                }
            }
        }
    }
}

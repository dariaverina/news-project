<?php

namespace RtNews\NewsModule;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'News Module',
            'description' => 'Manage news articles',
            'author'      => 'RtNews',
            'icon'        => 'icon-newspaper-o',
        ];
    }

    public function registerNavigation()
    {
        return [
            'news' => [
                'label'       => 'News',
                'url'         => Backend::url('rtnews/newsmodule/news'),
                'icon'        => 'icon-newspaper-o',
                'permissions' => ['rtnews.newsmodule.news'],
                'order'       => 500,
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'rtnews.newsmodule.news' => [
                'tab'   => 'News',
                'label' => 'News Manage',
            ],
        ];
    }
    public function boot()
    {
        \Route::group(['prefix' => 'api/news', 'middleware' => ['api']], function () {
            \Route::get('/', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'index']);
            \Route::get('/{slug}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'show']);
            \Route::post('/', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'store']);
            \Route::put('/{id}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'update']);
            \Route::delete('/{id}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'destroy']);
        });
    }
}

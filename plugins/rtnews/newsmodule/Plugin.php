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
}

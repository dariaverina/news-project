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

    public function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('cors', \RtNews\NewsModule\Middleware\CorsMiddleware::class);
    }

    public function boot()
    {
        $this->registerMiddleware();

        $this->app['router']->pushMiddlewareToGroup('api', 'cors');

        // Авторизация
        \Route::group(['prefix' => 'api', 'middleware' => ['web', 'api']], function () {
            \Route::post('/login', [\RtNews\NewsModule\Controllers\AuthController::class, 'login']);
            \Route::post('/logout', [\RtNews\NewsModule\Controllers\AuthController::class, 'logout']);
            \Route::get('/check', [\RtNews\NewsModule\Controllers\AuthController::class, 'check']);

            \Route::group(['prefix' => 'news', 'middleware' => ['web', 'api']], function () {
                \Route::post('/', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'store']);
                \Route::put('/{id}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'update']);
                \Route::delete('/{id}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'destroy']);
            });
        });

        // Публичные роуты новостей
        \Route::group(['prefix' => 'api/news', 'middleware' => ['api']], function () {
            \Route::get('/', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'index']);
            \Route::get('/{slug}', [\RtNews\NewsModule\Controllers\ApiNewsController::class, 'show']);
        });

        // CORS 
        \Route::options('api/{any}', function (\Illuminate\Http\Request $request) {
            $allowedOrigins = config('cors.allowed_origins', []);
            $origin = $request->headers->get('Origin');

            $response = response('', 200)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
                ->header('Access-Control-Allow-Credentials', 'true');

            if (in_array($origin, $allowedOrigins)) {
                $response->headers->set('Access-Control-Allow-Origin', $origin);
            }

            return $response;
        })->where('any', '.*');
    }
}

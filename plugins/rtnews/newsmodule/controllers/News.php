<?php

namespace RtNews\NewsModule\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * News Backend Controller
 */
class News extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['rtnews.newsmodule.news'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('RtNews.NewsModule', 'newsmodule', 'news');
    }
}

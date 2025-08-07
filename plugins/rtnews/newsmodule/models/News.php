<?php

namespace RtNews\NewsModule\Models;

use Model;

/**
 * News Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class News extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $table = 'rtnews_news';

    protected $fillable = ['title', 'slug', 'content', 'published_at', 'is_published'];

    public $rules = [
        'title' => 'required',
        'slug' => 'required|unique:rtnews_news',
    ];
}

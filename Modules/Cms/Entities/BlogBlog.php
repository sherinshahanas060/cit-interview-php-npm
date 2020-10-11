<?php

namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;

class BlogBlog extends Model
{

    protected $fillable = [
        'id',
        'title',
        'content',
        'image',
        'created_by',
        'updated_by',
        'blog_status',
        'status'
    ];
}

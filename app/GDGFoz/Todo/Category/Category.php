<?php

namespace GDGFoz\Todo\Category;

use GDGFoz\Todo\Task\Task;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category', 'color', 'path_icon', 'path_thumb'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

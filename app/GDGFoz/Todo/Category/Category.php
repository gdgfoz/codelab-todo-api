<?php

namespace GDGFoz\Todo\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category', 'color'];
}

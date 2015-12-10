<?php

namespace GDGFoz;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [ 'name', 'description', 'user_id', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo('\GDGFoz\Category');
    }

    public function user()
    {
        return $this->belongsTo('\GDGFoz\User');
    }
}

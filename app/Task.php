<?php

namespace GDGFoz;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function category()
    {
        return $this->belongsTo('\GDGFoz\Category');
    }

    public function user()
    {
        return $this->belongsTo('\GDGFoz\User');
    }
}

<?php

namespace GDGFoz\Todo\Task;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public $relationships = ['category', 'user'];
    public $dates  = ['finalized_at'];

    protected $fillable = [ 'name', 'description', 'user_id', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo('\App\Category');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}

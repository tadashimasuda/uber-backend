<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Record extends Model
{
    //
    protected $guarded =[];
    
    // public function scopeNameSerch($query, $str)
    // {
    //     return $query->where('area', 'like', "%{$str}%");
    // }

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

    public function user(){
        return $this->hasOne('App\User');
    }
}

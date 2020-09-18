<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Timecard extends Model
{
    //
    public function employee(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
}

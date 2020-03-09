<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public $table = "owners";

    /**
     * Get the city record associated with the owner.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city(){
        return $this->hasOne('App\Models\City','id','city_id');
    }

    /**
     * Get the vehicles record associated with the owner.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicle(){
        return $this->hasMany('App\Models\Vehicle','owner_id','id');
    }
}

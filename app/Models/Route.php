<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    public $table = "routes";

    /**
     * Get the city record associated with the Routes.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function startingCity(){
        return $this->hasOne('App\Models\City','id','starting_city_id');
    }

    public function destinationCity(){
        return $this->hasOne('App\Models\City','id','destination_city_id');
    }
}

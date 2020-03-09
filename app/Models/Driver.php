<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public $table = "drivers";

    /**
     * Get the city record associated with the driver.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city(){
        return $this->hasOne('App\Models\City','id','city_id');
    }
}

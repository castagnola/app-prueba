<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $table = "vehicles";

    /**
     * Get the owner record associated with the vehicle.
     */
    public function owner(){
        return $this->belongsTo('App\Models\Owner','owner_id','id');
    }

    /**
     * Get the tipeVehicle record associated with the vehicle.
     */
    public function tipeVehicle(){
        return $this->hasOne('App\Models\TipeVehicle','id','tipe_id');
    }

}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $table = "cities";

    /**
     * Get the departament record associated with the city.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function departament(){

        return $this->hasOne('App\Models\Departament','id','departament_id');
    }

    /**
     * Get the owners record associated with the city.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){

        return $this->hasMany('App\Models\Owner','city_id','id');
    }

    /**
     * Get the drivers record associated with the city.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(){

        return $this->hasMany('App\Models\Driver','city_id','id');
    }

}

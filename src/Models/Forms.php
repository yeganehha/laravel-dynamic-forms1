<?php

namespace Yeganehha\DynamicForms\Models;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = ['name' , 'model' , 'external_table' ];

    public function fields(){
        return $this->hasMany(Fields::class);
    }
}

<?php

namespace Yeganehha\DynamicForms\Models;

use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = ['name' , 'model' , 'external_table' ];

    public function find($ids, $columns = ['*']) {
        return parent::find(self::removeDashes($ids), $columns);
    }
    public function fields($showHidden = true){
        return (bool)$showHidden ?
            $this->hasMany(Fields::class)->orderBy('order_number' ,'desc')
            :
            $this->hasMany(Fields::class)->where('status' , '!=' , 'hidden')->orderBy('order_number' ,'desc')
            ;
    }
}

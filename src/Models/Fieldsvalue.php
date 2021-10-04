<?php

namespace Yeganehha\DynamicForms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fieldsvalue extends Model
{
    protected $fillable = ['field_id','fieldable_id','fieldable_type','value'];
    protected $primaryKey = ['field_id','fieldable_id','fieldable_type'];
    public $incrementing = false;

    public function field(){
        return $this->belongsTo(Fields::class);
    }

    public function fieldable(){
        return $this->morphTo();
    }

    public static function deleteFillOutFields($fieldsId , $model , $modelType ){
        (new Fieldsvalue())->query()->where('fieldable_id' , $model)->where('fieldable_type' , $modelType)->whereIn('field_id' , $fieldsId)->delete();
    }
}

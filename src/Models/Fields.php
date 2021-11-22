<?php

namespace Yeganehha\DynamicForms\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $fillable = [ 'forms_id' , 'label' , 'description' , 'font_icon' , 'values' , 'validate' , 'type_variable' , 'status' , 'order_number' , 'blade_template'];

    public function form(){
        return $this->belongsTo(Forms::class);
    }

    public function values(){
        return $this->hasMany(Fieldsvalue::class);
    }

    public static function deleteFieldsOfForm($formId , $deleteException = []){
        (new Fields())->query()->where('forms_id' , $formId)->whereNotIn('id' , $deleteException)->delete();
    }
}

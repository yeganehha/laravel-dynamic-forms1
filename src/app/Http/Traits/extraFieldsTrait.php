<?php
namespace Yeganehha\DynamicForms\app\Http\Traits;

use Yeganehha\DynamicForms\Models\Fieldsvalue;
use Yeganehha\DynamicForms\Models\Forms;

trait extraFieldsTrait{
    public function allValues(){
        return $this->morphMany(Fieldsvalue::class ,'fieldable');
    }

    public function getForm($form){
        if ( get_class($form) == get_class(Forms::class)  ){
            return 'ss';
        }
        return $this->morphMany(Fieldsvalue::class ,'fieldable');
    }
}

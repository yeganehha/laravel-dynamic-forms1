<?php
namespace Yeganehha\DynamicForms\app\Http\Traits;

use Yeganehha\DynamicForms\Models\Fieldsvalue;
use Yeganehha\DynamicForms\Models\Forms;

trait extraFieldsTrait{
    public function allValues(){
        return $this->morphMany(Fieldsvalue::class ,'fieldable');
    }

    public function getForm($form,$showHidden = true){
        if ( ! is_object($form) )
            throw new \ErrorException("You Should Send Object of form!");
        if ( get_class($form) == Forms::class ){
            $fields =  $form->fields($showHidden)->get()->toArray();
            $fieldsId = array_column($fields, 'id');
            $values = $this->allValues()->get()->whereIn('field_id' ,  $fieldsId )->keyBy('field_id')->toArray();
            foreach ( $fields as $key => $field ){
                $fields[$key]['value'] = $values[$field['id']]['value'] ?? "";
                $fields[$key]['valuesDe'] = explode(',', $fields[$key]['values'] );
                $fieldExport[$key] = (object)$fields[$key];
            }
            return $fieldExport;
        }
        return [];
    }
}

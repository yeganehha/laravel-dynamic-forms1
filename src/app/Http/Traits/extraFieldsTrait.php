<?php
namespace Yeganehha\DynamicForms\app\Http\Traits;

trait extraFieldsTrait{
    public function allValues(){
        return $this->morphMany(\Yeganehha\DynamicForms\Models\Fieldsvalue::class ,'fieldable');
    }

    public function getForm($form,$showHidden = true,$AllInformation = false ){
        if ( is_object($form) ){
            if ( get_class($form) == \Yeganehha\DynamicForms\DynamicForms::class ){
                $form = $form->getId(false);
            } else if ( get_class($form) == \Yeganehha\DynamicForms\Models\Forms::class ){
                $form = $form->id ;
            }
        }
            ;

        $form = \Yeganehha\DynamicForms\Models\Forms::query()->find($form);
        if ( $form ){
            $fields =  $form->fields($showHidden)->get()->toArray();
            $fieldsId = array_column($fields, 'id');
            $values = $this->allValues()->get()->whereIn('field_id' ,  $fieldsId )->keyBy('field_id')->toArray();
            foreach ( $fields as $key => $field ){
                if ( $AllInformation ) {
                    $fields[$key]['value'] = $values[$field['id']]['value'] ?? "";
                    $fields[$key]['valuesDe'] = explode(',', $fields[$key]['values']);
                    $fieldExport[$key] = (object)$fields[$key];
                } else {
                    $fieldExport[$key] = (object)['field_id' => $field['id'] , 'label' => $field['label'] , 'value' => $values[$field['id']]['value'] ?? "" , "type" => $field['type_variable'], "status" => $field['status'] ];
                }
            }
            return $fieldExport;
        }
        return [];
    }
}

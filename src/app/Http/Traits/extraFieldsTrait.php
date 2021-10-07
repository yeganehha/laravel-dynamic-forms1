<?php
namespace Yeganehha\DynamicForms\app\Http\Traits;

use Illuminate\Support\Facades\URL;

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
        $form = \Yeganehha\DynamicForms\Models\Forms::query()->find($form);
        if ( $form ){
            $fields =  $form->fields($showHidden)->get()->toArray();
            $fieldsId = array_column($fields, 'id');
            $values = $this->allValues()->get()->whereIn('field_id' ,  $fieldsId )->keyBy('field_id')->toArray();
            foreach ( $fields as $key => $field ){
                if ( isset($values[$field['id']]['value']) and ( $values[$field['id']]['value'] != null or $values[$field['id']]['value'] != "" ) )
                    $fields[$key]['value'] = unserialize($values[$field['id']]['value']);
                else
                    $fields[$key]['value'] =  "";
                $fields[$key]['valueFile'] = "";
                $fields[$key]['valuesDe'] = explode(',', $fields[$key]['values']);
                if ( $field['type_variable'] == 'file' and $values[$field['id']]['value'] != null ){
                    $fields[$key]['valueFile'] =  unserialize($values[$field['id']]['value']);
                    $fields[$key]['value'] =  URL::temporarySignedRoute('dynamicForms.dl',now()->addMinutes(30) , ['path' => unserialize($values[$field['id']]['value']) ]);
                }
                if ( $AllInformation ) {
                    $fieldExport[$key] = (object)$fields[$key];
                } else {
                    $fieldExport[$key] = (object)['field_id' => $field['id'] , 'label' => $field['label'] , 'value' => $fields[$key]['value'] ?? "" ,  'valueFile' => $fields[$key]['valueFile'] , "type" => $field['type_variable'], "status" => $field['status'] ];
                }
            }
            return $fieldExport;
        }
        return [];
    }
}

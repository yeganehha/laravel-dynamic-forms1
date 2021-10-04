<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;

trait FieldsValueTrait
{
    protected $FillOutedData = null ;
    protected $isFillOutForm = false ;


    private function getFillOutedForm($model){
        $fields = $this->getFields(true,$this->showHidden);
        $fieldsId = array_column($fields, 'id');
        if ( is_object($model) )
            $values = $model->allValues()->get()->whereIn('field_id' ,  $fieldsId )->keyBy('field_id')->toArray();
        foreach ( $fields as $key => $field ){
            $fields[$key]['value'] = $values[$field['id']]['value'] ?? "";
            $fields[$key]['valuesDe'] = explode(',', $fields[$key]['values'] );
            $fieldExport[$key] = (object)$fields[$key];
        }
        $this->FillOutedData  = $fieldExport;
    }


    protected function _fillOutForm($model){
        $this->isCalled();
        if ( ( is_object($model) and get_class($model) != $this->form->model ) or ( ! is_object($model) and $model != $this->form->model ) )
            throw new \ErrorException("This form just for `{$this->form->model}` Model !");

        if ( ! is_object($model) )
            $this->isFillOutForm = true ;
        else
            $this->isFillOutForm = $model->id ;
        $this->getFillOutedForm($model);
    }

}

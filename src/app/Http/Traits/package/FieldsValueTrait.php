<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yeganehha\DynamicForms\Models\Fieldsvalue;


trait FieldsValueTrait
{
    protected $FillOutedData = null ;
    protected $isFillOutForm = false ;
    protected $FillOutError = false ;


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

    private function setFillOutedForm($model,$validateData){
        $modelType = $this->_getModel();
        if (is_object($model))
            $model = $model->id;
        if (intval($model) == 0) {
            throw new \ErrorException('Model Should Be Object!');
        }
        Fieldsvalue::deleteFillOutFields(array_keys($validateData) , $model , $modelType );
        foreach ( $validateData as $field_id => $value ) {
           $data[] =[
               'field_id' => $field_id,
               'fieldable_id' => $model,
               'fieldable_type' => $modelType,
               'value' => $value,
           ];
        }
        Fieldsvalue::insert($data);
    }

    private function validateData($fieldsInsert){
        $fields = $this->getFields(true,$this->showHidden);
        $validateRules = [];
        $validateData = [];
        foreach ( $fields as $key => $field ) {
            if ( $field['status'] != "hidden" or $this->showHidden ){
                $validateRulesLocal[$field['label']] = [];
                if ( $field['validate'] != null )
                    $validateRulesLocal[$field['label']] = explode('|',$field['validate']);
                if ( $field['status'] == "required" ){
                    $validateRulesLocal[$field['label']][] = "required";
                }
                $validateData[$field['id']] = $fieldsInsert[$field['id']] ;
                $fieldsInserted[$field['label']] = $fieldsInsert[$field['id']] ;
                $validateRules[$field['label']] = implode('|',array_unique($validateRulesLocal[$field['label']]));
            }
        }
        $validator = Validator::make($fieldsInserted, $validateRules );
        if ( $validator->fails() )
            $this->FillOutError = $validator;
        return $validateData;
    }


    protected function _fillOutForm($model, $autoDetectData = true){
        $this->isCalled();
        if ( ( is_object($model) and get_class($model) != $this->form->model ) or ( ! is_object($model) and $model != $this->form->model ) )
            throw new \ErrorException("This form just for `{$this->form->model}` Model !");

        if ( ! is_object($model) )
            $this->isFillOutForm = true ;
        else
            $this->isFillOutForm = $model->id ;
        if ( $autoDetectData and Request()->has('dynamicForms')){
            $this->FillOutError = false ;
            DB::beginTransaction();
            try {
                $validateData = $this->validateData(Request()->get('dynamicForms'));
                if ( $this->FillOutError === false ){
                    $this->setFillOutedForm($model,$validateData);
                    DB::commit();
                } else {
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException('Error in inserting data! '.$e->getMessage());
            }
        }
        $this->getFillOutedForm($model);
    }

}

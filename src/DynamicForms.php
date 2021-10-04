<?php
namespace Yeganehha\DynamicForms;

use Hamcrest\Thingy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yeganehha\DynamicForms\Models\Fields;
use Yeganehha\DynamicForms\Models\Fieldsvalue;
use Yeganehha\DynamicForms\Models\Forms;

class DynamicForms
{
    private $form ;
    private $isFillOutForm = false ;
    private $showHidden = false ;
    private $FillOutedData = null ;

    /**
     * @param null $formName
     * @param null $model
     * @param false $extend_table
     * @return $this
     * @throws \ErrorException
     */
    public function form($formName = null , $model = null , $extend_table = false)
    {
        if ( $formName == null ){
            throw new \ErrorException('you should send key (or array of key-names) to form method!');
        }
        $formKey = serialize($formName);
        $modelKey = is_object($model) ? get_class($model) : $model;
        $formObject = Forms::where('name', $formKey)->first();
        if ( $formObject->exists  ) {
            if ( $modelKey != $formObject->model ){
                $formObject->model = $modelKey;
                $formObject->update();
            }
            $this->form = $formObject ;
        } else {
            if ( $model == null ){
                throw new \ErrorException('you should send model class for creat new form!');
            }
            $data = [
                'name' => $formKey,
                'model' => $modelKey,
                'external_table' => (bool)$extend_table
            ];
            $this->form = Forms::create($data);
        }
        return $this;
    }
    private function isCalled(){
        if ( $this->form == null ){
            throw new \ErrorException('First call form([name],[model])');
        }
    }

    /**
     * @return bool
     * @throws \ErrorException
     */
    public function getTable()
    {
        $this->isCalled();
        return (bool)$this->form->external_table;
    }

    /**
     * @param $isExternal
     * @return $this
     * @throws \ErrorException
     */
    public function setTable($isExternal)
    {
        $this->isCalled();
        $this->form->external_table = (bool)$isExternal;
        $this->form->update();
        return $this;
    }

    /**
     * @return $this
     * @throws \ErrorException
     */
    public function setExternalTable()
    {
        $this->isCalled();
        $this->form->external_table = true;
        $this->form->update();
        return $this;
    }

    /**
     * @return $this
     * @throws \ErrorException
     */
    public function setLocalTable(){
        $this->isCalled();
        $this->form->external_table = false;
        $this->form->update();
        return $this;
    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    public function getFields($isArray = false , $showHidden = false){
        $this->isCalled();
        return $isArray ? $this->form->fields($showHidden)->get()->toArray() : $this->form->fields($showHidden)->get();
    }



    private function syncFields($field){
        $validatedData = Validator::make($field ,[
            'label' => 'required',
        ]);
        if ( $validatedData->fails()) {
            throw new \ErrorException($validatedData->getMessageBag());
        }
        if ( isset($field['id']) ){
            $fieldFind = Fields::where('id', $field['id'])->first();
            if ( $fieldFind->forms_id == $this->form->id ){
                $fieldFind->update($field);
                $id = $fieldFind->id;
            } elseif ( $fieldFind->id != null ) {
                throw new \ErrorException("Filed with id {$$fieldFind->id} is duplicated!");
            } else {
                $newField = $this->form->fields()->create($field);
                $id = $newField->id;
            }
        } else {
            $newField = $this->form->fields()->create($field);
            $id = $newField->id;
        }
        return $id;
    }

    /**
     * @param array|null $fields
     * @throws \ErrorException
     */
    public function setFields($fields = null ){
        $this->isCalled();
        $insertedId = [];
        if ( isset($fields[0]['label']) ){
            DB::beginTransaction();
            $lastID = 0 ;
            try {
                foreach ($fields as $id => $field) {
                    $lastID = $id;
                    $insertedId[] = $this->syncFields($field);
                }
                Fields::deleteFieldsOfForm($this->form->id , $insertedId);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException('Error in field number '.$lastID.' attributes! '.$e->getMessage());
            }
        } else {
            DB::beginTransaction();
            try {
                $insertedId[] =  $this->syncFields($fields);
                Fields::deleteFieldsOfForm($this->form->id , $insertedId);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException('Error in field attributes! '.$e->getMessage());
            }
        }
        return $this;
    }
    public function addFields($fields = null ){
        $this->isCalled();
        if ( isset($fields[0]['label']) ){
            DB::beginTransaction();
            $lastID = 0 ;
            try {
                foreach ($fields as $id => $field) {
                    $lastID = $id;
                    $this->syncFields($field);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException('Error in field number '.$lastID.' attributes! '.$e->getMessage());
            }
        } else {
            DB::beginTransaction();
            try {
                $this->syncFields($fields);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException('Error in field attributes! '.$e->getMessage());
            }
        }
        return $this;
    }

    public function updateFields($fieldId , $field = null ){
        $this->isCalled();
        if ( is_array($fieldId) ){
            if ( isset($fieldId['id']) ){
                $validatedData = Validator::make($fieldId ,[
                    'label' => 'required',
                ]);
                if ( $validatedData->fails()) {
                    throw new \ErrorException($validatedData->getMessageBag());
                }
                Fields::where('id', $fieldId['id'])->where('forms_id' ,$this->form->id )->first()->update($fieldId);
            } else {
                throw new \ErrorException('Please enter field id!');
            }
        } else {
            $validatedData = Validator::make($field ,[
                'label' => 'required',
            ]);
            if ( $validatedData->fails()) {
                throw new \ErrorException($validatedData->getMessageBag());
            }
            Fields::where('id', $fieldId)->where('forms_id' ,$this->form->id )->first()->update($field);
        }
        return $this;
    }
    public function deleteFields($fieldId){
        $this->isCalled();
        if ( is_array($fieldId) ){
            if ( isset($fieldId['id']) ){
                Fields::where('id', $fieldId['id'])->where('forms_id' ,$this->form->id )->first()->delete();
            } else {
                throw new \ErrorException('Please enter field id!');
            }
        } else {
            Fields::where('id', $fieldId)->where('forms_id' ,$this->form->id )->first()->delete();
        }
        return $this;
    }

    public function getModel($returnClass = false){
        $this->isCalled();
        $className = $this->form->model;
        return $returnClass ? new $className() : $className ;
    }

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

    public function fillOutForm($model){
        $this->isCalled();
        if ( ( is_object($model) and get_class($model) != $this->form->model ) or ( ! is_object($model) and $model != $this->form->model ) )
            throw new \ErrorException("This form just for `{$this->form->model}` Model !");

        if ( ! is_object($model) )
            $this->isFillOutForm = true ;
        else
            $this->isFillOutForm = $model->id ;
        $this->getFillOutedForm($model);
        return $this;
    }
    public function showHidden($show = true){
        $this->isCalled();
        $this->showHidden = $show;
        return $this;
    }

    public function editForm(){
        $this->isCalled();
        $this->isFillOutForm = false ;
        $this->showHidden = false ;
        $this->FillOutedData = null;
        return $this;
    }

    public function view(){
        $this->isCalled();
        $dynamicFormsType = isset(view()->getShared()['dynamicFormsType']) ? view()->getShared()['dynamicFormsType'] : [];
        $moreField = isset(view()->getShared()['moreField']) ? view()->getShared()['moreField'] : [];
        if ( $this->isFillOutForm != false ) {
            $moreField[$this->form->id] = $this->FillOutedData;
            $dynamicFormsType[$this->form->id] = 'fillOut';
        } else{
            $moreField[$this->form->id] = $this->getFields(false,true);
            $dynamicFormsType[$this->form->id] = 'editForm';
        }
        view()->share('moreField', $moreField);
        view()->share('dynamicFormsType', $dynamicFormsType);
        view()->share('DynamicFormsId', $this->form->id);
        return $this;
    }

    public function getId($ViewVariable = false)
    {
        $this->isCalled();
        if ($ViewVariable !== false) {
            $ViewVariable = ( $ViewVariable === true ) ? 'DynamicFormsId' : $ViewVariable;
            view()->share($ViewVariable, $this->form->id);
            return $this;
        } else {
            return $this->form->id;
        }
    }
}

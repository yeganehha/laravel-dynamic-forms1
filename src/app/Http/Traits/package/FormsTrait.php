<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Yeganehha\DynamicForms\app\Events\typefieldsForDynamicFormsEvent;
use Yeganehha\DynamicForms\Models\Forms;

trait FormsTrait
{
    protected $form ;
    protected $formExist = false ;

    private function creatExternalTable(){
        $modelNameSpace =explode('\\' ,$this->form->model );
        $modelName = lcfirst(end($modelNameSpace));
        $tempModelNameSpace = $this->form->model;
        $modelObject = new $tempModelNameSpace();
        $modelTable = $modelObject->getTable();
        $DynamicFormModelName = 'dynamicForm'.$this->form->id ;
        $tableName = 'dynamicForm'.'___'.$modelName .'_'. $this->form->id;
//        if ( strcasecmp($modelName , $DynamicFormModelName) < 0 ){
//            $tableName = $modelName .'_'. $DynamicFormModelName;
//        }
        Schema::create($tableName, function($table) use ($modelTable) {
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->on($modelTable)->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->primary('model_id');
        });
       $this->creatModelFileContent($tableName);
    }
    private function dropExternalTable(){
        $modelNameSpace =explode('\\' ,$this->form->model );
        $modelName = lcfirst(end($modelNameSpace));
        $DynamicFormModelName = 'dynamicForm'.$this->form->id ;
        $tableName = 'dynamicForm'.'___'.$modelName .'_'. $this->form->id;
//        if ( strcasecmp($modelName , $DynamicFormModelName) < 0 ){
//            $tableName = $modelName .'_'. $DynamicFormModelName;
//        }
        Schema::dropIfExists($tableName);
        $this->removeModelFileContent();
    }
    protected function _form($formName = null , $model = null , $extend_table = false)
    {
        if ( $formName == null ){
            throw new \ErrorException(trans('dynamicForm::form.sendKeyToCreate' ));
        }
        $formKey = serialize($formName);
        $modelKey = is_object($model) ? get_class($model) : $model;
        $formObject = Forms::where('name', $formKey)->first();
        if ( $formObject != null ) {
            if ( $modelKey != $formObject->model ){
                $formObject->model = $modelKey;
                $formObject->update();
            }
            $this->formExist = true;
            $this->form = $formObject ;
        } else {
            if ( $model == null ){
                throw new \ErrorException(trans('dynamicForm::form.sendModelToCreate' ) );
            }
            $data = [
                'name' => $formKey,
                'model' => $modelKey,
                'external_table' => (bool)$extend_table
            ];
            $this->form = Forms::create($data);
            if ( (bool)$this->form->external_table ){
                $this->creatExternalTable();
            }
        }
        event(new typefieldsForDynamicFormsEvent($this->form));
        $this->fieldsType = typefieldsForDynamicFormsEvent::getFields();
        typefieldsForDynamicFormsEvent::clearFields();
    }

    protected function _exist($formName)
    {
        if ( $formName == null ){
            throw new \ErrorException(trans('dynamicForm::form.sendKeyToCreate' ));
        }
        $formKey = serialize($formName);
        $formObject = Forms::where('name', $formKey)->first();
        if ( $formObject != null ){
            $this->formExist = true;
            $this->form = $formObject ;
            return true;
        }
        return false;
    }

    protected function _findById($formId)
    {
        $formObject = Forms::where('id', $formId)->first();
        if ( $formObject != null ){
            $this->formExist = true;
            $this->form = $formObject ;
            return true;
        }
        return false;
    }


    /**
     * @throws \ErrorException
     */
    protected function isCalled(){
        if ( $this->form == null ){
            throw new \ErrorException(trans('dynamicForm::form.callFormMethod' ));
        }
    }

    /**
     * @throws \ErrorException
     */
    protected function _getTable()
    {
        $this->isCalled();
        return (bool)$this->form->external_table;
    }



    /**
     * @param $isExternal
     * @return $this
     * @throws \ErrorException
     */
    protected function _setTable($isExternal)
    {
        $this->isCalled();
        $isExternal = (bool)$isExternal ;
        if ( $this->formExist and $isExternal != $this->form->external_table ) {
            throw new \ErrorException(trans('dynamicForm::form.canNotChangeStorage' ));
        } elseif ( ! $this->formExist and $isExternal != $this->form->external_table ) {
            $this->form->external_table = $isExternal;
            $this->form->update();
            if ( $this->form->external_table ){
                $this->creatExternalTable();
            } else {
                $this->dropExternalTable();
            }
        }
    }


    /**
     * @return $this
     * @throws \ErrorException
     */
    protected function _setExternalTable()
    {
        $this->isCalled();
        if ( $this->formExist and ! $this->form->external_table ) {
            throw new \ErrorException(trans('dynamicForm::form.canNotChangeStorage' ));
        } elseif ( ! $this->formExist and ! $this->form->external_table ) {
            $this->form->external_table = true;
            $this->form->update();
            $this->creatExternalTable();
        }
    }

    /**
     * @return $this
     * @throws \ErrorException
     */
    protected function _setLocalTable(){
        $this->isCalled();
        if ( $this->formExist and $this->form->external_table ) {
            throw new \ErrorException(trans('dynamicForm::form.canNotChangeStorage' ));
        } elseif ( ! $this->formExist and $this->form->external_table ) {
            $this->form->external_table = false;
            $this->form->update();
            $this->dropExternalTable();
        }
    }


    protected function _getModel($returnClass = false){
        $this->isCalled();
        $className = $this->form->model;
        return $returnClass ? new $className() : $className ;
    }


    protected function _editForm(){
        $this->isCalled();
        $this->isFillOutForm = false ;
        $this->showHidden = false ;
        $this->FillOutedData = null;
    }


    protected function _view(){
        $this->isCalled();
        $dynamicFormsType = isset(view()->getShared()['dynamicFormsType']) ? view()->getShared()['dynamicFormsType'] : [];
        $moreField = isset(view()->getShared()['moreField']) ? view()->getShared()['moreField'] : [];
        $fieldType = isset(view()->getShared()['fieldType']) ? view()->getShared()['fieldType'] : [];
        if ( $this->isFillOutForm != false ) {
            $moreField[$this->form->id] = $this->FillOutedData;
            $fieldType[$this->form->id] = $this->fieldsType;
            $dynamicFormsType[$this->form->id] = 'fillOut';
        } else{
            $moreField[$this->form->id] = $this->getFields(false,true);
            $fieldType[$this->form->id] = $this->fieldsType;
            $dynamicFormsType[$this->form->id] = 'editForm';
        }
        view()->share('DynamicFormsField', $moreField);
        view()->share('DynamicFormsFieldType', $fieldType);
        view()->share('dynamicFormsType', $dynamicFormsType);
        view()->share('DynamicFormsId', $this->form->id);
        return $this;
    }

    protected function _render(){
        $this->isCalled();
        $moreField = $this->FillOutedData;
        $fieldType = $this->fieldsType;
        $html = "";
        $DFId = $this->form->id ;
        if ( is_array($moreField) ){
            foreach($moreField as $field){
                if ( $field->css_class != null and view()->exists($field->css_class ) ){
                    $html .= view($field->css_class , compact('field' , 'fieldType' , 'DFId' ))->render();
                } else {
                    $html .= view('DynamicForms::component.fillOut-bootstrap' , compact('field' , 'fieldType' , 'DFId' ))->render();
                }
            }
        }
        return $html;
    }

    protected function _renderEditor(){
        $this->isCalled();
        $DynamicFormsField[$this->form->id] = $this->getFields(false,true);
        $DynamicFormsFieldType[$this->form->id] = $this->fieldsType;
        $DynamicFormsId = $this->form->id;
        $html = view('DynamicForms::editForm' , compact('DynamicFormsId' , 'DynamicFormsFieldType' , 'DynamicFormsField' ))->render();
        return $html;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->render();
    }

    /**
     * @return string
     */
    public function __toInt() {
        return $this->render();
    }

    public function __invoke($name , $model = null)
    {
        $result = $this->findById($name);
        if ( $result == false ){
            $result = $this->exist($name);
        }
        if ( $result == false ){
            $result = $this->form($name , $model);
        }
        return $result;
    }

    protected function _getId($ViewVariable = false){
        $this->isCalled();
        if ($ViewVariable !== false) {
            $ViewVariable = ( $ViewVariable === true ) ? 'DynamicFormsId' : $ViewVariable;
            view()->share($ViewVariable, $this->form->id);
            return null;
        } else {
            return $this->form->id;
        }
    }

    protected function _deleteForm(){
        $this->isCalled();
        DB::beginTransaction();
        try {
            if ($this->form->delete()) {
                if ( $this->form->external_table ){
                    $this->dropExternalTable();
                }
                $directory = 'DynamicForms/' . $this->form->id . '-' . implode('/', (array)unserialize($this->form->name));
                if ( ! Storage::exists($directory) or Storage::deleteDirectory($directory)) {
                    DB::commit();
                    $dynamicFormsType = isset(view()->getShared()['dynamicFormsType']) ? view()->getShared()['dynamicFormsType'] : [];
                    $moreField = isset(view()->getShared()['moreField']) ? view()->getShared()['moreField'] : [];
                    $fieldType = isset(view()->getShared()['fieldType']) ? view()->getShared()['fieldType'] : [];
                    unset($moreField[$this->form->id]);
                    unset($fieldType[$this->form->id]);
                    unset($dynamicFormsType[$this->form->id]);
                    view()->share('DynamicFormsField', $moreField);
                    view()->share('DynamicFormsFieldType', $fieldType);
                    view()->share('dynamicFormsType', $dynamicFormsType);
                    $this->form = null;
                    return true;
                }
            }
            DB::rollback();
            return false;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \ErrorException(trans('dynamicForm::form.errorInDeletingForm' , ['errorMessage' => $e->getMessage()]));
        }
    }
}

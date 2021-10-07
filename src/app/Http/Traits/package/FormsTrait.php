<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yeganehha\DynamicForms\app\Events\typefieldsForDynamicFormsEvent;
use Yeganehha\DynamicForms\Models\Forms;

trait FormsTrait
{
    protected $form ;
    protected $formExist = false ;

    protected function _form($formName = null , $model = null , $extend_table = false)
    {
        if ( $formName == null ){
            throw new \ErrorException('you should send key (or array of key-names) to form method!');
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
                throw new \ErrorException('you should send model class for creat new form!');
            }
            $data = [
                'name' => $formKey,
                'model' => $modelKey,
                'external_table' => (bool)$extend_table
            ];
            $this->form = Forms::create($data);
        }
        event(new typefieldsForDynamicFormsEvent($this->form));
        $this->fieldsType = typefieldsForDynamicFormsEvent::getFields();
        typefieldsForDynamicFormsEvent::clearFields();
    }


    /**
     * @throws \ErrorException
     */
    protected function isCalled(){
        if ( $this->form == null ){
            throw new \ErrorException('First call form([name],[model])');
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
            throw new \ErrorException('You can not change the storage form of the created form!');
        } elseif ( ! $this->formExist and $isExternal != $this->form->external_table ) {
            $this->form->external_table = $isExternal;
            $this->form->update();
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
            throw new \ErrorException('You can not change the storage form of the created form!');
        } elseif ( ! $this->formExist and ! $this->form->external_table ) {
            $this->form->external_table = true;
            $this->form->update();
        }
    }

    /**
     * @return $this
     * @throws \ErrorException
     */
    protected function _setLocalTable(){
        $this->isCalled();
        if ( $this->formExist and $this->form->external_table ) {
            throw new \ErrorException('You can not change the storage form of the created form!');
        } elseif ( ! $this->formExist and $this->form->external_table ) {
            $this->form->external_table = false;
            $this->form->update();
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
            throw new \ErrorException('Error in Deleting form! '.$e->getMessage());
        }
    }
}

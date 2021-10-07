<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;

use Yeganehha\DynamicForms\app\Events\typefieldsForDynamicFormsEvent;
use Yeganehha\DynamicForms\DynamicForms;
use Yeganehha\DynamicForms\Models\Forms;

trait FormsTrait
{
    protected $form ;

    protected function _form($formName = null , $model = null , $extend_table = false)
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
        $removedFieldsType = [];
        $tempFieldsType = [];
        $arraySpliceKeys = 0;
        $results =  event(new typefieldsForDynamicFormsEvent($this->form));
        foreach ($results as $key => $result ){
            if ( $result != null ) {
                if (isset($result['remove'])) {
                    if (isset($result['remove'][0]) and is_array($result['remove'])) {
                        foreach ($result['remove'] as $name) {
                            $removedFieldsType[] = $name;
                        }
                        unset($result['remove']);
                    } else {
                        $removedFieldsType[] = $result['remove'];
                        unset($result['remove']);
                    }
                }
                if (isset($result[0]) and is_array($result[0])) {
                    array_splice($results, $key - $arraySpliceKeys, 1);
                    $arraySpliceKeys++;
                    foreach ($result as $resultPack) {
                        if (isset($resultPack['name'])) {
                            if (!isset($tempFieldsType[$resultPack['name']])) {
                                $results[] = $resultPack;
                                $tempFieldsType[$resultPack['name']] = true;
                            }
                        } else
                            throw new \ErrorException('Field type you insert from listener(`typefieldsForDynamicFormsEvent`) should have `name` value');
                    }
                } elseif (!isset($result['name']))
                    throw new \ErrorException('Field type you insert from listener(`typefieldsForDynamicFormsEvent`) should have `name` value');
                elseif (isset($tempFieldsType[$result['name']])) {
                    array_splice($results, $key - $arraySpliceKeys, 1);
                    $arraySpliceKeys++;
                } else {
                    $tempFieldsType[$result['name']] = true;
                }
            }
        }
        unset($tempFieldsType);
        $removedFieldsType = array_unique($removedFieldsType);
        foreach ($removedFieldsType as $deleteTypeName ) {
            if(( $FieldTypeId = array_search($deleteTypeName, array_column($results, 'name')) ) !== false ){
                array_splice($results, $FieldTypeId , 1);
            }
        }
        $this->fieldsType = $results;
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
        $this->form->external_table = (bool)$isExternal;
        $this->form->update();
    }


    /**
     * @return $this
     * @throws \ErrorException
     */
    protected function _setExternalTable()
    {
        $this->isCalled();
        $this->form->external_table = true;
        $this->form->update();
    }

    /**
     * @return $this
     * @throws \ErrorException
     */
    protected function _setLocalTable(){
        $this->isCalled();
        $this->form->external_table = false;
        $this->form->update();
        return $this;
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
}

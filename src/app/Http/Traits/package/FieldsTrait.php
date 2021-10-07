<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yeganehha\DynamicForms\Models\Fields;

trait FieldsTrait
{
    protected $showHidden = false ;
    protected $fieldsType = [] ;

    /**
     * @throws \ErrorException
     */
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
                throw new \ErrorException("Filed with id {$fieldFind->id} is duplicated!");
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
     * @return mixed
     * @throws \ErrorException
     */
    protected function _getFields($isArray = false , $showHidden = false){
        $this->isCalled();
        return $isArray ? $this->form->fields($showHidden)->get()->toArray() : $this->form->fields($showHidden)->get();
    }

    /**
     * @throws \ErrorException
     */
    protected function _setFields($fields = null ){
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
    }



    protected function _addFields($fields = null ){
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
    }


    protected function _updateFields($fieldId , $field = null ){
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
    }



    protected function _deleteFields($fieldId){
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
    }


    protected function _showHidden($show = true){
        $this->isCalled();
        $this->showHidden = $show;
    }

}

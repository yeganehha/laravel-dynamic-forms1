<?php

namespace Yeganehha\DynamicForms\app\Http\Traits\package;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
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
        if ( $field != null ) {
            $validatedData = Validator::make($field, [
                'label' => 'required',
            ]);
            if ($validatedData->fails()) {
                throw new \ErrorException($validatedData->getMessageBag());
            }
            if (isset($field['id'])) {
                $fieldFind = Fields::where('id', $field['id'])->first();
                if ($fieldFind->forms_id == $this->form->id) {
                    $fieldFind->update($field);
                    $id = $fieldFind->id;
                } elseif ($fieldFind->id != null) {
                    throw new \ErrorException(trans('dynamicForm::form.fieldDuplicated',['fieldFindId' =>$fieldFind->id]));
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
        return  0 ;
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
        if ( isset($fields['moreField']))
            $fields = $fields['moreField'];
        if ( isset($fields[$this->form->id][0]['label'] ))
            $fields = $fields[$this->form->id];
        if ( isset($fields[$this->form->id]['label'] ))
            $fields = $fields[$this->form->id];
        $this->isCalled();
        $insertedId = [];
        $lastExistId = [];
        if ( isset($fields[0]['label']) ){
            DB::beginTransaction();
            $lastID = 0 ;
            try {
                if ( $this->form->external_table ) {
                    $lastFields = $this->getFields(true, true);
                    if (is_array($lastFields))
                        $lastExistId = array_column($lastFields, 'id');
                }
                foreach ($fields as $id => $field) {
                    $lastID = $id;
                    $insertedId[] = $this->syncFields($field);
                }
                Fields::deleteFieldsOfForm($this->form->id , $insertedId);
                if ( $this->form->external_table ) {
                    $deletedFieldsId = array_diff($lastExistId, $insertedId);
                    $newFieldsId = array_diff($insertedId, $lastExistId);
                    $this->syncExternalTableAndModel($newFieldsId,$deletedFieldsId);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->withError(trans('dynamicForm::form.errorInSetFields',['lastID' =>$lastID , 'errorMessage' => $e->getMessage()]) )->withInput();
                //throw new \ErrorException(trans('dynamicForm::form.errorInSetFields',['lastID' =>$lastID , 'errorMessage' => $e->getMessage()]));
            }
        } else {
            DB::beginTransaction();
            try {
                if ( $this->form->external_table ) {
                    $lastFields = $this->getFields(true, true);
                    if (is_array($lastFields))
                        $lastExistId = array_column($lastFields, 'id');
                }
                $insertedId[] =  $this->syncFields($fields);
                Fields::deleteFieldsOfForm($this->form->id , $insertedId);
                if ( $this->form->external_table ) {
                    $deletedFieldsId = array_diff($lastExistId, $insertedId);
                    $newFieldsId = array_diff($insertedId, $lastExistId);
                    $this->syncExternalTableAndModel($newFieldsId,$deletedFieldsId);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->withError(trans('dynamicForm::form.errorInSetFields',['errorMessage' => $e->getMessage()]))->withInput();
                //throw new \ErrorException(trans('dynamicForm::form.errorInSetFields',['errorMessage' => $e->getMessage()]));
            }
        }
    }



    protected function _addFields($fields = null ){
        if ( isset($fields['moreField']))
            $fields = $fields['moreField'];
        if ( isset($fields[$this->form->id][0]['label'] ))
            $fields = $fields[$this->form->id];
        if ( isset($fields[$this->form->id]['label'] ))
            $fields = $fields[$this->form->id];
        $this->isCalled();
        $insertedId = [];
        if ( isset($fields[0]['label']) ){
            DB::beginTransaction();
            $lastID = 0 ;
            try {
                if ( $this->form->external_table ) {
                    $lastFields = $this->getFields(true, true);
                    if (is_array($lastFields))
                        $lastExistId = array_column($lastFields, 'id');
                }
                foreach ($fields as $id => $field) {
                    $lastID = $id;
                    $insertedId[] = $this->syncFields($field);
                }
                if ( $this->form->external_table ) {
                    $newFieldsId = array_diff($insertedId, $lastExistId);
                    $this->syncExternalTableAndModel($newFieldsId,[]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException( trans('dynamicForm::form.errorInSetFields',['lastID' =>$lastID , 'errorMessage' => $e->getMessage()]) );
            }
        } else {
            DB::beginTransaction();
            try {
                if ( $this->form->external_table ) {
                    $lastFields = $this->getFields(true, true);
                    if (is_array($lastFields))
                        $lastExistId = array_column($lastFields, 'id');
                }
                $insertedId[] = $this->syncFields($fields);
                if ( $this->form->external_table ) {
                    $newFieldsId = array_diff($insertedId, $lastExistId);
                    $this->syncExternalTableAndModel($newFieldsId,[]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw new \ErrorException(trans('dynamicForm::form.errorInSetFields',['errorMessage' => $e->getMessage()]));
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
                throw new \ErrorException( trans('dynamicForm::form.enterFieldId') );
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
                $this->syncExternalTableAndModel([],[$fieldId['id']]);
            } else {
                throw new \ErrorException(trans('dynamicForm::form.enterFieldId'));
            }
        } else {
            Fields::where('id', $fieldId)->where('forms_id' ,$this->form->id )->first()->delete();
            $this->syncExternalTableAndModel([],[$fieldId]);
        }
    }


    protected function _showHidden($show = true){
        $this->isCalled();
        $this->showHidden = $show;
    }

    protected function _addFieldType($name , $label = null , $view = null ){
        $this->isCalled();
        if(array_search($name, array_column($this->fieldsType, 'name')) === false ){
            $this->fieldsType[] = [
                'name' => $name,
                'label' => $label,
                'view' => $view,
            ];
        }
    }

    protected function _removeFieldType(){
        if (func_num_args() > 0 ) {
            foreach (func_get_args()[0] as $deleteTypeName) {
                if (($FieldTypeId = array_search($deleteTypeName, array_column($this->fieldsType, 'name'))) !== false) {
                    array_splice($this->fieldsType, $FieldTypeId, 1);
                }
            }
        }
    }

    protected function creatModelFileContent($tableName ){
        $DynamicFormModelName = 'dynamicForm'.$this->form->id ;
        $path = __DIR__.'/../../../../Models/DynamicFormsModel/'.ucfirst($DynamicFormModelName).'.php';
        $directory = __DIR__.'/../../../../Models/DynamicFormsModel';
        $fieldsContent = "";
        $fields = $this->getFields(true, true);
        if (is_array($fields)) {
            $fields = array_column($fields, 'id');
            foreach ($fields as $field)
                $fieldsContent = $fieldsContent . " , 'f_" . $field . "'";
        }
        $contents = "<?php\r\n".
                    "namespace Yeganehha\DynamicForms\Models\DynamicFormsModel;\r\n\r\n".
                    "use Illuminate\Database\Eloquent\Model;\r\n\r\n".
                    "class ".ucfirst($DynamicFormModelName)." extends Model{\r\n".
                    "    protected \$table = '".$tableName."';\r\n".
                    "    protected \$primaryKey = 'model_id';\r\n".
                    "    protected \$fillable = [ 'model_id' ".$fieldsContent."];\r\n".
                    "}";
        File::ensureDirectoryExists($directory);
        File::put($path,$contents);
    }
    protected function removeModelFileContent(){
        $DynamicFormModelName = 'dynamicForm'.$this->form->id ;
        $path = __DIR__.'/../../../../Models/DynamicFormsModel/'.ucfirst($DynamicFormModelName).'.php';
        File::delete($path);
    }

    protected function syncExternalTableAndModel($newFields , $deletedFields){
        $modelNameSpace =explode('\\' ,$this->form->model );
        $modelName = lcfirst(end($modelNameSpace));
        $DynamicFormModelName = 'dynamicForm'.$this->form->id ;
        $tableName = 'dynamicForm'.'___'.$modelName .'_'. $this->form->id;
//        if ( strcasecmp($modelName , $DynamicFormModelName) < 0 ){
//            $tableName = $modelName .'_'. $DynamicFormModelName;
//        }

        Schema::table($tableName, function($table) use ($deletedFields, $newFields) {
            if ( is_array($newFields) )
                foreach ($newFields as $newField)
                    if ( $newField > 0 )
                        $table->text('f_'.$newField)->nullable();
            if ( is_array($deletedFields) )
                foreach ($deletedFields as $deletedField)
                    if ( $deletedField > 0 )
                     $table->dropColumn('f_'.$deletedField);
        });
        $this->removeModelFileContent();
        $this->creatModelFileContent($tableName);
    }
}

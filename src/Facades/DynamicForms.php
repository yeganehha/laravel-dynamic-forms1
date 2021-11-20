<?php
namespace Yeganehha\DynamicForms\Facades;

use Illuminate\Support\Facades\Facade;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method static DynamicForms form(Mixed $formName ,Mixed $model,Boolean $extend_table = false) Make new or import form.
 * @method static DynamicForms|false exist(Mixed $formName) check form exist.
 * @method static boolean getTable() this form use external table or not.
 * @method static DynamicForms setTable(Boolean $isExternal) set form use external table or not.
 * @method static DynamicForms setExternalTable() set form use external table.
 * @method static DynamicForms setLocalTable() set form use one table.
 * @method static Mixed getFields(Boolean $isArray = false ,Boolean $showHidden = false) return fields of table.
 * @method static DynamicForms setFields(array $fields = null) set fields of form.
 * @method static DynamicForms addFields(array $field = null) add new field of form.
 * @method static DynamicForms updateFields(Integer $fieldId , array $field = null) update field of form.
 * @method static DynamicForms deleteFields(Integer $fieldId ) delete field of form.
 * @method static Mixed getModel(Boolean $returnClass = false ) get model of form.
 * @method static DynamicForms setFillOutData(array $data ) fill outed data of form.
 * @method static DynamicForms fillOutForm(Mixed $model,Boolean $autoDetectData = true) fill outed data from request of form.
 * @method static DynamicForms showHidden(Boolean $show = true) show hidden fields of form.
 * @method static DynamicForms editForm() set form for edit fill outed form.
 * @method static DynamicForms view() generate form for blade.
 * @method static int|DynamicForms getId(Boolean $ViewVariable = false) get id of form.
 * @method static Boolean getError() get form has error.
 * @method static DynamicForms addFieldType(String $name ,String $label = null ,String $view = null) creat new field type.
 * @method static DynamicForms removeFieldType(String $name , ...$name) remove new field type.
 * @method static Boolean deleteForm() delete form.
 * Class DynamicForms
 * @package Yeganehha\DynamicForms\Facades
 */
class DynamicForms extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'DynamicForms';
    }
}

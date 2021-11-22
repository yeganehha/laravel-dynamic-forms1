<?php


namespace Yeganehha\DynamicForms\app\View\Components;


use Illuminate\View\Component;
use Yeganehha\DynamicForms\Facades\DynamicForms;
use function PHPUnit\Framework\throwException;

class fillOutForm extends Component
{
    protected $showError = false ;
    protected $errors = false ;
    protected $form = null ;
    protected $model = null ;
    public function __construct($name = null , $model = null , $form_id = null , $object = null , $call_back = null , $showError = false)
    {
        $this->showError = $showError ;
        if ( $name == null and $form_id == null ){
            $this->errors = trans('dynamicForm::form.can_nor_find_form');
            return false;
        }

        try {
            if ( $form_id != null ){
                $this->form = DynamicForms::findById($form_id);
            }
            if ( $this->form == null ){
                $this->form = DynamicForms::exist($name);
            }
            if ( $this->form == null ){
                $this->form = DynamicForms::form($name , $model);
            }
            if ( $object != null ){
                $this->model = $object ;
                $this->form->fillOutForm($object);
            }
            if ( $call_back != null and gettype($call_back) == 'object'){
                $call_back($this->form);
            }
        } catch (\Exception $e){
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function render()
    {
        try {
            if ( $this->showError and $this->errors){
                throw new \ErrorException($this->errors);
            }
            return $this->form->render();
        } catch (\Exception $e){
            if ( $this->showError ){
                throw new \ErrorException($e->getMessage());
            }
        }
        return "";
    }
}

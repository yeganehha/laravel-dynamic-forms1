<?php

namespace Yeganehha\DynamicForms\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yeganehha\DynamicForms\Models\Forms;

class typefieldsForDynamicFormsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private static $form ;
    private static $fieldsType = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Forms $form)
    {
        self::$form = $form;
    }

    /**
     * @return mixed
     */
    public static function getFields()
    {
        return self::$fieldsType;
    }
    /**
     * @return mixed
     */
    public static function clearFields()
    {
        self::$fieldsType = [];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return Forms
     */
    public function getForm()
    {
        return  self::$form;
    }

    public function addField($name , $label = null , $view = null ){
        if(array_search($name, array_column(self::$fieldsType, 'name')) === false ){
            self::$fieldsType[] = [
                'name' => $name,
                'label' => $label,
                'view' => $view,
            ];
        }
    }

    public function removeField(){
        if (func_num_args() > 0 ) {
            foreach (func_get_args() as $deleteTypeName) {
                if (($FieldTypeId = array_search($deleteTypeName, array_column(self::$fieldsType, 'name'))) !== false) {
                    array_splice(self::$fieldsType, $FieldTypeId, 1);
                }
            }
        }
    }

}

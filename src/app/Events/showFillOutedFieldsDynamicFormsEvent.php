<?php

namespace Yeganehha\DynamicForms\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yeganehha\DynamicForms\Models\Forms;

class showFillOutedFieldsDynamicFormsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private static $form ;
    private static $fields ;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Forms $form ,$fields)
    {
        self::$form = $form;
        self::$fields = $fields;
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

    public function getFieldValue($field_id){
        if(( $FieldIndex = array_search($field_id, array_column($this->arrayFields(), 'id')) ) !== false ){
            return [ self::$fields[$FieldIndex]->value , $FieldIndex];
        }
        return [false , false];
    }
    private function arrayFields(){
        if ( is_array(self::$fields )) {
            foreach (self::$fields as $key => $value)
                $result[$key] = get_object_vars($value);

            return $result;
        }
        return [];
    }

    public function updateValue($index , $newValue ){
        if ( isset(self::$fields[$index])  )
            self::$fields[$index]->value = $newValue;
    }

    public function removeField($index){
        if ( isset(self::$fields[$index])  )
            array_splice(self::$fields , $index , 1 );
    }

    public static function getFields(){
        return self::$fields;
    }

    public function getForm(){
        return self::$form;
    }
}

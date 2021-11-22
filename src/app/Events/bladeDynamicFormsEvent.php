<?php

namespace Yeganehha\DynamicForms\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yeganehha\DynamicForms\Models\Forms;

class bladeDynamicFormsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private static $form ;
    private static $fieldsTemplate = [];

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
     * @return array
     */
    public static function getTemplate()
    {
        return self::$fieldsTemplate;
    }
    /**
     * @return void
     */
    public static function clearTemplates()
    {
        self::$fieldsTemplate = [];
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

    public function addTemplate($name , $label = null ){
        self::$fieldsTemplate[$name] = $label ?? $name;
    }

    public function removeTemplate(){
        if (func_num_args() > 0 ) {
            foreach (func_get_args() as $deleteTypeName) {
                unset(self::$fieldsTemplate[$deleteTypeName]);
            }
        }
    }

}

<?php

namespace Yeganehha\DynamicForms\app\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class defaultFieldsDynamicFormsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return array[]
     */
    public function handle($event)
    {
        $fields = [];
        $form = $event->form;
        $fields[] = [
            'name' => 'url',
            'label' => 'Url box' ,
        ];
        $fields[] = [
            'name' => 'password',
            'label' => 'Password box' ,
        ];
        $fields[] = [
            'name' => 'email',
            'label' => 'Email box' ,
        ];
        $fields[] = [
            'name' => 'number',
            'label' => 'Number box' ,
        ];
        $fields[] = [
            'name' => 'select',
            'label' => 'Select option' ,
        ];
        $fields[] = [
            'name' => 'radio',
            'label' => 'Select radio' ,
        ];
        $fields[] = [
            'name' => 'checkbox',
            'label' => 'Check box' ,
        ];
        $fields[] = [
            'name' => 'textarea',
            'label' => 'Text area' ,
        ];
        $fields[] = [
            'name' => 'date',
            'label' => 'Date' ,
        ];
        $fields[] = [
            'name' => 'time',
            'label' => 'Time' ,
        ];
        $fields[] = [
            'name' => 'datetime-local',
            'label' => 'Date & Time' ,
        ];
        $fields[] = [
            'name' => 'file',
            'label' => 'File' ,
        ];
        return $fields;
    }
}

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
        $event->addField('url',trans('dynamicForm::form.url' ) );
        $event->addField('password',trans('dynamicForm::form.password' ) );
        $event->addField('email',trans('dynamicForm::form.email' ) );
        $event->addField('number',trans('dynamicForm::form.number' ) );
        $event->addField('select',trans('dynamicForm::form.select' ) );
        $event->addField('radio',trans('dynamicForm::form.radio' ));
        $event->addField('checkbox',trans('dynamicForm::form.checkbox' ) );
        $event->addField('textarea',trans('dynamicForm::form.textarea' ) );
        $event->addField('date',trans('dynamicForm::form.date' ) );
        $event->addField('time',trans('dynamicForm::form.time' )  );
        $event->addField('datetime-local',trans('dynamicForm::form.datetime-local' ) );
        $event->addField('file',trans('dynamicForm::form.file' ) );
    }
}

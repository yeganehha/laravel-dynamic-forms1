<?php

namespace Yeganehha\DynamicForms\app\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Yeganehha\DynamicForms\app\Events\bladeDynamicFormsEvent;

class defaultTemplatesDynamicFormsListener
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
     * @param  bladeDynamicFormsEvent  $event
     * @return array[]
     */
    public function handle($event)
    {
        $event->addTemplate('DynamicForms::component.fillOut-bootstrap',trans('dynamicForm::form.template.bootstrap' ) );
    }
}

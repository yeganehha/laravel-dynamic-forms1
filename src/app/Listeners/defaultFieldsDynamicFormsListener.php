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
        $event->addField('url','Url box' );
        $event->addField('password','Password box' );
        $event->addField('email','Email box' );
        $event->addField('number','Number box' );
        $event->addField('select','Select option' );
        $event->addField('radio','Select radio' );
        $event->addField('checkbox','Check box' );
        $event->addField('textarea','Text area' );
        $event->addField('date','Date' );
        $event->addField('time','Time'  );
        $event->addField('datetime-local','Date & Time' );
        $event->addField('file','File' );
    }
}

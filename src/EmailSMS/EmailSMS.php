<?php namespace Larablocks\EmailSMS;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;

class EmailSMS extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        //return 'emailsms'; //This creates a singleton. The class is reused.
        return App::make('emailsms'); //This creates a new class with every instance.
    }
}
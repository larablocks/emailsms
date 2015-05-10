<?php namespace Larablocks\EmailSMS;

use Illuminate\Support\ServiceProvider;

class EmailSMSServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Only for development. Not necessary for publishing.
        require __DIR__ . '/../../../../../vendor/autoload.php';
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        // This maps the abstract interface to a concrete class
        // First param is abstract. Second param is concrete.
        $this->app->bind(
            'Larablocks\EmailSMS\EmailSMSInterface',
            'Larablocks\EmailSMS\EmailSMSHandler'
        );

        // Bind the EmailSMS Interface to the facade
        // This maps the ioc container variable to the interface.
        // The above binding then maps the variable to the concrete class
        $this->app->bind(
            'emailsms',
            'Larablocks\EmailSMS\EmailSMSInterface'
        );

	}






}

<?php namespace Proengsoft\SMS;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{

        //Publishes package config file to applications config folder
        $config     = realpath(__DIR__.'/config/config.php');
        $this->publishes([
            $config     => config_path('sms.php'),
        ]);

    }

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['sms'] = $this->app->share(function($app){

            $defaultBroker = \Config::get('sms.default');

            $config = \Config::get('sms.brokers.'.$defaultBroker);

            return new Sms($config);
        });
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Proengsoft\SMS\Sms'];
    }


}

<?php namespace Vratiu\SendyApi\Laravel;

use Illuminate\Support\ServiceProvider;
use Vratiu\SendyApi\SendyApi;

class SendyApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
        
        public function boot()
	{
            $this->package('vratiu/sendy-api', 'sendy-api', __DIR__.'/../../../');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
            $this->registerApi();
	}
        
        protected function registerApi()
        {
            $this->app->singleton('sendy.api', function ($app) {
                $api = new SendyApi($app['config']->get('sendy-api::config'));
                $api->setClient($app->make('sendy.http.client'));
                
                return $api;
            });
            
            $this->app->bind('sendy.http.client', function($app){
                return new \GuzzleHttp\Client();
            });
        }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
            return array(
                'sendy.api',
                'sendy.http.client'
            );
	}

}

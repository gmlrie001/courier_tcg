<?php

namespace Vault\CourierTcg;

use Illuminate\Support\ServiceProvider;


class CourierTcgServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   */
  public function boot()
  {
    /**
     * Optional methods to load your package assets
     */

    // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'courier_tcg');
    // $this->loadRoutesFrom(__DIR__.'/routes.php');
    // $this->loadViewsFrom( __DIR__ . '/../resources/views', 'courier_tcg' );

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    $this->publishes([ __DIR__ . '/../config/courier_tcg.php' => config_path( 'courier_tcg.php' ),], 'config');

    // if ($this->app->runningInConsole()) {
      // Publishing the config.
      /*$this->publishes([
        __DIR__.'/../config/courier_tcg.php' => config_path( 'courier_tcg.php' ),
      ], 'config');*/

      // Publishing the views.
      /*$this->publishes([
        __DIR__.'/../resources/views' => resource_path( 'views/vendor/courier_tcg' ),
      ], 'views' );*/

      // Publishing assets.
      /*$this->publishes([
        __DIR__.'/../resources/assets' => public_path( 'vendor/courier_tcg' ),
      ], 'assets' );*/

      // Publishing the translation files.
      /*$this->publishes([
        __DIR__.'/../resources/lang' => resource_path( 'lang/vendor/courier_tcg' ),
      ], 'lang' );*/

      // Registering package commands.
      /*
      $this->commands([
        Console\Commands\ShipmentCourier::class
      ]);
      */
    // }
  }

  /**
   * Register the application services.
   */
  public function register()
  {
    // Automatically apply the package configuration
    $this->mergeConfigFrom( __DIR__ . '/../config/courier_tcg.php', 'courier_tcg' ) ;

    // Register the main class to use with the facade
    $this->app->bind( 'courier_tcg', function () {
      return new \Vault\CourierTcg\CourierTcg();
    });

    // return $this->app->make( 'Vault\CourierTcg\CourierTcg' );
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return ['courier_tcg'];
  }

}

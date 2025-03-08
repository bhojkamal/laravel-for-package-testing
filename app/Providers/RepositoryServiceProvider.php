<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package App\Infrastructure\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    /**
     * @var array<string, string> $bindings
     */
    $bindings = config('bindings.repositories');
    collect($bindings)->each(function (string $implementation, string $contract) {
      $this->app->bind($contract, $implementation);
    });
  }
}

<?php

namespace Vault\CourierTcg\Facades;

// Illuminate Facades
use Illuminate\Support\Facades\Facade;

class CourierTcg extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'courier_tcg';
  }

}

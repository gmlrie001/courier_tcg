<?php

namespace Vault\CourierTcg\Services\Checkout\Order;

use \Exception;


class OrderException extends Exception
{

  public static function orderIdNotSetException()
  {
    throw new \Exception( "Order-Id must be provided.", 20 );
  }


  public static function orderIdNegativeIntegerException()
  {
    throw new \Exception( "Order-Id must be a positive integer only.", 21 );
  }


  public static function orderIdZeroIntegerException()
  {
    self::orderIdNegativeIntegerException();
  }


  public static function orderNotFoundException()
  {
    throw new \Exception( "Basket not found!", 22 );
  }


  public static function orderHasNoProductsException()
  {
    throw new \Exception( "Basket is empty!", 23 );
  }


  public static function orderException( $message='', $code=24 )
  {
    throw new \Exception( $message, $code );
  }

}

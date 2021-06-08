<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Testing;

use App\Helpers\TheCourierGuyParcelPerfectAPI\GetOrder;
use App\Models\{Basket};


class ExampleOrderForTests
{

  public static function orderTest( int $oid=0 ): Basket
  {
    $orderId = ( $oid === 0 ) ? 1 : $oid;

    return ( new GetOrder( $orderId ) )->getCart();
  }

}

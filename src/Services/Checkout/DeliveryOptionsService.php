<?php

namespace Vault\CourierTcg\Services\Checkout;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\QuoteToCollection;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\SubmitCollection;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\SubmitCompoundCollection;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\RequestQuote;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\UpdateServiceQuote;

use App\Models\Basket;


class DeliveryOptionsService
{

  public static $requestedQuote;
  public static $quoteno;
  public static $service;

  public static function getOptionsAsObject( \App\Models\Basket $order )
  {
    if ( $order == NULL ) $order = ( new \App\Models\Basket )->find( Session::get( 'basket.id' ) );

    if ( ! in_array( 'delivery_tcg_place_id', $order->getFillable() ) ) return;

    return self::requestQuote( $order );
  }

  public static function requestQuote( $order )
  {
    $requestQuote = new RequestQuote( $order );

    if ( \method_exists( $requestQuote, 'requestQuote' ) ) {
      $quote = $requestQuote->requestQuote();

      self::$requestedQuote = json_decode( $quote, false );
      self::$quoteno = self::$requestedQuote->quoteno;
      self::$service = self::$requestedQuote->rates[0]->service;

      return json_encode( self::$requestedQuote, JSON_PRETTY_PRINT );
    }
  }


}
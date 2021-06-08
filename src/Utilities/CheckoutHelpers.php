<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities;

use Schema;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\SimpleClient;

use App\Models\Basket;
use App\Models\UserAddress;


class CheckoutHelpers
{
  use CourierTraits;


  /**
   * 
   */
  public static function schemaTableColumnCheck( $table, $column )
  {
    return Schema::hasColumn( $table, $column );
  }

  /**
   * 
   */
  public static function schemaBasketCheckColumnPlaceId()
  {
    return self::schemaTableColumnCheck( 'baskets', 'delivery_tcg_place_id' );
  }

  /**
   * 
   */
  public static function schemaAddressCheckColumnPlaceId()
  {
    return self::schemaTableColumnCheck( 'user_addresses', 'pp_tcg_place_id' );
  }

  /**
   * 
   */
  public static function checkAddressHasTcgPlaceId()
  {
    return self::schemaAddressCheckColumnPlaceId();
  }

  /**
   * 
   */
  public static function getDeliveryAddressTcgPlaceId( \App\Models\Basket $cart )
  {
    if ( self::schemaBasketCheckColumnPlaceId() ) {
      return $cart->delivery_tcg_place_id;
    }

    return;
  }

  /**
   * 
   */
  public static function setDeliveryAddressTcgPlaceId( \App\Models\Basket $cart, \App\Models\UserAddress $address )
  {
    if ( self::schemaBasketCheckColumnPlaceId() && self::checkAddressHasTcgPlaceId() ) {
      return $cart->update([
        'delivery_tcg_place_id' => $address->pp_tcg_place_id,
      ]);
    }

    return;
  }

  /**
   * 
   */
  public static function getAddressTcgPlaceId( \App\Models\UserAddress $address )
  {
    if ( self::schemaAddressCheckColumnPlaceId() ) {
      return $address->pp_tcg_place_id;
    }

    return;
  }

  /**
   * 
   */
  public static function setAddressTcgPlaceId( UserAdress $address, $ppTcgPlaceId=NULL )
  {
    if ( self::schemaAddressCheckColumnPlaceId() ) {
      $address->pp_tcg_place_id = $ppTcgPlaceId;
      return $address->save();
    }

    return;
  }

}

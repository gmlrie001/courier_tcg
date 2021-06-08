<?php

namespace Vault\ShipmentCourier\Helpers\Services;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentDestination extends ShipmentCourier
{
  /**
   * ==================================
   * TINKER Command to run for testing:
   * ==================================
   * 
   * use Vault\ShipmentCourier\Services\ShipmentDestination;
   * use \App\Models\Basket;
   * use App\Models\User;
   * 
   * $order = ( new Basket )->where('order_placed', '!=', NULL)->latest('updated_at')->first()
   *                        ->only(
   *                            array_merge( 
   *                                  Config::get( 'shipment_courier.orderDeliveryKeys' ), 
   *                                  ['id', 'user_id'] 
   *                            )
   *                        );
   * $order['user.email'] = User::find( $order['user_id'] )->value( 'email' );
   * 
   * $info = new ShipmentDestination( $order ); 
   * $info->setupDestination( $order );
   * 
   */


  public $shipmentDestinationSettings;
  public $orderDelivery;


  public function __construct( $orderDelivery = NULL )
  {
    parent::__construct();

    $this->shipmentDestinationSettings = $this->shipmentConfig['shipmentDestination'];
    $this->shipmentOrderSettings = $this->shipmentConfig['orderDeliveryKeys'];

    $this->destinationKeys = array_keys( $this->shipmentDestinationSettings );
    $this->orderDelivey = $this->destinationKeys;

    // $this->destinationVals = array_values( $this->shipmentOrderSettings );
    // $this->destinationSettings = array_combine( $this->destinationKeys, $this->destinationVals );

    dump( $this, get_defined_vars() );

    return $this;
  }

  public function setupDestination( $deliveryAddress = NULL )
  {
    if ( $deliveryAddress == NULL || ! isset( $deliveryAddress ) ) { $deliveryAddress = $this->orderDelivery; }

    // if ( isset( $this->orderDelivery ) && $this->orderDelivery instanceof \Illuminate\Support\Arr ) {
    if ( isset( $this->destinationKeys ) && isset( $deliveryAddress ) ) {
      foreach( $this->destinationKeys as $setting => $key ) {
        // if ( $key === 'destinationContactEmail' ) continue;

        $destKey = $this->shipmentDestinationSettings[$this->destinationKeys[$setting]];
        $destVal = $deliveryAddress[$destKey];
        if ( is_array( $deliveryAddress[$destKey] ) && count( $deliveryAddress[$destKey] ) > 0 ) {
          $destVal = trim( implode( ' ', $deliveryAddress[$destKey] ) );
        }
        
        dump( __LINE__, "KEY:=> " . $key . "(" . $destKey . ")" . " _ " . "VALUE:=> " . $destVal );

        $value = $destVal;
        $this->setProperty( $key, $destVal )->getProperty( $key );

        unset( $settings, $key, $value, $destVal );
      }

      $testKey   = 'destinationStreetAddress';
      $testValue = $this->getProperty( $testKey );
      dump(
        __FILE__, 
        __LINE__, 
        "\r\n" . "TEST_KEY:=> " . $testKey . " _ " . "TEST_VALUE:=> " . $testValue . "\r\n"
      );

      return $this;
    }

    return;
  }

}

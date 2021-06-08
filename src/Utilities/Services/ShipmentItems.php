<?php

namespace Vault\ShipmentCourier\Helpers\Services;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentItems extends ShipmentCourier
{

  public $orderConfig;
  public $orderItems;


  public function __construct( $orderItems = NULL )
  {
    parent::__construct();

    // $this->orderConfig = $this->shipmentConfig['orderDefaultValues'];
    $this->orderItems = $orderItems;
    $this->shipmentLineItems = [];

    return $this;
  }

  public function lineItems( $cart )
  {
    if ( ! method_exists( $cart, 'products' ) ) return;

    foreach( $cart->products as $key => $product ) {
      if ( ! method_exists( $product, 'product' ) ) {
        continue;
      }

      try {
        $item = $product->product;
        $this->setLineItem( $item, $key );
        unset( $item );

      } catch( \Exception $error ) {}

      unset( $product, $key );
    }

    return $this;
  }


  public function getLineItems()
  {
    return $this->shipmentLineItems;
  }
  public function setLineItems( $cart )
  {
    $this->lineItems( $cart );

    return $this;
  }

  public function getLineItem( $key )
  {
    return $this->shipmentLineItems[$key];
  }
  public function setLineItem( $item, $key = 0 )
  {
    // Consumer of single items from the basket->products relationship
    $reqKeys = ['price', 'pieces', 'title', 'length', 'width', 'height', 'weight'];

    foreach ($reqKeys as $reqKey) {

      if ( property_exists( $item, $reqKey ) ) {
        $this->shipmentLineItems[$key][$reqKey] = $item->{$reqKey};

      } elseif ( ! property_exists( $item, $reqKey )|| $reqKey == 'pieces' ) {
        $this->shipmentLineItems[$key][$reqKey] = 1;

      } elseif ( ! property_exists( $item, $reqKey )|| $reqKey == 'weight' ) {
        $this->shipmentLineItems[$key]['actual_mass'] = $item->{$reqKey};
      }

      unset( $reqKey );
    }

    dd( $this, get_defined_vars() );

    return $this;
  }

  public function getEmail()
  {
    return $this->getProperty( 'clientEmail' );
  }

  public function setEmail( $value )
  {
    return $this->setProperty( 'clientEmail', $value );
  }

  public function getPassword( $key = 'clientPassword' )
  {
    return $this->getProperty( $key );
  }
  
  public function setPassword( $value )
  {
    return $this->setProperty( 'clientPassword', $value );
  }

  public function getAccountNumber( $key = 'clientAccountNumber' )
  {
    return $this->getProperty( $key );
  }
  
  public function setAccountNumber( $value )
  {
    return $this->setProperty( 'clientAccountNumber', $value );
  }

  public function getAccountPin( $key = 'clientAccountPin' )
  {
    return $this->getProperty( $key );
  }
  
  public function setAccountPin( $value )
  {
    return $this->setProperty( 'clientAccountPin', $value );
  }

}

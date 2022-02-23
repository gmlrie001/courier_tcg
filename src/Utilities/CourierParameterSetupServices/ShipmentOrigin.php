<?php

namespace Vault\CourierTcg\Utilities\CourierParameterSetupServices;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentOrigin extends ShipmentCourier
{

  public $shipmentOriginSettings;


  public function __construct()
  {
    parent::__construct();

    $this->shipmentOriginSettings = $this->shipmentConfig['shipmentOrigin'];
    $this->originKeys = array_keys( $this->shipmentOriginSettings );

    return $this;
  }

  public function setupOrigin()
  {
    foreach( $this->originKeys as $setting => $key ) {
      dump( "KEY:=> " . $key . " _ " . "VALUE:=> " . $this->shipmentOriginSettings[$key] );

      $value = $this->shipmentOriginSettings[$key];
      $this->setProperty( $key, $value );

      unset( $settings, $key, $value );
    }

    // $this->setEmail($this->shipmentConfig['accountInfo']['email']);
    //     //  ->getEmail();
    // $this->setPassword($this->shipmentConfig['accountInfo']['password']);
    //     //  ->getPassword();
    // $this->setAccountNumber($this->shipmentConfig['accountInfo']['accountNumber']);
    //     //  ->getAccountNumber();
    // $this->setAccountPin($this->shipmentConfig['accountInfo']['accountPin']);
    //     //  ->getAccountPin();

    $testKey   = 'originStreetAddress';
    $testValue = $this->getProperty( $testKey );
    dump( "\r\n", "TEST_KEY:=> " . $testKey . " _ " . "TEST_VALUE:=> " . $testValue, "\r\n" );

    return $this;
  }

}

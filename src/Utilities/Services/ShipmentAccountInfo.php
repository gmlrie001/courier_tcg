<?php

namespace Vault\ShipmentCourier\Helpers\Services;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentAccountInfo extends ShipmentCourier
{

  // shipmentAccountInfo
  public $accountInfo;


  public function __construct()
  {
    parent::__construct();

    $this->accountInfo = $this->shipmentConfig['accountInfo'];
    unset( $this->shipmentConfig['accountInfo'] );

    return $this;
  }

  public function setupAccountInfo()
  {
    $this->setEmail( $this->accountInfo['email'] )
         ->setPassword( $this->accountInfo['password'] )
         ->setAccountNumber( $this->accountInfo['accountNumber'] )
         ->setAccountPin( $this->accountInfo['accountPin'] );

    return $this;
  }

  public function getEmail()
  {
    return $this->getProperty( 'clientEmail' );
  }
  public function setEmail( $value )
  {
    $this->setProperty( 'clientEmail', $value );

    return $this;
  }

  public function getPassword( $key = 'clientPassword' )
  {
    return $this->getProperty( $key );
  }
  public function setPassword( $value )
  {
    $this->setProperty( 'clientPassword', $value );

    return $this;
  }

  public function getAccountNumber( $key = 'clientAccountNumber' )
  {
    return $this->getProperty( $key );
  }
  public function setAccountNumber( $value )
  {
    $this->setProperty( 'clientAccountNumber', $value );

    return $this;
  }

  public function getAccountPin( $key = 'clientAccountPin' )
  {
    return $this->getProperty( $key );
  }
  public function setAccountPin( $value )
  {
    $this->setProperty( 'clientAccountPin', $value );

    return $this;
  }

}

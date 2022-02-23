<?php

namespace Vault\CourierTcg\Utilities\CourierParameterSetupServices;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentPickupDetails extends ShipmentCourier
{

  public $pickupDetails;


  public function __construct()
  {
    parent::__construct();

    $this->pickupDetails = $this->shipmentConfig['pickupDetails'];

    return $this;
  }

  public function setupPickupDetails()
  {
    $this->setPickupComments($this->pickupDetails['pickupComments']);
        //  ->getPickupComments();
    $this->setPickupReference1($this->pickupDetails['pickupReference1']);
        //  ->getPickupReference1();
    $this->setPickupReference2($this->pickupDetails['pickupReference2']);
        //  ->getPickupReference2();
    $this->setPickupDate($this->pickupDetails['pickupDate']);
        //  ->getPickupDate();
    $this->setPickupReadtTime($this->pickupDetails['pickupReadtTime']);
        //  ->getPickupReadtTime();
    $this->setPickupClosingTime($this->pickupDetails['pickupClosingTime']);
        //  ->getPickupClosingTime();
    $this->setPickupEntityStatus($this->pickupDetails['pickupEntityStatus']);
        //  ->getPickupEntityStatus();

    return $this;
  }

  public function getPickupComments()
  {
    return $this->getProperty( 'pickupComments' );
  }
  public function setPickupComments( $value )
  {
    return $this->setProperty( 'pickupComments', $value );
  }

  public function getPickupReference1()
  {
    return $this->getProperty( 'pickupReference1' );
  }
  public function setPickupReference1( $value )
  {
    return $this->setProperty( 'pickupReference1', $value );
  }

  public function getPickupReference2()
  {
    return $this->getProperty( 'pickupReference2' );
  }
  public function setPickupReference2( $value )
  {
    return $this->setProperty( 'pickupReference2', $value );
  }

  public function getPickupDate()
  {
    return $this->getProperty( 'pickupDate' );
  }
  public function setPickupDate( $value )
  {
    return $this->setProperty( 'pickupDate', $value );
  }

}

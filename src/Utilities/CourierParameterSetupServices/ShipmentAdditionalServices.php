<?php

namespace Vault\CourierTcg\Utilities\CourierParameterSetupServices;

use Vault\ShipmentCourier\ShipmentCourier;

// /* Facade Includes */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;


class ShipmentAdditionalServices extends ShipmentCourier
{

  // shipmentAccountInfo
  public $additionalServices;


  public function __construct()
  {
    parent::__construct();

    $this->additionalServices = $this->shipmentConfig['additionalServices'];

    return $this;
  }

  public function setupAdditionalServices()
  {
    $this->setRequiresInsurance($this->additionalServices['requiresInsurance']);
        //  ->getRequiresInsurance();
    $this->setInsuranceValue($this->additionalServices['insuranceValue']);
        //  ->getInsuranceValue();
    $this->setEntityIsDocument($this->additionalServices['isDocument']);
        //  ->getEntityIsDocument();

    return $this;
  }

  public function getRequiresInsurance()
  {
    return $this->getProperty( 'shipmentRequiresInsurance' );
  }
  public function setRequiresInsurance( $value = false )
  {
    return $this->setProperty( 'shipmentRequiresInsurance', $value );
  }

  public function getInsuranceValue()
  {
    return $this->getProperty( 'shipmentInsuranceValue' );
  }
  public function setInsuranceValue( $value = 0 )
  {
    return $this->setProperty( 'shipmentInsuranceValue', $value );
  }

  public function getEntityIsDocument()
  {
    return $this->getProperty( 'shipmentIsDocument' );
  }
  public function setEntityIsDocument( $value = false )
  {
    return $this->setProperty( 'shipmentIsDocument', $value );
  }

}

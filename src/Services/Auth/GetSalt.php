<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierHelpers;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
// use Vault\ShipmentCourier\Exceptions\ShipmentCourierException;

class GetSalt extends TheCourierGuyPPAPI
{
  use CourierTraits;

  public $email;
  public $password;
  public $class  = 'Auth';
  public $method = 'getSalt';
  public $salt;
  public $base;

  public $debug = false;

  public function __construct( $base = NULL )
  {
    parent::__construct();

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    $p = ( new \Vault\ShipmentCourier\Services\ShipmentAccountInfo )->setupAccountInfo();

    $this->base = ( '' != $base || NULL != $base ) ? $base : $this->testBase;
    $this->email    = $p->accountInfo['email'];
    $this->password = $p->accountInfo['password'];
    // $this->method   = 'getSalt';
    // $this->class    = 'Auth';

    if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $p, $p->accountInfo );

    return $this;
  }

  private function setupTokenParams()
  {
    $parameters = [
      'method' => $this->method, 
      'class'  => $this->class, 
      'data'   => [], 
      'email'  => $this->email,
    ];
    $parameters['url'] = $this->buildApiEndpoint( $parameters );

    return $parameters;
  }

  public function getSalt()
  {
    $params = [
      'method' => $this->method, 
      'class'  => $this->class, 
      'data'   => [
        'email'  => $this->email,
      ], 
      'email'  => $this->email, 
    ];
    $params['url'] = $this->buildApiEndpoint( $params['class'], $params['method'], ['email'=>$params['email']] );

    $response = $this->makeApiCall( $params )->handleApiResponse();
    if ( NULL == $response ) throw new \Exception( 'No response from the remote server.' );

    $keys = array_keys( get_object_vars( $response ) );

    if ( in_array( 'code', $keys ) && in_array( 'message', $keys ) ) {
      $error  = 'Code: ' . $response->code;
      $error .= ' - ' . $response->message;
      $error .= '. In Class: ' . __CLASS__;
  
      throw new \Exception( $error );
    }

    $this->salt = $response->salt;

    return $this->salt;
  }

}

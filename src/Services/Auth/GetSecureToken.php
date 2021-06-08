<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;

use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

use App\Helpers\SimpleClient;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\FileIo;

// use Vault\ShipmentCourier\Exceptions\ShipmentCourierException;


class GetSecureToken extends TheCourierGuyPPAPI
{
  use CourierTraits;

  public $email;
  public $password;
  public $class;
  public $method;
  public $salt;
  public $base;

  public $token_file;


  public function __construct( $base = NULL )
  {
    parent::__construct();

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    $this->base = ( '' != $base || NULL != $base ) ? $base : $this->testBase;
    $this->email    = $this->shipmentConfig['accountInfo']['email'];
    $this->password = $this->shipmentConfig['accountInfo']['password'];

    $this->salt = $this->getMD5SumOfString( $this->password . ( new GetSalt )->getSalt() );

    // $this->token_file = 

    return $this;
  }

  public function buildApiEndpoint( ...$params )
  {
    $this->method     = $params[0]['method'];
    $this->class      = $params[0]['class'];
    $this->email      = $params[0]['email'] ?? $this->email;
    $this->password   = $params[0]['password'] ?? $this->password;
    /**
     * SALTED Password Generation::
     * $this->getMD5SumOfString( 
     * $this->password . ( new GetSalt )->getSalt() 
     * );
     */
    $this->saltedMD5  = $params[0]['salted'] ?? $this->salt;

    $apiEndpointArray = [
      'apiBaseUri' => rtrim( $this->base, '/' ) . '/', 
      'queryStringParams' => http_build_query([
        'params' => json_encode([
          'email' => $this->email,
          'password' => $this->saltedMD5
        ]),
        'method' => $this->method, 
        'class'  => $this->class
      ])
    ];

    // Return the API Endpoint URI
    return implode( '?', $apiEndpointArray );
  }

  private function setupTokenParams()
  {
    $parameters = [
      'method' => "getSecureToken",
      'class'  => "Auth",
      'data'   => [],
      'salted' => $this->salt, // $this->getMD5SumOfString( $this->password . ( new GetSalt )->getSalt() ),
    ];
    $parameters['url'] = $this->buildApiEndpoint( $parameters );

    return $parameters;
  }

  public function getSecureToken()
  {
    $params = $this->setupTokenParams();
    
    $response = $this->makeApiCall( $params )->handleApiResponse();
    $keys = array_keys( get_object_vars( $response ) );

    if ( in_array( 'code', $keys ) && in_array( 'message', $keys ) ) {
      $error  = 'Code: ' . $response->code;
      $error .= ' - ' . $response->message;
      $error .= '. In Class: ' . __CLASS__;

      throw new \Exception( $error );
    }

    $this->token = $response->token_id;
    file_put_contents( storage_path( 'app/public/test_token_id' ), $response->token_id );

    return [
      'token_id' => $this->token
    ];
  }

}

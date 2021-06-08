<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
use App\Models\Basket;


class UpdateServiceQuote extends TheCourierGuyPPAPI
{
  use CourierTraits;

  public $email;
  public $password;

  public $base;

  public $class;
  public $method;
  public $salt;

  public $quoteNo;


  public function __construct( $base = NULL )
  {
    parent::__construct();

    throw new \Exception( "Not yet implemented..." );

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    $this->base = ( '' != $base || NULL != $base ) ? $base : $this->testBase;
    $this->email    = $this->shipmentConfig['accountInfo']['email'];
    $this->password = $this->shipmentConfig['accountInfo']['password'];

    return $this;
  }

  public function postalCodeLookup( $postcode = "7925" )
  {
    $available_postal_codes = [];
    $postCodeLookupParams   = [];

    $params = [
      'method' => "getPlacesByPostcode",
      'class'  => "Quote",
      'data'   => [
        'postcode' => $postcode,
      ],
      'token'    => ( new GetSecureToken )->getSecureToken()['token_id'],
    ];
    $token = $params['token'];
    unset( $params['token'] );

    $params['url']  = $this->buildApiEndpoint( $params['class'], $params['method'], json_encode( $params['data'] ) );
    $params['url'] .= "&token_id=" . $token;

    if ( $this->debug ) echo( "\n--------------- Requesting PostalCode Lookup Data ---------------\n" );

    $postCodeLookupResponse = $this->makeApiCall( $params )->handleApiResponse();
    $this->postcodes = $postCodeLookupResponse;

    if ( $this->debug ) dump( __METHOD__, __LINE__, $this->postcodes );

    return json_encode( $this->postcodes );
  }
  
  public function nameLookup( $name = "" )
  {
      //originating location details
      $nameLookupParams['name'] = $name;

      $params = [
        'method' => "getPlacesByName",
        'class'  => "Quote",
        'data'   => [
          'name' => $nameLookupParams['name'],
        ],
        'token'  => ( new GetSecureToken )->getSecureToken()['token_id'],
      ];
      $this->token = $token = $params['token'];
      unset( $params['token'] );

      $params['url']  = $this->buildApiEndpoint( $params['class'], $params['method'], json_encode( $params['data'] ) );
      $params['url'] .= "&token_id=" . $token;

      if ( $this->debug ) echo( "\n--------------- Requesting PlacesByName Lookup Data ---------------\n" );

      $placesByNameLookupResponse = $this->makeApiCall( $params )->handleApiResponse();
      $this->placesByName = $placesByNameLookupResponse;

      return json_encode( $this->placesByName );
  }

  public function updateServiceQuote( $quoteNo )
  {
    throw new \Exception( "Not yet implemented..." );

    $updateServiceParams = array();
    $updateServiceParams['quoteno'] = $quoteResponse->results[0]->quoteno;
    $updateServiceParams['service'] = $quoteResponse->results[0]->rates[0]->service; //i used the first 1 returned
    $updateResponse = $this->makeCall('Quote','updateService',$updateServiceParams, $this->token);
    
    echo "<BR>\n--------<BR>\nFinal Rates:<BR>\n<BR>\n";
    print_r($updateResponse);

  }

  // public function convertQuoteToWaybill( $quoteNo )
  // {

  // }



}

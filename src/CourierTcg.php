<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI;

use Vault\ShipmentCourier\ShipmentCourier as ShipmentCourier;
// use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;

use App\Helpers\SimpleClient;


class TheCourierGuyPPAPI extends ShipmentCourier
{

  public $liveBase = ''; // 'https://nservice.aramex.co.za/Json/JsonV1';
  public $testBase = 'http://adpdemo.pperfect.com/ecomService/v10/Json';

  public $shipmentConfig;


  public function __construct( $base = NULL )
  {
    parent::__construct();

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    $this->apiBase = ( NULL != $base ) ? $base : $this->testBase;
    $this->client = ( new SimpleClient );

    return $this;
  }

  public function token_check()
  {
    $file = storage_path( '/app/public/test_token_id' );
    $time  = strtotime( 'now' );
    $dayInSecs = 60 * 60 * 24;

    if ( file_exists( $file ) ) {
      // $stats = fstat( $fhandle = fopen( $file, 'r' ) );
      $stats = stat( $file );
      $toRtn = file_get_contents( $file );

      if ( abs( $stats['mtime'] - $time ) > $dayInSecs) {
        // Call to expire current token (max: 24 hours)
        // class->method->toExpireToken()
        unlink( $file );
      }

      return $toRtn;
    }
    
    return !1;
  }

  public function getShippingCost( array $params, $altEndPoint = NULL )
  {
    $url_verbNoun = ( NULL != $altEndPoint ) ? $altEndPoint : 'GetRate';
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }
    
  public function getBestRate( array $params )
  {
    $url_verbNoun = NULL;
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }

  public function createShipment( array $params )
  {
    $url_verbNoun = NULL;
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }

  public function trackShipment( array $params )
  {
    $url_verbNoun = NULL;
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }

  public function createShipmentPickup( array $params )
  {
    $url_verbNoun = NULL;
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }

  public function trackShipmentPickup( array $params )
  {
    $url_verbNoun = NULL;
    $url = $this->apiBase . '/' . $url_verbNoun;

    $fetchMethod  = 'POST';
    $data = $params; // json_encode( $params, JSON_PRETTY_PRINT );

    return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
  }

  public function cancelShipmentPickup( array $params )
  {
    // return $this->client->fetch( $url, $data, $this->customHeaders, $fetchMethod );
    throw new \Exception( 
      __METHOD__ . ' not yet implemented. Please contact the shipping/courier company to cancel shipment and/or pickup.'
    );
  }

  public function getGUID()
  {
    if ( function_exists( 'com_create_guid' ) ) {
      return com_create_guid();

    } else {
      mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.

      $charid = strtoupper(md5(uniqid(rand(), true)));
      $hyphen = chr(45);// "-"

      $uuid   = chr(123)// "{"
                .substr($charid, 0, 8) . $hyphen
                .substr($charid, 8, 4) . $hyphen
                .substr($charid, 12, 4) . $hyphen
                .substr($charid, 16, 4) . $hyphen
                .substr($charid, 20, 12)
              .chr(125);// "}"

      return $uuid;
    }
  }

  public function countryCodes( $name )
  {
    $country_codes = [
      'South Africa'   => 'ZA',
      'Australia'      => 'AU',
      'United States'  => 'US',
      'United Kingdom' => 'UK',
      'Germany'        => 'DE',
    ];

    return $country_codes[$name];
  }

}

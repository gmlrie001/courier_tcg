<?php

namespace Vault\CourierTcg\Services\Verification;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;
use App\Helpers\TheCourierGuyParcelPerfectAPI\GetOrder;

use App\Models\Basket;


class PostalCodeLookupService extends TheCourierGuyPPAPI
{
  use CourierTraits;

  public $debug = false;
  public $email;
  public $password;

  public $base;
  public $token;
  public $order;

  protected $requested;


  public function __construct( $base = NULL )
  {
    parent::__construct();

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    // if ( Session::has( 'current_basket' ) && Session::get( 'current_basket' ) != '' )  {
    //   Session::put( 'current_basket', NULL );
    //   Session::forget( 'current_basket' );
    // }
    // $eg_oid = 265; // ( Session::has( 'basket.id' ) ) ? Session::get( 'basket.id' ) : NULL;
    // $this->order = ( new GetOrder( $eg_oid ) )->getCart();
    // Session::put( 'current_basket', $this->order );

    $this->base = ( '' != $base || NULL != $base ) ? $base : $this->testBase;
    $this->email    = $this->shipmentConfig['accountInfo']['email'];
    $this->password = $this->shipmentConfig['accountInfo']['password'];

    if ( ! $token = $this->token_check() ) {
      $token = ( new GetSecureToken )->getSecureToken()['token_id'];
    }
   
    $this->token = $token;

    return $this;
  }

  public function postalCodeLookup( $postal_code=NULL )
  {
    // TESTING:
    // request()->request->set( 'postal_code', '7925' );
    $requested = request();

    // $requested = $request || request();
    $postcode = ( $requested->get( 'postal_code' ) != '' ) ? $requested->get( 'postal_code' ) : $postal_code;

    if ( $this->debug ) echo( "\n--------------- Building PostalCode Lookup Data ---------------\n" );
    $params   = [
      'method' => "getPlacesByPostcode",
      'class'  => "Quote",
      'data'   => [
        'postcode' => $postcode,
      ],
    ];

    $response = $this->apiCaller( $params );
    $availablePlacesByPostalCode = json_decode( $response, false );

    return json_encode( $availablePlacesByPostalCode );
  }

  public function placeNameLookup()
  {
    // TESTING:
    request()->request->set( 'suburb', 'Walmer Estate' );
    $requested = request();

    // $requested = $request || request();
    $name = ( $requested->has( 'suburb' ) && $requested->get( 'suburb' ) != '' ) 
            ? $requested->get( 'suburb' ) : NULL;

    if ( $this->debug ) echo( "\n--------------- Building PlacesByName Lookup Data ---------------\n" );
    $params = [
      'method' => "getPlacesByName",
      'class'  => "Quote",
      'data'   => [
        'name' => $name,
      ],
    ];

    $response = $this->apiCaller( $params );
    $availablePostalCodesByPlacesByName = json_decode( $response, false );

    return json_encode( $availablePostalCodesByPlacesByName );
  }


  /**
   * Incoming request should contain a valid ZA postal code (regex: \d{4,5})
   * 
   * @param: request()->get( 'postal_code' )
   * 
   * @return: json list object of place objects matching postal_code input
   * 
   */
  private function apiCaller( $data=[] )
  {
    if ( ! is_array( $data ) && count( $data ) > 0 ) return;

    $token = $this->token;
    if ( NULL == $token ) throw new \Exception( 'TOKEN_ID must be set!' );

    $params = $data;
    $params['data'] = $data['data'];
    $params['url']  = $this->buildApiEndpoint( $params['class'], $params['method'], json_encode( $params['data'] ), $token );

    $callMethod = strtoupper( str_replace( '-', ' ', kebab_case( $params['method'] ) ) );
    if ( $this->debug ) echo( "\n--------------- Requesting " .$callMethod. " Lookup Data ---------------\n" );

    $lookupResponse = $this->makeApiCall( $params )->handleApiResponse();
    $this->dataLookup = $lookupResponse;

    if ( $this->debug ) dump( __METHOD__, __LINE__, $this->dataLookup, $lookupResponse );

    return json_encode( $lookupResponse );
  }

}

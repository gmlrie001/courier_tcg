<?php

namespace Vault\CourierTcg\Services\Requests;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

use App\Helpers\TheCourierGuyParcelPerfectAPI\GetOrder;
use App\Models\Basket;

use Illuminate\Support\Facades\Session;


class RequestQuote extends TheCourierGuyPPAPI
{
  use CourierTraits;

  protected $debug = false;

  public $email;
  public $password;

  public $base;

  public $class;
  public $method;
  public $token;

  public $order;


  public function __construct( \App\Models\Basket $order=NULL, $base=NULL )
  {
    parent::__construct();

    $this->customHeaders = [
      'Content-Type: application/json',
      'Accept: */*',
    ];

    if ( Session::has( 'current_basket' ) && Session::get( 'current_basket' ) != '' )  {
      Session::put( 'current_basket', NULL );
      Session::forget( 'current_basket' );
    }

    $eg_oid = $order->id; // 265; ( Session::has( 'basket.id' ) ) ? Session::get( 'basket.id' ) : NULL;
    $this->order = ( new GetOrder( $eg_oid ) )->getCart();
    Session::put( 'current_basket', $this->order );

    // dd( __METHOD__, __LINE__, $this->order );

    $this->base = ( '' != $base || NULL != $base ) ? $base : $this->testBase;
    $this->email    = $this->shipmentConfig['accountInfo']['email'];
    $this->password = $this->shipmentConfig['accountInfo']['password'];

    if ( ! $token = $this->token_check() ) {
      $token = ( new GetSecureToken )->getSecureToken()['token_id'];
    }
    $this->token = $token;

    return $this;
  }

  public function postalCodeLookup( $postcode = "8001" )
  {
    $available_postal_codes = [];
    $postCodeLookupParams   = [];

    $params = [
      'method' => "getPlacesByPostcode",
      'class'  => "Quote",
      'data'   => [
        'postcode' => $postcode,
      ],
      'token'    => $this->token,
    ];
    $token = $params['token'];
    unset( $params['token'] );

    if ( NULL == $token ) throw new \Exception( 'TOKEN_ID must be set!' );

    $params['url']  = $this->buildApiEndpoint( $params['class'], $params['method'], json_encode( $params['data'] ), $token );
    // $params['url'] .= "&token_id=" . $token;

    if ( $this->debug ) echo( "\n--------------- Requesting PostalCode Lookup Data ---------------\n" );

    $postCodeLookupResponse = $this->makeApiCall( $params )->handleApiResponse();
    $this->postcodes = $postCodeLookupResponse;

    if ( $this->debug ) dump( __METHOD__, __LINE__, $this->postcodes );
    // dd( __METHOD__, __LINE__, $this, get_defined_vars() );

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
        'token'    => $this->token,
      ];
      $token = $params['token'];

      unset( $params['token'] );

      if ( NULL == $token ) throw new \Exception( 'TOKEN_ID must be set!' );

      $params['url']  = $this->buildApiEndpoint( $params['class'], $params['method'], json_encode( $params['data'] ), $token );
      // $params['url'] .= "&token_id=" . $token;

      if ( $this->debug ) echo( "\n--------------- Requesting PlacesByName Lookup Data ---------------\n" );

      $placesByNameLookupResponse = $this->makeApiCall( $params )->handleApiResponse();
      $this->placesByName = $placesByNameLookupResponse;

      return json_encode( $this->placesByName );
  }

  public function requestQuote()
  {
    if ( NULL == $this->token ) throw new \Exception( 'TOKEN_ID must be set!' );

    // build quote request:
    $quoteParams = [];
    $quoteParams['details'] = [];
    // author added these just to make sure these tests are not processed as actual waybills
    $quoteParams['details']['specinstruction'] = $this->shipmentConfig['specialDeliveryInstructions'];
    $quoteParams['details']['reference'] = 'Online purchase on: ' . url('/'); // $this->shipmentConfig['?reference?'];
    
    // originating location
    $quoteParams['details']['origperadd1']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
    $quoteParams['details']['origperadd2']  = $this->shipmentConfig['shipmentOrigin']['originBusinessPark'];
    $quoteParams['details']['origperadd3']  = $this->shipmentConfig['shipmentOrigin']['originOtherAddress'];
    $quoteParams['details']['origperadd4']  = NULL;
    $quoteParams['details']['origperphone'] = $this->shipmentConfig['shipmentOrigin']['originContactPhone'];
    $quoteParams['details']['origpercell']  = NULL;
    
    $originPostalCode = '8001' ?? $this->shipmentConfig['shipmentOrigin']['originPostalCode'] ;
    $postCodeLookupResponse = $this->postalCodeLookup( $originPostalCode );
    if ( $this->debug ) dump( __METHOD__, __LINE__, json_decode( $postCodeLookupResponse ) );
    // dd( __METHOD__, __LINE__, json_decode( $postCodeLookupResponse ) );

    //used the 7th result from the list returned when looking up postcode = 7925 as there was only 1, but normally the user would choose
    $quoteParams['details']['origplace']      = json_decode( $postCodeLookupResponse )[11]->place;
    $quoteParams['details']['origtown']       = json_decode( $postCodeLookupResponse )[11]->town;
    $quoteParams['details']['origpers']       = $this->shipmentConfig['shipmentOrigin']['originContactPerson'];
    $quoteParams['details']['origpercontact'] = $this->shipmentConfig['shipmentOrigin']['originContactName'];
    $quoteParams['details']['origperpcode']   = $this->shipmentConfig['shipmentOrigin']['originPostalCode']; //postal code
    
    //destination location details
    $order = $this->order;
    $quoteParams['details']['destperadd1']  = $order->delivery_address_line_1; // $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
    $quoteParams['details']['destperadd2']  = $order->delivery_address_line_2; // $this->shipmentConfig['shipmentDestination']['destinationBusinessPark'];
    $quoteParams['details']['destperadd3']  = NULL; // $this->shipmentConfig['shipmentDestination']['destinationOtherAddress'];
    $quoteParams['details']['destperadd4']  = NULL;
    $quoteParams['details']['destperphone'] = $order->user->phone; // $this->shipmentConfig['shipmentDestination']['destinationContactPhone'];
    $quoteParams['details']['destpercell']  = NULL;
    
    $destinationPostalCode = $order->delivery_postal_code; // ?? 8001 ?? optional( $order )->{$this->shipmentConfig['shipmentOrigin']['originPostalCode']};
    $nameLookupResponse = $this->postalCodeLookup( $destinationPostalCode );
    if ( $this->debug ) dump( __METHOD__, __LINE__, json_decode( $nameLookupResponse ) );

    //chose the 11th result, but this will be up to the user as above
    $quoteParams['details']['destplace']      = ( NULL != $order->delivery_tcg_place_id ) ? $order->delivery_tcg_place_id : NULL; // json_decode( $nameLookupResponse )[7]->place;
    $quoteParams['details']['desttown']       = $order->delivery_suburb; // json_decode( $nameLookupResponse )[7]->town;
    $quoteParams['details']['destpers']       = $order->delivery_name; // $this->shipmentConfig['shipmentDestination']['destinationContactPerson'];
    $quoteParams['details']['destpercontact'] = implode( ' ', [$order->delivery_name, $order->delivery_surname] ); // $this->shipmentConfig['shipmentDestination']['destinationContactName'];
    $quoteParams['details']['destperpcode']   = $order->delivery_postal_code; // $this->shipmentConfig['shipmentDestination']['destinationPostalCode']; //postal code
    
    /* Add the contents:
      * There needs to be at least 1 contents item with an "actmass" > 0 otherwise a rate will not calculate.
      * "Contents" needs to be an array object, even if there is only one contents item. */

    //Create contents array object
    $quoteParams['contents'] = [];

    $lineItems = ( method_exists( $order, 'products' ) ) ? $order->products : exit();
    $itemCount = $pieces = 1;

    foreach( $order->products as $key=>$item ):
      //Create first contents item (index 0 in the contents array)
      $quoteParams['contents'][$key] = [];
      $product = $item->product; // ( NULL != $item->product ) ? $item->product : NULL;

      if ( $product->weight == NULL || ! isset( $product->weight ) ) continue;

      // $pieces = ( NULL != $product->components && sizeof( $product->components ) ) 
      //             ? count( $product->components ) : 1;
      $item->pieces = $pieces;
      
      //Add contents details
      $product_description = $product->title . ": " . $product->description;

      $quoteParams['contents'][$key]['item']    = $itemCount;
      $quoteParams['contents'][$key]['pieces']  = $item->pieces;
      $quoteParams['contents'][$key]['desc']    = $product_description;
      $quoteParams['contents'][$key]['dim1']    = $product->length;
      $quoteParams['contents'][$key]['dim2']    = $product->width;
      $quoteParams['contents'][$key]['dim3']    = $product->height;
      $quoteParams['contents'][$key]['actmass'] = $product->weight;

      // Incrementing the item counter
      $itemCount++;
    endforeach;

    if ( $this->debug ) echo "<BR>\n<BR>\n ---- request params ---- <BR>\n";
    if ( $this->debug ) print_r( $quoteParams );

    $token = $this->token;
    $params['url']  = $this->buildApiEndpoint( 'Quote', 'requestQuote', $quoteParams, $token );
    $params['url'] .= "&token_id=" . $token;
    $params['method'] = 'POST';
    $params['data'] = $quoteParams;

    if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $quoteParams, $this->token, $params );
    if ( $this->debug ) echo "<BR>\n<BR>\n ---- calling requestQuote ---- <BR>\n";

    $requestQuoteResponse = $this->makeApiCall( $params )->handleApiResponse();
    $this->requestedQuote = $requestQuoteResponse;
    if ( $this->debug ) dump( __METHOD__, __LINE__, $order, $quoteParams, $this, get_defined_vars() );

    Session::put( 'quoteNo', $requestQuoteResponse->quoteno );
    Session::put( 'serviceRates', $requestQuoteResponse->rates );
    Session::put( 'selectedServiceRate', $requestQuoteResponse->rates[0] );
    Session::put( 'selectedServiceType', $requestQuoteResponse->rates[0]->service );

    if ( $this->debug ) echo "<BR>\n<BR>\n ---- response ---- <BR>\n<BR>\n";
    if ( $this->debug ) dump( __METHOD__, __LINE__, $requestQuoteResponse, json_encode( $this->requestedQuote ) );
    
    return json_encode( $this->requestedQuote );
  }

}

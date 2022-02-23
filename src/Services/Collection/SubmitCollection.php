<?php

namespace Vault\CourierTcg\Services\Collection;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
use App\Models\Basket;


class SubmitCollection extends TheCourierGuyPPAPI
{
    use CourierTraits;

    public $email;
    public $password;

    public $base;

    public $class;
    public $method;
    public $salt;


    public function __construct($base = null)
    {
      parent::__construct();

      $this->customHeaders = [
        'Content-Type: application/json',
        'Accept: */*',
      ];

      $this->base = ('' != $base || null != $base) ? $base : $this->testBase;

      $this->email    = $this->shipmentConfig['accountInfo']['email'];
      $this->password = $this->shipmentConfig['accountInfo']['password'];
      $this->service  = $this->shipmentConfig['accountInfo']['serviceType'];
      $this->accountNumber = $this->shipmentConfig['accountInfo']['accountNumber'];
      
      if ( ! $token = $this->token_check() ) {
        $token = ( new GetSecureToken )->getSecureToken()['token_id'];
      }
      $this->token = $token;
  
      return $this;
    }

    public function postalCodeLookup( $postcode )
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
    
    public function nameLookup( $name )
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
  
    public function submitCollection()
    {
      // build quote request:
      $collectParams = [];
      $collectParams['details'] = [];

      $collectParams['details']['specinstruction'] = "";
      $collectParams['details']['reference']       = "Online purchase on: " . url( '/' );
      $collectParams['details']['service']         = $this->service;
      $collectParams['details']['accnum']          = $this->accountNumber;

      // originating location
      $collectParams['details']['origperadd1']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
      $collectParams['details']['origperadd2']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
      $collectParams['details']['origperadd3']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
      $collectParams['details']['origperadd4']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
      $collectParams['details']['origperphone'] = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
      $collectParams['details']['origpercell']  = $this->shipmentConfig['shipmentOrigin']['originStreetAddress'];
    
      $postCodeLookupResponse = $this->postalCodeLookup( $this->shipmentConfig['shipmentOrigin']['originPostalCode'] );
      if ( $this->debug ) dump( __METHOD__, __LINE__, json_decode( $postCodeLookupResponse ) );
      $collectParams['details']['origplace']      = json_decode( $postCodeLookupResponse )[7]->place; // $this->origPlace;
      $collectParams['details']['origtown']       = json_decode( $postCodeLookupResponse )[7]->town; // $this->origPlacename;
      $collectParams['details']['origpers']       = $this->shipmentConfig['shipmentOrigin']['originContactPerson'];
      $collectParams['details']['origpercontact'] = $this->shipmentConfig['shipmentOrigin']['originContactName'];
      $collectParams['details']['origperpcode']   = $this->shipmentConfig['shipmentOrigin']['originPostalCode']; //postal code
            
      //destination location details
      $collectParams['details']['destperadd1']  = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
      $collectParams['details']['destperadd2']  = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
      $collectParams['details']['destperadd3']  = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
      $collectParams['details']['destperadd4']  = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
      $collectParams['details']['destperphone'] = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
      $collectParams['details']['destpercell']  = $this->shipmentConfig['shipmentDestination']['destinationStreetAddress'];
    
      $nameLookupResponse = $this->postalCodeLookup( $this->shipmentConfig['shipmentDestination']['destinationPostalCode'] );
      if ( $this->debug ) dump( __METHOD__, __LINE__, json_decode( $nameLookupResponse ) );      
      //chose the 11th result, but this will be up to the user as above
      $collectParams['details']['destplace']      = json_decode( $nameLookupResponse )[11]->place;
      $collectParams['details']['desttown']       = json_decode( $nameLookupResponse )[11]->place;
      $collectParams['details']['destpers']       = $this->shipmentConfig['shipmentDestination']['destinationContactPerson'];
      $collectParams['details']['destpercontact'] = $this->shipmentConfig['shipmentDestination']['destinationContactName'];
      $collectParams['details']['destperpcode']   = $this->shipmentConfig['shipmentDestination']['destinationPostalCode'];

      $collectParams['details']['starttime']      = $this->shipmentConfig['shipmentPickupDetails']['pickupOpeningTime'];
      $collectParams['details']['endtime']        = $this->shipmentConfig['shipmentPickupDetails']['pickupClosingTime'];
      $collectParams['details']['notes']          = $this->shipmentConfig['shipmentPickupDetails']['pickupComments'];

      /* Add the contents:
        * There needs to be at least 1 contents item with an "actmass" > 0 otherwise a rate will not calculate.
        * "Contents" needs to be an array object, even if there is only one contents item. */
      //Create contents array object
      $collectParams['contents'] = [];

      //Create first contents item (index 0 in the contents array)
      $collectParams['contents'][0] = [];
      
      //Add contents details
      $collectParams['contents'][0]['item'] = 1;
      $collectParams['contents'][0]['desc'] = 'this is a test';
      $collectParams['contents'][0]['pieces'] = 1;
      $collectParams['contents'][0]['dim1'] = 1;
      $collectParams['contents'][0]['dim2'] = 0.5;
      $collectParams['contents'][0]['dim3'] = 1.25;
      $collectParams['contents'][0]['actmass'] = 3;
      
      //Create second contents item (index 1 in the contents array)
      $collectParams['contents'][1] = [];
      
      //Add contents details
      $collectParams['contents'][1]['item'] = 2;
      $collectParams['contents'][1]['desc'] = 'ths is another test';
      $collectParams['contents'][1]['pieces'] = 1;
      $collectParams['contents'][1]['dim1'] = 1;
      $collectParams['contents'][1]['dim2'] = 1;
      $collectParams['contents'][1]['dim3'] = 1;
      $collectParams['contents'][1]['actmass'] = 1;
      
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- request collection params ---- <BR>\n";
      if ( $this->debug ) print_r( $collectParams );

      $token = $this->token;
      $params['url']  = $this->buildApiEndpoint( 'Collection', 'submitCollection', $collectParams, $token );
      // $params['url'] .= "&token_id=" . $token;
      $params['method'] = 'POST';
      $params['data'] = $collectParams;

      if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $collectParams, $token, $params, $this->token );
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- calling submitCollection ---- <BR>\n";
      if ( $this->debug ) dump( $this->makeApiCall( $params ) );

      $submitCollection = $this->makeApiCall( $params )->handleApiResponse();
      $this->submittedCollection = $submitCollection;
      // Data from submitCollection
      //  +"success": "Data submitted"
      //  +"waybillno": "COL0007154"
      //  +"collectno": 15764
      //  +"gentracking_retval": null
      //  +"histid": null

      dump( __METHOD__, __LINE__, $params, $submitCollection );

      return json_encode( $this->submitCollection );
    }
}

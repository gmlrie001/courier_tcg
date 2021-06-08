<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Waybill;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSalt;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
use App\Models\Basket;


class GetSingleWaybill extends TheCourierGuyPPAPI
{
    use CourierTraits;

    protected $debug = !1;

    public $email;
    public $password;

    public $base;

    public $class;
    public $method;
    public $salt;

    public $waybillNo;
    public $collectNo;


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
      // $this->service  = $this->shipmentConfig['accountInfo']['serviceType'];
      // $this->accountNumber = $this->shipmentConfig['accountInfo']['accountNumber'];
      
      if ( ! $token = $this->token_check() ) {
        $token = ( new GetSecureToken )->getSecureToken()['token_id'];
      }
      $this->token = $token;

      return $this;
    }

    public function getSingleWaybill( $waybillNo = 'COL0007154', $collectNo = 15764 )
    {
      // build single waybill tracking parameters:
      // $waybillParams = [];
      $waybillParams[0]['waybillno'] = $this->waybillNo = $waybillNo;
      $waybillParams[1]['collectno'] = $this->collectNo = $collectNo;
      
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- single waybill params ---- <BR>\n";
      if ( $this->debug ) print_r( $waybillParams );

      $token = $this->token; // = ( new GetSecureToken )->getSecureToken()['token_id'];
      if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $this->token );

      $params['url']  = $this->buildApiEndpoint( 'Waybill', 'getSingleWaybill', $waybillParams, $token );
      // $params['url'] .= "&token_id=" . $token;
      $params['method'] = 'POST';
      $params['data'] = $waybillParams;
      // $params['url'] = str_replace( 'v10', 'v17', $params['url'] );
      dd( $params['url'] );

      if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $waybillParams, $this->token, $params );
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- calling getSingleWaybill ---- <BR>\n";

      $getSingleWaybill = $this->makeApiCall( $params )->handleApiResponse();
      $this->gotSingleWaybill = $getSingleWaybill;

      // Data from submitCollection
      //  +"success": "Data submitted"
      //  +"waybillno": "COL0007154"
      //  +"collectno": 15764
      //  +"gentracking_retval": null
      //  +"histid": null

      dd( __METHOD__, __LINE__, $this, get_defined_vars(), $params, $getSingleWaybill );

      return json_encode( $this->gotSingleWaybill );
    }

}

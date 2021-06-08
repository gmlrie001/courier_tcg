<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection;

use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use App\Helpers\SimpleClient;
use App\Models\Basket;


class QuoteToCollection extends TheCourierGuyPPAPI
{
    use CourierTraits;

    protected $debug = false;

    public $email;
    public $password;

    public $base;
    public $requestQuoteResponse;

    public $class;
    public $method;
    public $salt;

    protected $filenamePathDate;
    protected $filenamePathTime;
    protected $filenameExtension = 'pdf';

    public $waybillFile;
    public $labelsFile;


    public function __construct( $requestQuoteResponse = NULL )
    {
        parent::__construct();

        $this->customHeaders = [
        'Content-Type: application/json',
        'Accept: */*',
      ];

        // $this->base = ('' != $base || null != $base) ? $base : $this->testBase;
        $this->requestQuoteResponse = ('' != $requestQuoteResponse || null != $requestQuoteResponse) ? $requestQuoteResponse : NULL;

        $this->email    = $this->shipmentConfig['accountInfo']['email'];
        $this->password = $this->shipmentConfig['accountInfo']['password'];
        $this->service  = $this->shipmentConfig['accountInfo']['serviceType'];
        $this->accountNumber = $this->shipmentConfig['accountInfo']['accountNumber'];

        if ( ! $token = $this->token_check() ) {
          $token = ( new GetSecureToken )->getSecureToken()['token_id'];
        }
        $this->token = $token;
    
        $this->filenamePathDate = date( "dmY", strtotime( 'today' ) );
        
        foreach( ['waybill', 'labels'] as $key=>$which ) {
          $fullpath = storage_path( '/app/public' . DIRECTORY_SEPARATOR . $this->filenamePathDate . DIRECTORY_SEPARATOR . $which . DIRECTORY_SEPARATOR );
          if ( ! is_dir( $fullpath ) ) {
            @mkdir( $fullpath, 0775, true );
          }
        }

        $this->filenamePathTime = date( "His", strtotime( 'now' ) );
        
        return $this;
    }

    private function handleQuoteResponseData( $requestQuoteResponse, $asArray=false )
    {
      $requestQuoteResponse = ( is_object( $requestQuoteResponse ) ) ? json_encode( $requestQuoteResponse ) : $requestQuoteResponse;
      /* ========================================================================================================================================== */
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- handling the requested quote data ---- <BR>\n";
      /* ========================================================================================================================================== */

      if ( $requestQuoteResponse != NULL ) {
        $this->requestQuoteResponse = $requestQuoteResponse;
        return json_decode( $requestQuoteResponse, false );

      } else {
        if ( $this->requestQuoteResponse != NULL ) {
          return json_decode( $this->requestQuoteResponse, false );
        }
      }
    }

    // The following code handles updating the requested quote, uncomment to test
    // Update quote service
    // Calling this method will allow quote to be updated along with the service type.
    public function updateRequestQuoteService( $requestQuoteResponse=NULL )
    {
      $this->requestQuoteResponse = $this->handleQuoteResponseData( $requestQuoteResponse );
      /* ========================================================================================================================================== */
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- submit update service params ---- <BR>\n";
      /* ========================================================================================================================================== */

      $updateServiceParams = [];
      $updateServiceParams['quoteno'] = $this->requestQuoteResponse->quoteno; //->results[0] this parameter is MANDATORY
      $updateServiceParams['service'] = $this->requestQuoteResponse->rates[0]->service; // 'specins' $this->shipmentConfig['specialDeliveryInstructions']; //this parameter is OPTIONAL

      $params = $updateServiceParams;
      $params['url']  = 'http://adpdemo.pperfect.com/ecomService/v10/Json';
      $params['url'] .= $this->buildApiEndpoint( 'Quote', 'updateService', $updateServiceParams, $this->token );
      $params['method'] = 'POST';
      $params['data'] = $updateServiceParams;

      $updateServiceResponse = $this->makeApiCall( $params )->handleApiResponse();
      $this->updatedQuote = $updateServiceResponse;

      if ( $this->debug ) dump( __METHOD__, __LINE__, "UPDATE 1", $updateServiceResponse );

      return $this;
    }

    // The following code converts the quote to a waybill, uncomment to test
    // Convert quote to waybill
    // Calling this method will create a waybill with the same details as the submitted quote
    public function convertQuoteToWaybill( $requestQuoteResponse=NULL )
    {
      $this->requestQuoteResponse = $this->handleQuoteResponseData( $requestQuoteResponse );
      /* ========================================================================================================================================== */
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- convert quote to waybill params ---- <BR>\n";
      /* ========================================================================================================================================== */

      $convertQuoteToWaybillParams = [];
      $convertQuoteToWaybillParams['quoteno'] = $this->requestQuoteResponse->quoteno; //this parameter is MANDATORY
      $convertQuoteToWaybillParams['specins'] = 'special instructions'; // $this->shipmentConfig['specialDeliveryInstructions']; //this parameter is OPTIONAL
      $convertQuoteToWaybillParams['printWaybill'] = 1;
      $convertQuoteToWaybillParams['printLabels']  = 0;
      // $convertQuoteToWaybillParams['details']['service'] = "ONX";
      // $convertQuoteToWaybillParams['details']['accnum'] = "PPO";

      $params = $convertQuoteToWaybillParams;
      $params['url']  = 'http://adpdemo.pperfect.com/ecomService/v10/Json';
      $params['url'] .= $this->buildApiEndpoint( 'Quote', 'quoteToWaybill', $convertQuoteToWaybillParams, $this->token );
      $params['method'] = 'POST';
      $params['data'] = $convertQuoteToWaybillParams;

      $convertQuoteToWaybillResponse = $this->makeApiCall( $params )->handleApiResponse();
      $this->quoteToWaybill = $convertQuoteToWaybillResponse;

      if ( property_exists( $convertQuoteToWaybillResponse, 'waybillBase64' ) ) {
        $this->waybillFileName = $this->requestQuoteResponse->quoteno.'.pdf';
        $this->saveBase64ToFile( $convertQuoteToWaybillResponse->waybillBase64, $this->requestQuoteResponse->quoteno );
      }

      if ( property_exists( $convertQuoteToWaybillResponse, 'labelsBase64' ) ) {
        $this->labelsFileName = $this->requestQuoteResponse->quoteno.'_label.pdf';
        $this->saveBase64ToFile( $convertQuoteToWaybillResponse->labelsBase64, $this->requestQuoteResponse->quoteno.'_label', $this->filenameExtension );
      }

      if ( $this->debug ) dump( __METHOD__, __LINE__, get_defined_vars(), $convertQuoteToWaybillResponse );

      return $this;
    }

    // The following code converts the quote to a collection, uncomment to test
    // Convert quote to collection
    // Calling this method will create a collection with the same details as the submitted quote
    public function convertQuoteToCollection( $requestQuoteResponse=NULL )
    {
      $this->requestQuoteResponse = $this->handleQuoteResponseData( $requestQuoteResponse );
      /* ========================================================================================================================================== */
      if ( $this->debug ) echo "<BR>\n<BR>\n ---- convert quote to collection params ---- <BR>\n";
      /* ========================================================================================================================================== */

      $convertQuoteToCollectionParams = [];
      $convertQuoteToCollectionParams['quoteno'] = $this->requestQuoteResponse->quoteno; //this parameter is MANDATORY
      $convertQuoteToCollectionParams['specins'] = 'special instructions'; // $this->shipmentConfig['specialDeliveryInstructions']; // OPTIONAL parameter
      $convertQuoteToCollectionParams['printWaybill'] = 1;
      $convertQuoteToCollectionParams['printLabels']  = 1;
      $convertQuoteToCollectionParams['starttime'] = date( "H\:i", strtotime( "day after tomorrow 11am" ) );
      $convertQuoteToCollectionParams['endtime'] = date( "H\:i", strtotime( "day after tomorrow 5pm" ) );
      $convertQuoteToCollectionParams['quoteCollectionDate'] = date( "d/m/Y", strtotime( "day after tomorrow" ) );
      $convertQuoteToCollectionParams['notes'] = "some notes here";

      $params = $convertQuoteToCollectionParams;
      $params['url']  = 'http://adpdemo.pperfect.com/ecomService/v10/Json';
      $params['url'] .= $this->buildApiEndpoint( 'Collection', 'quoteToCollection', $convertQuoteToCollectionParams, $this->token );
      $params['method'] = 'POST';
      $params['data'] = $convertQuoteToCollectionParams;

      $convertQuoteToCollectionResponse = $this->makeApiCall( $params )->handleApiResponse( !0 );
      $this->quoteToCollection = $convertQuoteToCollectionResponse;

      if ( property_exists( $convertQuoteToCollectionResponse, 'waybillBase64' ) ) {
        // $this->waybillFile = $this->fileIoHandle( $convertQuoteToCollectionResponse->waybillBase64, 'waybill' );
        // Store Away first in DB.
        $_ = null;
      }

      if ( property_exists( $convertQuoteToCollectionResponse, 'labelsBase64' ) ) {
        // $this->labelsFile  = $this->fileIoHandle( $convertQuoteToCollectionResponse->labelsBase64, 'labels' );
        // Store Away first in DB.
        $_ = null;
      }

      return $this;
    }

    public function runAll( $requestQuoteResponse = NULL )
    {
      $requestQuoteResponse = $this->handleQuoteResponseData( $requestQuoteResponse );
      /* ========================================================================================================================================== */
      if ( $this->debug ) echo "\n\n-----------------------------------Converting-----------------------------------\n\n";
      /* ========================================================================================================================================== */

      $updateService     = $this->updateRequestQuoteService( $requestQuoteResponse );
      $quoteToWaybill    =     $this->convertQuoteToWaybill( $requestQuoteResponse );
      $quoteToCollection =  $this->convertQuoteToCollection( $requestQuoteResponse );

      // Need to decide what to return from this: WaybillNo, CollectNo, QuoteNo., etc.
      $rtnArray = [
        'WaybillNo' => property_exists(  $quoteToCollection, 'waybillno' ) ?  $quoteToCollection->waybillno : NULL,
        'CollectNo' => property_exists(  $quoteToCollection, 'collectno' ) ?  $quoteToCollection->collectno : NULL,
        'QuoteNo'   => property_exists( $requestQuoteResponse, 'quoteno' ) ? $requestQuoteResponse->quoteno : NULL,
        'Files'     => [
          'waybillFile' => property_exists( $quoteToCollection, 'waybillFile' ) ? $quoteToCollection->waybillFile : NULL,
           'labelsFile' =>   property_exists( $quoteToCollection, 'labelsFile' ) ? $quoteToCollection->labelsFile : NULL,
        ], 
      ];

      return (object) $rtnArray;
    }

    private function fileIoHandle( $data, $which='waybill', $orderId=0 )
    {
      $filenameParts = [
        'filenamePathPrefix'    => 'app' .DIRECTORY_SEPARATOR. 'public' .DIRECTORY_SEPARATOR,
        'filenameFullPath'      => $this->filenamePathDate .DIRECTORY_SEPARATOR. $which .DIRECTORY_SEPARATOR,
        'filenameFileName'      => $this->requestQuoteResponse->quoteno,
        'filenameFileSuffix'    => '_' . $orderId . '-' . $this->filenamePathTime,
        'filenameFileExtension' => '.'. $this->filenameExtension,
      ];

      $tempFolderChk  = implode( '', array_values( array_slice( $filenameParts, 0, 2 ) ) );
      $checkDirectory = storage_path( $tempFolderChk );

      if ( ! is_dir( $checkDirectory ) ) {
        @mkdir( storage_path( $checkDirectory ), 0775, true );
      }

      unset( $tempFolderChk, $checkDirectory );

      $fullFilepath = implode( '', array_values( $filenameParts ) );
      $filepath = storage_path( $fullFilepath );

      if ( $this->saveBase64ToFile( $data, $filepath ) ) {
        if ( $this->debug ) echo( "\nFile: " . ucfirst( $which ) . " file: " . $filepath . " saved successfully.\n" );
        $fileTypeStr = $which . "File";
        $this->{$fileTypeStr} = $filepath;

        return $filepath;

      } else {
        if ( $this->debug ) echo( "\nFile: " . ucfirst( $which ) . " file: " . $filepath . " failed to save.\n" );
      }

      return;
    }

}

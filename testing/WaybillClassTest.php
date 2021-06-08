<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Testing;

// use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\{RequestQuote, UpdateServiceQuote};
use \App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Waybill\GetSingleWaybill;

class WaybillClassTest
{
  public $testClass;
//   // public $requests;


  public function __construct()
  {
    $this->testClass = "Waybill class with 1 method.";

    $this->waybillGetSingleWaybill = ( new GetSingleWaybill );

    return $this;
  }

//   public static function runAllTests()
//   {
//       // Request PostalCode Lookup
//       self::basic_tinker_testing_of_requests_postalcodelookup_to_parcel_perfect_api();
//       // Request PlacesByName Lookup
//       self::basic_tinker_testing_of_requests_namelookup_to_parcel_perfect_api();

//       // Request Quote
//       self::basic_tinker_testing_of_requests_quote_to_parcel_perfect_api();
//       // Request Update Quote Service
//       self::basic_tinker_testing_of_requests_update_service_quote_to_parcel_perfect_api();

//       // return self::new CollectionClassTest();
//   }

//   public static function basic_tinker_testing_of_requests_quote_to_parcel_perfect_api()
//   {
//     $requestsRequestQuote   = ( new RequestQuote );
//     $methodTestRequestQuote = $requestsRequestQuote->requestQuote();

//     dump( __METHOD__, __LINE__, '{$methodTestRequestQuote}',  $methodTestRequestQuote );
//   }


//   public static function basic_tinker_testing_of_requests_postalcodelookup_to_parcel_perfect_api()
//   {
//     $requestsPostalCodeLookup   = ( new RequestQuote );
//     $methodTestPostalCodeLookup = $requestsPostalCodeLookup->postalCodeLookup( '8001' );

//     dump( __METHOD__, __LINE__, '{$methodTestPostalCodeLookup}',  $methodTestPostalCodeLookup );
//   }

//   public static function basic_tinker_testing_of_requests_namelookup_to_parcel_perfect_api()
//   {
//     $requestsNameLookup   = ( new RequestQuote );
//     $methodTestNameLookup = $requestsNameLookup->nameLookup( 'walm' );

//     dump( __METHOD__, __LINE__, '{$methodTestNameLookup}',  $methodTestNameLookup );
//   }

//   public static function basic_tinker_testing_of_requests_update_service_quote_to_parcel_perfect_api()
//   {
//     throw new \Exception( "Update Service Quote: Not yet implemented..." );

//     $requestsUpdateServiceQuote   = ( new UpdateServiceQuote );
//     $methodTestUpdateServiceQuote = $requestsUpdateServiceQuote->updateServiceQuote();

//     dump( __METHOD__, __LINE__, '{$methodTestUpdateServiceQuote}',  $methodTestUpdateServiceQuote );
//   }

}

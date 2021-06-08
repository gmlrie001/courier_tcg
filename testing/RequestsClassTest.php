<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Testing;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\RequestQuote;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\UpdateServiceQuote;

class RequestsClassTest
{

  public static function basic_tinker_testing_of_request_quote_to_parcel_perfect_api()
  {
    $requestQuote = ( new RequestQuote );

    if ( \method_exists( $requestQuote, 'requestQuote' ) ) {
      $methodTestRequestQuote = $requestQuote->requestQuote();

      dd( $methodTestRequestQuote );
    }

    return false;
  }


  public static function basic_tinker_testing_of_request_update_service_to_parcel_perfect_api()
  {
    $requestUpdateServiceQuote = ( new UpdateServiceQuote );

    if ( \method_exists( $requestUpdateServiceQuote, 'updateServiceQuote' ) ) {
      $methodTestRequestUpdateServiceQuote = $requestUpdateServiceQuote->updateServiceQuote();

      dd( $methodTestRequestUpdateServiceQuote );
    }

    return false;
  }

  // public static function basic_tinker_testing_of_submit_compound_collection_to_parcel_perfect_api()
  // {
  //   $collectionSubmitCompoundCollection = ( new SubmitCompoundCollection );

  //   if ( \method_exists( $collectionSubmitCompoundCollection, 'SubmitCompoundCollection' ) ) {
  //     $methodTestSubmitCompoundCollection = $collectionSubmitCompoundCollection->SubmitCompoundCollection();

  //     dd( $methodTestSubmitCompoundCollection );
  //   }

  //   return false;
  // }

}

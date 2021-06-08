<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Testing;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\RequestQuote;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\UpdateServiceQuote;

class RequestClassTesting
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
    $requestUpdateService = ( new UpdateServiceQuote );

    if ( \method_exists( $requestUpdateService, 'updateServiceQuote' ) ) {
      $methodTestRequestUpdateService = $requestUpdateService->updateServiceQuote();

      dd( $methodTestRequestUpdateService );
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

<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Testing;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\QuoteToCollection;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\SubmitCollection;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Collection\SubmitCompoundCollection;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\RequestQuote;
use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Requests\UpdateServiceQuote;

use App\Helpers\TheCourierGuyParcelPerfectAPI\Testing\RequestsClassTest;


class CollectionClassTest
{
  public static $requestedQuote;
  public static $quoteno;
  public static $service;


  public static function request_quote_testing_for_collection_conversion()
  {
    $cart = ( new \App\Models\Basket )->find( 265 );
    $requestQuote = new RequestQuote( $cart );

    if ( \method_exists( $requestQuote, 'requestQuote' ) ) {
      $methodTestRequestQuote = $requestQuote->requestQuote();

      self::$requestedQuote = json_decode( $methodTestRequestQuote, false );
      self::$quoteno = self::$requestedQuote->quoteno;
      self::$service = self::$requestedQuote->rates[0]->service;

      return json_encode( self::$requestedQuote, JSON_PRETTY_PRINT );
    }
  }

  public static function basic_tinker_testing_of_quote_to_collection_to_parcel_perfect_api()
  {
    $startTime['test_total'] = microtime( !0 );

    $collectionQuoteToCollection = ( new QuoteToCollection );
    $quote = self::request_quote_testing_for_collection_conversion();

    if ( \method_exists( $collectionQuoteToCollection, 'updateRequestQuoteService' ) ) {
      $startTime['updateRequestQuoteService'] = microtime( !0 );
      $methodTestUpdateRequestQuoteService  = $collectionQuoteToCollection->updateRequestQuoteService( $quote );
      dump( $methodTestUpdateRequestQuoteService );
      $endTime['updateRequestQuoteService']   = microtime( !0 );
      $timeDiff['updateRequestQuoteService'] = $endTime['updateRequestQuoteService'] - $startTime['updateRequestQuoteService'];
    }

    echo "\n\n===========================================================================\n\n";
    sleep( 1 );

    if ( \method_exists( $collectionQuoteToCollection, 'convertQuoteToWaybill' ) ) {
      $startTime['convertQuoteToWaybill'] = microtime( !0 );
      $methodTestConvertQuoteToWaybill = $collectionQuoteToCollection->convertQuoteToWaybill( $quote );
      dump( $methodTestConvertQuoteToWaybill );
      $endTime['convertQuoteToWaybill']   = microtime( !0 );
      $timeDiff['convertQuoteToWaybill'] = $endTime['convertQuoteToWaybill'] - $startTime['convertQuoteToWaybill'];
    }

    echo "\n\n===========================================================================\n\n";
    sleep( 1 );

    if ( \method_exists( $collectionQuoteToCollection, 'convertQuoteToCollection' ) ) {
      $startTime['convertQuoteToCollection'] = microtime( !0 );
      $methodTestConvertQuoteToCollection = $collectionQuoteToCollection->convertQuoteToCollection( $quote );
      dump( __METHOD__, __LINE__, $methodTestConvertQuoteToCollection );
      $endTime['convertQuoteToCollection']   = microtime( !0 );
      $timeDiff['convertQuoteToCollection'] = $endTime['convertQuoteToCollection'] - $startTime['convertQuoteToCollection'];
    }

    echo "\n\n===========================================================================\n\n";
    sleep( 1 );

    // if ( \method_exists( $collectionQuoteToCollection, 'runAll' ) ) {
    //   $methodTestRunAll = $collectionQuoteToCollection->runAll( $quote );
    //   dump( __METHOD__, __LINE__, $methodTestRunAll );
    // }

    $endTime['test_total']  = microtime(!0);
    $timeDiff['test_total'] = $endTime['test_total'] - $startTime['test_total'];

    echo "\n\n===========================================================================\n\n";
    echo( "\n================= Timings ==================\n" );
    print_r( [$startTime, $endTime, $timeDiff] );
    echo( "\n=================/ Timings /==================\n" );
    echo( "\nTime taken: " . $timeDiff['test_total'] . "\n" );
    echo "\n\n===========================================================================\n\n";

    return;
  }


//   public static function basic_tinker_testing_of_submit_collection_to_parcel_perfect_api()
//   {
//     $collectionSubmitCollection = ( new SubmitCollection );
//     if ( \method_exists( $collectionSubmitCollection, 'submitCollection' ) ) {
//       $methodTestSubmitCollection = $collectionSubmitCollection->submitCollection();
//       dd( $methodTestSubmitCollection );
//     }
//     return false;
//   }

//   public static function basic_tinker_testing_of_submit_compound_collection_to_parcel_perfect_api()
//   {
//     $collectionSubmitCompoundCollection = ( new SubmitCompoundCollection );
//     if ( \method_exists( $collectionSubmitCompoundCollection, 'SubmitCompoundCollection' ) ) {
//       $methodTestSubmitCompoundCollection = $collectionSubmitCompoundCollection->SubmitCompoundCollection();
//       dd( $methodTestSubmitCompoundCollection );
//     }
//     return false;
//   }

}

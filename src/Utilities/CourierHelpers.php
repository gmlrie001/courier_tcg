<?php

namespace Vault\CourierTcg\Utilities;

use Vault\CourierTcg\Utilities\CourierTraits;
use App\Helpers\SimpleClient;


class CourierHelpers
{
  use CourierTraits;

  // public function __construct()
  // {
  //   //
  // }

  public static function handleError( $response )
  {
    return json_decode(
      json_encode([
        'code'    => $response->errorcode,
        'message' => $response->errormessage,
      ], JSON_PRETTY_PRINT)
    );
  }

  public static function handleSuccess( $response )
  {
    if ( empty( $response->results ) && $response->errorcode == 0 ) {
      $return = json_decode( json_encode( "{}", JSON_PRETTY_PRINT ), false );

    } elseif ( is_array( $response->results ) && count( $response->results ) <= 1 ) {
      $return = json_decode( json_encode( $response->results ), false )[0];

    } else {
      $return = json_decode( json_encode( $response->results ), false );
    }

    return $return;
  }

  public static function getMD5SumOfString( $string ): string
  {
    if ( ! is_string( $string ) || NULL == $string ) return '';

    return \md5( $string );
  }

  public static function getMD5SumOfFile( $filePath ): string
  {
    if ( ! file_exists( $filePath ) || NULL == $filePath ) return '';

    return \md5_file( $filePath );
  }

}

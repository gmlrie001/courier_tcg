<?php

namespace Vault\CourierTcg\Testing;

use Vault\CourierTcg\Services\Auth\GetSalt;
use Vault\CourierTcg\Services\Auth\GetSecureToken;

class AuthClassTest
{
  public static $file;


  private static function basic_tinker_testing_auth_class_common_token_file_check()
  {
    self::$file = storage_path( '/app/public/test_token_id' );
    $time  = strtotime( 'now' );
    $dayInSecs = 60 * 60 * 24;

    if ( file_exists( self::$file ) ) {
      // $stats = fstat( $fhandle = fopen( self::$file, 'r' ) );
      $stats = stat( self::$file );
      $toRtn = file_get_contents( self::$file );

      if ( abs( $stats['mtime'] - $time ) > $dayInSecs) {
        // Call to expire current token (max: 24 hours)
        // class->method->toExpireToken()
        unlink( self::$file );
      }

      return $toRtn;
    }
    
    return !1;
  }

  public static function basic_tinker_testing_of_get_salt_to_parcel_perfect_api()
  {
    if ( $fileRtn = self::basic_tinker_testing_auth_class_common_token_file_check() ) {
      return $fileRtn;
    }

    // if ( ! file_exists( self::$file ) ) {
    $authGetSalt = ( new GetSalt );
    $methodTestGetSalt = $authGetSalt->getSalt();

    return $methodTestGetSalt;
    // }

    // return file_get_contents( self::$file );
  }

  public static function basic_tinker_testing_of_get_secure_token_to_parcel_perfect_api()
  {
    if ( $fileRtn = self::basic_tinker_testing_auth_class_common_token_file_check() ) {
      return $fileRtn;
    }

    // if ( ! file_exists( self::$file ) ) {
    $authGetSecureToken = ( new GetSecureToken );
    $methodTestGetSecureToken = $authGetSecureToken->getSecureToken();

    file_put_contents( self::$file, $methodTestGetSecureToken['token_id'] );

    return $methodTestGetSecureToken['token_id'];
    // }
  }

}

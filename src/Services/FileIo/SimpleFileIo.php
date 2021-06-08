<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Services\FileIo;

// use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierTraits;
// use App\Helpers\TheCourierGuyParcelPerfectAPI\TheCourierGuyPPAPI;

// use Vault\ShipmentCourier\Exceptions\ShipmentCourierException;

class SimpleFileIo // extends TheCourierGuyPPAPI
{
  use CourierTraits;

  public static function setupFilePath( $name='token_id' )
  {
    if ( NULL == $name ): $name = 'token_id';

    $path = storage_path( 'app/public' );

    return $path . DIRECTORY_SEPARATOR . $name;
  }

  public static function setFileContents( $file=NULL, $data=[] )
  {
    try {
      return file_put_contents( self::setupFilePath( $file ), json_encode( $data ) );

    } catch( \Exception $error ) {}
  }

  public static function getFileContents( $file )
  {
    if ( ! file_exists( $file ) ) {
      throw new \Exception( $file . ' is not a valid file or folder path.' );
    }

    try {
      return json_decode( file_get_contents( $file ) );

    } catch ( \Exception $error ) {}
  }

}

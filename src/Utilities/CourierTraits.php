<?php

namespace App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities;

// use App\Helpers\TheCourierGuyParcelPerfectAPI\Services\Auth\GetSecureToken;
// use App\Helpers\TheCourierGuyParcelPerfectAPI\Utilities\CourierHelpers;

use App\Helpers\SimpleClient;

trait CourierTraits
{
  public $debugTraits = false;


  public function buildApiEndpoint( $class = 'Auth', $method = 'getSecureToken', $params = [], $token = NULL )
  {
    if ( is_string( $params ) ) $params = json_decode( $params, true );

    $this->method = $method ?? NULL;
    $this->class  = $class ?? NULL;

    $this->email    = ( isset( $params['email'] ) ) ? $params['email'] : $this->email;
    $this->password = ( isset( $params['password'] ) ) ? $params['password'] : $this->password;
    $this->salt     = ( isset( $params['salt'] ) ) ? $params['salt'] : NULL;
  
    if ( $this->salt != NULL || $this->password != NULL ) {
      $this->saltMD5  = md5( $this->password . $this->salt );
    }

    // $this->token = ( isset( $token ) ) ? $token : NULL;
    $tokenFile = storage_path( '/app/public/test_token_id' );
    $token = ( file_exists( $tokenFile ) ) 
              ? file_get_contents( $tokenFile ) 
              : NULL; //( new GetSecureToken )->getSecureToken()['token_id'];
    $this->token = $token;

    $parameters = $params;
    // dump( __METHOD__, __LINE__, $method, $class, $params );

    if ( $this->token ) {
      $this->apiEndpointArray = [
        'apiBaseUri' => rtrim( $this->base, '/' ) . '/', 
        'queryStringParams' => http_build_query([
          'params'   => json_encode( $parameters ),
          'method'   => $this->method, 
          'class'    => $this->class,
          'token_id' => $this->token
        ])
      ];

    } else {
      $this->apiEndpointArray = [
        'apiBaseUri' => rtrim( $this->base, '/' ) . '/', 
        'queryStringParams' => http_build_query([
          'params' => json_encode( $parameters ),
          'method' => $this->method, 
          'class'  => $this->class
        ])
      ];
    }

    // Return the API Endpoint URI
    return implode( '?', $this->apiEndpointArray );
  }

  /**
   * Example successful response for the __Auth::getSalt call
   * 
   * * ************ *
   * | JSON format: |
   * * ************ *
   *  {
   *    "errorcode": 0, 
   *    "errormessage": "", 
   *    "total": 1,
   *    "results": [{"salt": "020b5d784fcd35835d17020f0ac88b32"}]
   *  }
   *
   */
  public function makeApiCall( ...$params )
  {
    $parameters = $params[0];
    $client = new SimpleClient();

    $response = $client->fetch( 
      $parameters['url'], 
      $parameters['data'], 
      $this->customHeaders, 
      $parameters['method'] 
    );

    $this->response = $response;

    return $this;
  }

  public function handleApiResponse( $showDebug=false )
  {
    $header   = $this->response->header; // ->result is wrapper.
    $info     = ( object ) $this->response->info; // ->result is wrapper.
    $result   = $this->response->result; // ->result is wrapper.

    if ( $header === 0 ) {
      // throw new \Exception( 'Connection lost. Please check your connectivity and try again!' );
      dump( 'Connection lost. Please check your connectivity and try again!' );
      return;
    }

    $response = json_decode( $result, false );

    if ( $this->debugTraits ) dump( __METHOD__, __LINE__, $this, get_defined_vars(), $response );

    return ( $response->errorcode > 0 && $response->errormessage !== "" ) 
            ? CourierHelpers::handleError( $response ) 
            : CourierHelpers::handleSuccess( $response );
  }

  public function getMD5SumOfString( $string ): string
  {
    if ( ! is_string( $string ) || NULL == $string ) return '';

    return CourierHelpers::getMD5SumOfString( $string );
  }

  public function getMD5SumOfFile( $filePath ): string
  {
    if ( ! file_exists( $filePath ) || NULL == $filePath ) return '';

    return CourierHelpers::getMD5SumOfFile( $filePath );
  }

  /**
   * Save base64 image to disk as PDF by default
   */
  public function saveBase64ToFile( $base64string, $filename ) // , $extension='.pdf' )
  {
    // $path = '/app/public/';
    // $filePath = storage_path( $path . $filename ); // .$extension );
    $filePath      = (string) $filename;
    $decodedString = base64_decode( $base64string );
    $fileHandle    = fopen( $filePath, "w" );

    if ( $fileHandle ) {
        fwrite( $fileHandle, $decodedString );
        fclose( $fileHandle );

        return !0;

      } else {
        fclose( $fileHandle );

        return !1;
    }
  }

}

<?php

namespace Vault\CourierTcg\Services\Verification;

use Illuminate\Http\Request;


class PlaceNameLookupService
{

  public function __construct()
  {
    throw new \Exception( 'Not yet implemented!' );
  }

  // public function placeNameLookup( Request $request )
  // {
  //     $_originalRequest = $request;

  //     $addressInfo = $request->all();
  //     $aramexApi   = new AramexAPI();
  //     $aramexApiPostalCodes = new AramexPostalCodeValidation();

  //     $prms = (object) $addressInfo; //->only( ['country', 'suburb', 'postal_code'] );

  //     $prms->delivery_country     = $prms->country;
  //     $prms->delivery_suburb      = $prms->suburb;
  //     $prms->delivery_postal_code = $prms->postal_code;

  //     $prms   = (array) $prms;
  //     $params = $aramexApi->setupPostalCodesParams( $prms );

  //     $rtnMessage = json_decode( $aramexApi->getPostalCodes( $params )->result, false );
  //     Log::info( json_encode( $rtnMessage ) );

  //     if ( $rtnMessage->status_code === 0 ) {
  //       // if ( $_originalRequest instanceof CreateRequest ): return $this->addAddress( $_originalRequest ); endif;
  //       // $addressCount = UserAddress::where('user_id', Session::get('user.id'))->count() + 1;
  //       // $user = UserAddress::create( $request->all() );

  //       // $user->user_id = Session::get('user.id');
  //       // $user->order = $addressCount;
  //       // $user->status = 'PUBLISHED';

  //       // if ($addressCount < 2) { $user->default_address = 1; }

  //       // $user->save();
        
  //       // return Redirect::back()->with('message', 'Address added successfully.');
  //       return json_encode( ['status' => 'success'] );
  //     }

  //     $rtnMessage = $aramexApiPostalCodes->get_return( $prms );

  //     return json_encode( $rtnMessage );
  // }

}

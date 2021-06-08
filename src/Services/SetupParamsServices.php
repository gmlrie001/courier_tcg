<?php

namespace Vault\CourierTcg\Services;


class SetupParamsServices
{
  public $debug = false;
  public $instance;


  public function __construct( $debug=!1 )
  {
    $this->debug = $debug;

    $this->instance = $this->newInstance();

    return $this;
  }

  public function newInstance()
  {
    return new static;
  }

  public function setupShipRateParams( $cart )
  {
    $params = [];
    $params = array_merge( 
      $params, 
      $this->clientInfo(), 
      $this->clientOrigin(), 
      $this->customerDestination( $cart ),
      $this->paymentOptions(),
      $this->miscOptions(),
      $this->shippingParcel( $cart )
    );

    if ( $this->debug ) info( __METHOD__, __LINE__, $params, $cart );

    return $params;
  }

  public function setupShipmentParams( $cart )
  {
    $params = [];
    $params = array_merge( 
      $params, 
      $this->clientInfo(), 
      $this->sender(), 
      $this->receiver( $cart ),
      $this->paymentOptions(),
      $this->miscOptions(),
      $this->specialInstructions( '' ),
      $this->insuranceReq(),
      $this->labelInfo(),
      $this->waybillInfo(),
      $this->shippingParcel( $cart )
    );

    if ( $this->debug ) info( __METHOD__, __LINE__, $params, $cart );

    return $params;
  }

  public function setupPickupParams( $cart )
  {
    $params = [];
    $params = array_merge( 
      $params, 
      $this->clientInfo(), 
      $this->sender(), 
      $this->receiver( $cart ),
      $this->paymentOptions(),
      $this->miscOptions(),
      $this->pickupInfo()
    );

    if ( $this->debug ) info( __METHOD__, __LINE__, $params, $cart );

    return $params;
  }


  private function pickupInfo()
  {
    $site = \App\Models\Site::first();
    $surl = url('/');
    $name = $site->site_name;
    $status = 'Ready';

    $reference1 = ucwords( $name ) . " online store purchase.";
    $reference2 = NULL;

    $comments = "Ecommerce online purchase fulfillment: " . ucwords( $name ) . "(" . $surl . ")";
    unset( $site, $surl, $name );

    $pickup_date  = date( 'Y-m-d', strtotime( 'tomorrow' ) );
    $ready_time   = date( 'H:i:s', strtotime( 'tomorrow 2pm' ) );
    $closing_time = date( 'H:i:s', strtotime( 'tomorrow 6pm' ) );

    if ( $this->debug ) info( __METHOD__, __LINE__, $params, $cart, get_defined_vars() );

    return [
      "reference1"   => $reference1,
      "reference2"   => $reference2,
      "comments"     => $comments,
      "status"       => $status,
      "ready_time"   => $ready_time,
      "pickup_date"  => $pickup_date,
      "closing_time" => $closing_time,
    ];
  }

  private function clientInfo()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'account_number' => $this->config['AccountNumber'],
      'email_address'  => $this->config['UserName'],
      'password'       => $this->config['Password'],
      'account_pin'    => $this->config['AccountPin'],
    ];
  }

  private function clientOrigin()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      "sender_country_code" => "ZA",
      "sender_country_name" => "South Africa",
      "sender_suburb"       => "Brooklyn",
      "sender_postal_code"  => "7405",
    ];
  }

  private function customerDestination( $cart )
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      "receiver_country_code" => $this->countryCodes( $cart['delivery_country'] ),
      "receiver_country_name" => $cart['delivery_country'],
      "receiver_suburb"       => $cart['delivery_suburb'],
      "receiver_postal_code"  => $cart['delivery_postal_code'],
    ];
  }

  private function sender()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      "sender_street_address" => $this->config['SenderStreetAddress'], // "7 Section Street",
      "sender_business_park"  => $this->config['SenderStreetAddress'], //  "Shop No. 4, Section Street Business Park",
      "sender_other_address"  => $this->config['SenderStreetAddress'], //  "None",
      "sender_country_code"   => $this->config['SenderStreetAddress'], //  "ZA",
      "sender_country_name"   => $this->config['SenderStreetAddress'], //  "South Africa",
      "sender_state"          => $this->config['SenderStreetAddress'], //  "Cape Town",
      "sender_suburb"         => $this->config['SenderStreetAddress'], //  "Brooklyn",
      "sender_postal_code"    => $this->config['SenderStreetAddress'], //  "7405",
      "sender_name"           => $this->config['SenderStreetAddress'], //  "Daniel",
      "sender_reference1"     => "African Oils online store purchase.",
      "sender_reference2"     => NULL,
      "sender_contact_person" => $this->config['SenderStreetAddress'], //  "Daniel",
      "sender_contact_number" => $this->config['SenderStreetAddress'], //  "07699139873",
      "sender_contact_email"  => $this->config['SenderStreetAddress'], //  "daniel@africanoils.co.za",
    ];
  }

  private function receiver( $cart )
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      "receiver_street_address" => $cart->delivery_address_line_1,
      "receiver_business_park"  => $cart->delivery_address_line_2 ?? NULL,
      "receiver_other_address"  => NULL,
      "receiver_state"          => $cart->delivery_province,
      "receiver_country_code"   => $this->countryCodes( $cart->delivery_country ),
      "receiver_country_name"   => $cart->delivery_country,
      "receiver_suburb"         => $cart->delivery_suburb,
      "receiver_postal_code"    => $cart->delivery_postal_code,
      "receiver_name"           => $cart->delivery_name . " " . $cart->delivery_surname,
      "receiver_reference1"     => "African Oils online purchase, order number (ID:{".$cart->id."}) from https://africanoils.co.za",
      "receiver_reference2"     => NULL,
      "receiver_contact_person" => $cart->delivery_name . " " . $cart->delivery_surname, // "Angelo Saim",
      "receiver_contact_number" => $cart->delivery_phone, // "0769913873",
      "receiver_email_address"  => $cart->user->email, // "studio@monzamedia.com",
    ];
  }

  private function shippingParcel( $cart )
  {
    $cart_total = 0;
    $total_weight = 0;
    $l = $w = $h = 0;

    foreach( $cart->products as $key=>$product ) {
      $l += $product->product->length;
      $w += $product->product->width;
      $h += $product->product->height;
      $cart_total   += $product->price * $product->quantity;
      $total_weight += $product->product->weight;
    }
    $package_dims = ['length' => $l, 'width' => $w, 'height' => $h];
    unset( $l, $w, $h );

    $params['parcels'] = [
      [
        "parcel_value" => $cart_total, // ZAR
        "quantity"     => $cart->products->sum( 'quantity' ),
        "length"       => $package_dims['length'], // cm
        "width"        => $package_dims['width'], // cm
        "height"       => $package_dims['height'], // cm
        "weight"       => $total_weight // kg
      ],
    ];

    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );
    unset( $total_weight, $cart_total );

    return $params;
  }

  private function paymentOptions()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'payment_type'  => $this->config['PaymentType'],
      'service_type'  => $this->config['ServiceType'],
    ];
  }

  private function miscOptions()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'is_documents'      => false,
      'require_insurance' => false,
    ];
  }

  private function specialInstructions( $str='' )
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return ['special_instructions' => $str, ];
  }

  private function insuranceReq()
  {
    $insuranceRequired = !1;
    $insuranceValue    = number_format( 0, 2 );

    // $insuranceRequired = $this->config['require_insurance'] ?? $request->get('require_insurance');
    // if ( $insuranceRequired ) {
    //   $insuranceValue = $this->config['insurance_value'] ?? $request->get('insurance_value');
    // }
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'require_insurance' => $insuranceRequired,
      'insurance_value'   => $insuranceValue,
    ];
  }

  private function labelInfo()
  {
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'waybill_print_template' => 9201,
      'waybill_pdf_fetch_type' => 'URL',
    ];
  }

  private function waybillInfo()
  {
    // PLEASE NOTE: ONLY letters and numbers allowed no special characters/punctuation.
    $waybill_site_prefix = NULL;
    $waybillTrackingCode = '';

    if ( $waybill_site_prefix != NULL || isset( $waybill_site_prefix ) ) {
      $waybill_tracking_no = md5( $this->getGUID() );
      $waybillTrackingCode = str_replace( 
        ['-', '_', '.', ',', '#', '@', '&', '$', '*', '(', ')', '[', ']', '{', '}'], 
        ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''], 
        $waybill_site_prefix . $waybill_tracking_no 
      );
    }
    
    if ( $this->debug ) info( __METHOD__, __LINE__, $this, get_defined_vars() );

    return [
      'waybill_number'=> $waybillTrackingCode
    ];
  }

}

<?php

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

function setBasePath()
{
  $dir    = dirname(dirname(dirname(__DIR__)));
  $dirArr = explode(DIRECTORY_SEPARATOR, $dir);

  if (end($dirArr) === 'stable_vault_core'): $base = $dir; endif;

  $cfpath = realpath($base . '/resources/views/templates/vault_config.php');
  $conf   = include($cfpath);

  return $conf['aramex_credentials'];
}
$config = setBasePath();
// die( print_r( $config ) );

$customHeaders = [
  'Content-Type: application/json',
  'Accept: */*',
];

$country_codes = [
  'South Africa'   => 'ZA',
  'Australia'      => 'AU',
  'United States'  => 'US',
  'United Kingdom' => 'UK',
  'Germany'        => 'DE',
];

$clientInfo = [
  'account_number' => $config['AccountNumber'],
  'email_address'  => $config['UserName'],
  'password'       => $config['Password'],
  'account_pin'    => $config['AccountPin'],
];

$payment = [
  'payment_type' => 'P',
  'service_type' => 'PEC',
];

$misc = [
  'is_documents'      => false,
  'require_insurance' => false,
];

$egCart = [
  "id" => 7,
  "created_at" => "2020-08-24 12:20:30",
  "updated_at" => "2020-08-24 15:36:23",
  "deleted_at" => null,
  "billing_name" => "Riedaa",
  "billing_surname" => "Gamieldien",
  "billing_phone" => "0123456789",
  "billing_company" => "Monzamedia",
  "billing_address_line_1" => "Unit 1, Business Gardens Village",
  "billing_address_line_2" => "Incholm Place",
  "billing_suburb" => "Cape Town",
  "billing_city" => "Cape Town",
  "billing_postal_code" => "8001",
  "billing_province" => "Western Cape",
  "billing_country" => "South Africa",
  "delivery_name" => "Riedaa",
  "delivery_surname" => "Gamieldien",
  "delivery_phone" => "0123456789",
  "delivery_company" => "Monzamedia",
  "delivery_address_line_1" => "Unit 1, Business Gardens Village",
  "delivery_address_line_2" => "Incholm Place",
  "delivery_suburb" => "Cape Town",
  "delivery_city" => "Cape Town",
  "delivery_postal_code" => "8001",
  "delivery_province" => "Western Cape",
  "delivery_country" => "South Africa",
  "user_id" => 103228,
  "subtotal" => 5000.0,
  "tax" => null,
  "tax_rate" => null,
  "total" => 5000.0,
  "discount" => null,
  "discount_type" => null,
  "order_state" => null,
  "shipping_title" => null,
  "shipping_description" => null,
  "shipping_time_of_arrival" => null,
  "shipping_cost" => null,
  "needs_quote" => null,
  "quote_no" => null,
  "coupon" => null,
  "coupon_discount" => null,
  "coupon_discount_type" => null,
  "coupon_value" => 0,
  "coupon_shipping" => null,
  "order_placed" => null,
  "laybye_deposit_percentage" => null,
  "laybye_term" => null,
  "payment_method" => null,
  "store_credit_value" => null,
  "collection_code" => null,
  "order_completed" => null,
  "ecomOrderId" => null,
];

$origin = [
  "sender_country_code" => "ZA",
  "sender_country_name" => "South Africa",
  "sender_suburb"       => "Brooklyn",
  "sender_postal_code"  => "7405",
];

$destination = [
  "receiver_country_code" => $country_codes[$egCart['delivery_country']],
  "receiver_country_name" => $egCart['delivery_country'],
  "receiver_suburb"       => $egCart['delivery_suburb'],
  "receiver_postal_code"  => $egCart['delivery_postal_code'],
];

$sender = [
  "sender_street_address" => "Shop No. 4",
  "sender_business_park" => "Business Park",
  "sender_other_address" => null,
  "sender_country_code" => "ZA",
  "sender_country_name" => "South Africa",
  "sender_state" => "Cape Town",
  "sender_suburb" => "Brooklyn",
  "sender_postal_code" => "7405",
  "sender_name" => "Daniel",
  "sender_reference1" => "African Oils Ecommerce SalesOrder https://africanoils.co.za",
  "sender_reference2" => "",
  "sender_contact_person" => "Daniel",
  "sender_contact_number" => "07699139873",
  "sender_contact_email" => "daniel@africanoils.co.za",
];

$receiver = [
  "receiver_street_address" => $egCart['delivery_address_line_1'],
  "receiver_business_park"  => "None",
  "receiver_other_address"  => "None",
  "receiver_state"        => $egCart['delivery_province'],
  "receiver_country_code" => $country_codes[ $egCart['delivery_country'] ],
  "receiver_country_name" => $egCart['delivery_country'],
  "receiver_suburb"       => $egCart['delivery_suburb'],
  "receiver_postal_code"  => $egCart['delivery_postal_code'],
  "receiver_name"       => $egCart['delivery_name'],
  "receiver_reference1" => "African Oils Ecommerce Order(id:{".$egCart['id']."}) _@_> https://africanoils.co.za",
  "receiver_reference2" => "",
  "receiver_contact_person" => $egCart['delivery_name'] . " " . $egCart['delivery_surname'], // "Angelo Saim",
  "receiver_contact_number" => $egCart['delivery_phone'], // "0769913873",
  // "receiver_email_address"  => \App\Models::find( $egCart['user_id'] )->email, // "studio@monzamedia.com",
];

$pickup = [
  "reference1" => "African Oils Ecommerce Order Fulfilment and Shipping",
  "reference2" => "",
  "comments" => "Ecommerce purchase @ African Oils -- https://africanoils.co.za",
  "status"   => 'Ready',
  "pickup_date"  => date( 'Y-m-d', strtotime( 'tomorrow' ) ),
  "ready_time"   => date( 'H:i:s', strtotime( 'tomorrow noon' ) ),
  "closing_time" => date( 'H:i:s', strtotime( 'tomorrow 6pm' ) ),
];

function getcartTotal( $cart, $total=0.00 )
{
  foreach( $egCart->products as $key=>$product ) {
    if( NULL != $product->price && NULL != $product->quantity ) {
      continue;
    }

    $total += ( $product->price * $product->quantity );
    unset( $key, $product );
  }

  return $total;
}

function getCartItemsCount( $cart, $sum=0 )
{
  $sum++; $sum++;
  return $sum; // $cart->products->sum( 'quantity' );
}

function calcVolume( $l, $h=NULL, $w=NULL, $r=NULL )
{
  // Determines/guesses at the shape of object as either box or cyclinder
  if( (NULL != $W && is_number( $w ) ) && NULL == $r ) {
    $approxShape = 'RECT';
    $length = $l; $width = $w; $height = $h;
  } else {
    $approxShape = 'CYCL';
    $length = $l; $width = $w; $height = $h;
  }

  // CRUDE Approx. is l . w . h
  return $length * $width * $height;
}

function calcDensity()
{
  return;
}

function calcWeightFromVolume()
{
  return;
}

function fetch($url, $data, $customHeaders, $method="GET")
{
    $curlHandler = curl_init();

    // Fail the cURL request if response code = 400 (like 404 errors)
    curl_setopt($curlHandler, CURLOPT_FAILONERROR, false);

    // Do not check the SSL certificates
    curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($curlHandler, CURLOPT_CAINFO, $this->ssl_cert); // Set the location of the CA-bundle

    curl_setopt($curlHandler, CURLINFO_HEADER_OUT, true);
    curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlHandler, CURLOPT_VERBOSE, true);
    // Follow redirects, if any
    curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($curlHandler, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($curlHandler, CURLOPT_TIMEOUT, 30);
    curl_setopt($curlHandler, CURLOPT_DNS_CACHE_TIMEOUT, 75);

    switch (strtolower($method)):
      case('post'):
        $data_string = $data; // json_encode( $data, JSON_PRETTY_PRINT );
        print_r($data_string);
        // die();
        $length = strlen($data_string);
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $customHeaders);
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $data_string);
        unset($data_string);
        break;
      case('get'):
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $this->customHeaders);
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        break;
      // default:
        // return;
    endswitch;

    // Execute the request
    $result = curl_exec($curlHandler);
    // Get the headers and other info. regarding the request
    $header = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
    $info   = curl_getinfo($curlHandler);
    // Close request handler and clean up
    curl_close($curlHandler);
    unset($curlHandler);

    $output = new \stdClass;
    $output->header = $header;
    $output->info   = $info;
    $output->result = $result;

    return $output;
}

function getGUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.

        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid   = chr(123)// "{"
                  .substr($charid, 0, 8) . $hyphen
                  .substr($charid, 8, 4) . $hyphen
                  .substr($charid, 12, 4) . $hyphen
                  .substr($charid, 16, 4) . $hyphen
                  .substr($charid, 20, 12)
                .chr(125);// "}"

        return $uuid;
    }
}

function get_rate($customHeaders, $client_info, $origin, $destination, $payment, $misc, $cart)
{
    /**
     * GetRate
     */
  $params = array_merge( $client_info, $origin, $destination, $payment, $misc );
  // Parcel will be representative of an entire order with no splitting for now
  // _*- FUTURE -*_ :: extend to allow order split shipments.
  $params['parcels'] = [
    [
      "parcel_value" => 199, // ZAR
      "quantity" => 2,
      "length" => 30, // cm
      "width" => 10, // cm
      "height" => 40, // cm
      "weight" => 1 // kg
    ],
  ];

  // die( print_r( $params ) );

  $data = json_encode( $params, JSON_PRETTY_PRINT );
  unset( $params );

  return fetch('https://nservice.aramex.co.za/Json/JsonV1/GetRate', $data, $customHeaders, "POST");
  // ["status_code":0,"status_description":null,"change_description":null,"rate":162.56,"expected_delivery_date":"2020-08-27"}
}

function submit_waybill($customHeaders, $client_info, $sender, $receiver, $payment, $misc, $cart, $specInstructions=NULL, $insurance=[false, 0], $require_label=[9201, 'URL'])
{
    /**
     * SubmitWaybill
     */
    // [
    //   "email_address" => "daniel@africanoils.co.za",
    //   "account_number" => "251333", 
    //   "account_pin" => "654654", 
    //   "password" => "Tandor12!",

    //   "sender_street_address" => "Shop No. 4",
    //   "sender_business_park" => "Business Park",
    //   "sender_other_address" => null,
    //   "sender_country_code" => "ZA",
    //   "sender_country_name" => "South Africa",
    //   "sender_state" => "Cape Town",
    //   "sender_suburb" => "Brooklyn",
    //   "sender_postal_code" => "7405",
    //   "sender_name" => "Daniel",
    //   "sender_reference1" => "Aramex JSON API Test 1",
    //   "sender_reference2" => "Aramex JSON API Test 2",
    //   "sender_contact_person" => "Daniel",
    //   "sender_contact_number" => "07699139873",

    //   "receiver_street_address" => "1 Main street",
    //   "receiver_business_park" => "None",
    //   "receiver_other_address" => "None",
    //   "receiver_state" => "Cape Town",
    //   "receiver_country_code" => "ZA",
    //   "receiver_country_name" => "South Africa",
    //   "receiver_suburb" => "Bellville",
    //   "receiver_postal_code" => "7530",
    //   "receiver_name" => "Angelo Saim",
    //   "receiver_reference1" => "Test Waybill 1",
    //   "receiver_reference2" => "Test Waybill 2",
    //   "receiver_contact_person" => "Angelo Saim",
    //   "receiver_contact_number" => "0769913873",
    //   "receiver_email_address" => "studio@monzamedia.com",

    //   "payment_type" => "P",
    //   "service_type" => "PEC",

    // "is_import" => false,
    // "is_document" => false,

    $params = array_merge( $client_info, $sender, $receiver, $payment, $misc );
    $params['special_instructions'] = $specInstructions;
    $params['require_insurance']    = $insurance[0];
    $params['insurance_value']      = $insurance[1];
    $params['waybill_print_template'] = $require_label[0];
    $params['waybill_pdf_fetch_type'] = $require_label[1];
    $params['waybill_number'] = "AOV".md5( getGUID() );
    $params['parcels'] = [
      [
        "parcel_number" => "AO-".mt_rand( 500, 100000 ),
        "parcel_description" => "African Oils Online Sale for ".$receiver['receiver_name'],
        "parcel_value" => 1800,
        "quantity" => 20,
        "length" => 50,
        "width" => 20,
        "height" => 30,
        "weight" => 1.25
      ],
    ];

    // die( print_r( $params ) );

    $data = json_encode( $params, JSON_PRETTY_PRINT );
    unset( $params );

    return fetch('https://nservice.aramex.co.za/Json/JsonV1/SubmitWaybill', $data, $customHeaders, "POST");
    // {"status_code":0,"status_description":"Transaction successful","change_description":null,"waybill_number":"AOV5237311","label_print":"https://ws.aramex.net/content/rpt_cache/f6f5fc985cc048b596976aeba55fa52a.pdf"}
}

function track_waybill($customHeaders, $waybill_number, $clientInfo )
{
    /**
     * GetWaybillTracking
     */
    $params = [
      "waybill_number" => $waybill_number,
      "email_address"  => $clientInfo['email_address'],
      "account_number" => $clientInfo['account_number'], 
      "password"       => $clientInfo['password'],
    ];

    $data = json_encode( $params, JSON_PRETTY_PRINT );
    unset( $params );

    return fetch('https://nservice.aramex.co.za/Json/JsonV1/GetWaybillTracking', $data, $customHeaders, "POST");
    // {"status_code":0,"status_description":"Transaction successful","has_attachment":false,"tracking_information":[{"action_date":"2020-08-24 13:39:00","description":"Record created.","location":"Cape Town, South Africa","update_country":null,"customer_description":""}]}
}

function book_collection($customHeaders, $client_info, $sender, $receiver, $payment, $cart, $pickup)
{
    /**
     * SubmitCollection
     */

     // "collection_number" => $pickup,
      // "email_address"     => $client['email_address'],
      // "password"          => $client['password'],
      // "account_number"    => $client['account_number'],
      // "sender_street_address" => "Shop No. 4",
      // "sender_business_park" => "Business Park",
      // "sender_other_address" => null,
      // "sender_country_code" => "ZA",
      // "sender_country_name" => "South Africa",
      // "sender_state" => "Cape Town",
      // "sender_suburb" => "Brooklyn",
      // "sender_postal_code" => "7405",
      // "sender_name" => "Daniel",
      // "sender_reference1" => "African Oils Online Order => ID-494",
      // "sender_reference2" => "",
      // "sender_contact_person" => "Daniel",
      // "sender_contact_number" => "07699139873",
      
      // "receiver_street_address" => $egCart['delivery_address_line_1'], // "1 Main street",
      // "receiver_business_park" => "None",
      // "receiver_other_address" => "None",
      // "receiver_state" => $egCart['delivery_province'],
      // "receiver_country_code" => $country_codes[ $egCart['delivery_country'] ],
      // "receiver_country_name" => $egCart['delivery_country'],
      // "receiver_suburb" => $egCart['delivery_suburb'],
      // "receiver_postal_code" => $egCart['delivery_postal_code'],
      // "receiver_name" => $egCart['delivery_name'] . " " . $egCart['delivery_surname'],
      // "receiver_reference1" => "",
      // "receiver_reference2" => "",
      // "receiver_contact_person" => "Angelo Saim",
      // "receiver_contact_number" => "0769913873",
      // "receiver_email_address" => "studio@monzamedia.com",

      // "payment_type" => "P",
      // "service_type" => "PEC",

    $params = array_merge(
      $client_info,
      $sender,
      $receiver,
      $payment
    );
    $params = array_merge( $params, $pickup );
    $params['parcels'] = [
      [
        'parcel_value' => 500,
        'quantity'     => 5,
        'length'       => 30,
        'width'        => 10,
        'height'       => 40,
        'weight'       => 10
      ],
    ];

    $data  = json_encode( $params, JSON_PRETTY_PRINT );
    unset( $params );

    return fetch('https://nservice.aramex.co.za/Json/JsonV1/SubmitCollection', $data, $customHeaders, "POST");
    // print_r($shipment);
    // {"status_code":0,"status_description":"Transaction successful","change_description":null,"collection_reference":"H246B30"}
}

function collection_tracking($customHeaders, $collection_number, $clientInfo )
{
    /**
     * GetCollectionTracking
     */
  $params = [
    "collection_number" => $collection_number,
    "email_address"     => $clientInfo['email_address'],
    "password"          => $clientInfo['password'],
    "account_number"    => $clientInfo['account_number'],
  ];

  $data  = json_encode( $params, JSON_PRETTY_PRINT );
  unset( $params );
  
  return fetch('https://nservice.aramex.co.za/Json/JsonV1/GetCollectionTracking', $data, $customHeaders, "POST");
  // {"status_code":0,"status_description":"Transaction successful","collection_date":"\/Date(1598269260000)\/","entity":"CPT","last_status":"In Progress","last_status_description":"","pickup_date":"\/Date(1598306400000)\/","reference":"H246B30"}
}


$results = get_rate( $customHeaders, $clientInfo, $origin, $destination, $payment, $misc, $egCart );
$response = json_decode( $results->result, false );
die( print_r( ['RESULT: ', $response] ) );

// $results = submit_waybill( $customHeaders, $clientInfo, $sender, $receiver, $payment, $misc, $egCart );
// $response = json_decode( $results->result, false );
// die( print_r( ['RESULT: ', $response] ) );
// // Waybill Tracking Number: AOV4f8a05b6bf5ae0258637ed0c4ff589f9
// // URL to print_label:  https://ws.aramex.net/content/rpt_cache/567129c6266c4f2aa603cd96d9adee28.pdf

// // NO Events YET! 24Aug2020@18h00
// $results = track_waybill( $customHeaders, "AOV4f8a05b6bf5ae0258637ed0c4ff589f9", $clientInfo );
// $response = json_decode( $results->result, false );
// die( print_r( ['RESULT: ', $response] ) );

// $results  = book_collection( $customHeaders, $clientInfo, $sender, $receiver, $payment, $egCart, $pickup );
// $response = json_decode( $results->result, false );
// die( print_r( ['RESULT: ', $response, $pickup] ) );
// // Collection Number: H247FDF

// $results = collection_tracking($customHeaders, "H247FDF", $clientInfo );
// $response = json_decode( $results->result, false );
// die( print_r( ['RESULT: ', $response] ) );
// // [collection_date] => /Date(1598285340000)/    
// // [pickup_date] => /Date(1598306400000)/  

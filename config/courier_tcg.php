<?php

  return [

  // Special delivery instructions default value
    'specialDeliveryInstructions' => "",

  // Client specific account information/credentials
    'accountInfo' => [
      'email'         => "tcg11@ecomm",
      'password'      => "tcgecomm11",
      'accountNumber' => NULL,
      'serviceType'   => NULL,
      'accountPin'    => NULL,
    ],

  // Client specific account information/credentials
    'shipmentOrigin' => [
      'originStreetAddress' => "",
      'originBusinessPark'  => NULL,
      'originOtherAddress'  => NULL,
      'originStateProvince' => "",
      'originCountryCode'   => "ZA",
      'originCountryName'   => "South Africa",
      'originSuburb'        => "",
      'originPostalCode'    => "",
      'originContactName'   => "",
      'originContactPerson' => "",
      'originContactPhone'  => "",
      'originContactEmail'  => "@",
    ],

  // Client specific account information/credentials
    'shipmentDestination' => [
      'destinationStreetAddress' => "", // 'delivery_address_line_1',
      'destinationBusinessPark'  => "", // 'delivery_address_line_2',
      'destinationOtherAddress'  => NULL, // 'delivery_address_line_2',
      'destinationStateProvince' => "", // 'delivery_province',
      'destinationCountryCode'   => "", // 'delivery_country',
      'destinationCountryName'   => "", // 'delivery_country',
      'destinationSuburb'        => "", // 'delivery_suburb',
      'destinationPostalCode'    => "", // 'delivery_postal_code',
      'destinationContactName'   => "", // 'delivery_company',
      'destinationContactPerson' => "", // 'delivery_name',
      'destinationContactPhone'  => "", // 'delivery_phone',
      'destinationContactEmail'  => "@", // 'user.email',
      'destinationReferenceArr'  => "", // 'id', // 
    ],

  // Client specific account information/credentials
    'orderDeliveryKeys' => [
      'delivery_address_line_1',
      'delivery_address_line_2', 
      'delivery_province',
      'delivery_country', // 2 letter ISO-Code
      'delivery_country', // Full name
      'delivery_suburb',
      'delivery_city', 
      'delivery_postal_code',
      'delivery_company',
      'delivery_name',
      'delivery_surname',
      'delivery_phone',
    ],

  // Client specific account information/credentials
    'shipmentOrderItems' => [
    ],

  // Client specific account information/credentials
    'shipmentPickupDetails' => [
      'pickupComments'     => NULL,
      'pickupReference1'   => NULL,
      'pickupReference2'   => NULL,
      'pickupDate'         => date( 'Y-m-d 00:00:00', strtotime( 'tomorrow' ) ),
      'pickupReadyTime'    => '14:00',
      'pickupOpeningTime'  => '11:00',
      'pickupClosingTime'  => '17:00',
      'pickupEntityStatus' => 'Ready'
    ],

  ];

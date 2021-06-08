<?php

  return [

  // Special delivery instructions default value
    'specialDeliveryInstructions' => "",

  // Client specific account information/credentials
    'accountInfo' => [
      'email'         => "tcg11@ecomm",
      'password'      => "tcgecomm11",
      'accountNumber' => 'PPO',
      'serviceType'   => 'ONX',
      'accountPin'    => NULL,
    ],

  // Client specific account information/credentials
    'shipmentOrigin' => [
      'originStreetAddress' => "25 Upper Cambridge Street",
      'originBusinessPark'  => NULL,
      'originOtherAddress'  => NULL,
      'originStateProvince' => "Western Cape",
      'originCountryCode'   => "ZA",
      'originCountryName'   => "South Africa",
      'originSuburb'        => "Walmer Estate",
      'originPostalCode'    => "7925",
      'originContactName'   => "Riedaa",
      'originContactPerson' => "M. Riedaa Gamieldien",
      'originContactPhone'  => "89412116",
      'originContactEmail'  => "riedaa@monzamedia.com",
    ],

  // Client specific account information/credentials
    'shipmentDestination' => [
      'destinationStreetAddress' => "Incholm Place", // 'delivery_address_line_1',
      'destinationBusinessPark'  => "Unit 1, Gardens Business Village", // 'delivery_address_line_2',
      'destinationOtherAddress'  => NULL, // 'delivery_address_line_2',
      'destinationStateProvince' => "Western Cape", // 'delivery_province',
      'destinationCountryCode'   => "ZA", // 'delivery_country',
      'destinationCountryName'   => "South Africa", // 'delivery_country',
      'destinationSuburb'        => "Gardens", // 'delivery_suburb',
      'destinationPostalCode'    => "8001", // 'delivery_postal_code',
      'destinationContactName'   => "Monzamedia", // 'delivery_company',
      'destinationContactPerson' => "Riedaa Gamieldien", // 'delivery_name',
      'destinationContactPhone'  => "0739796455", // 'delivery_phone',
      'destinationContactEmail'  => "riedaa@monzamedia.com", // 'user.email',
      'destinationReferenceArr'  => 'Testing Parcel Perfect TCG API requestQuote', // 'id', // 
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
      'pickupDate'         => 'tomorrow',
      'pickupReadyTime'    => '14:00',
      'pickupOpeningTime'  => '11:00',
      'pickupClosingTime'  => '17:00',
      'pickupEntityStatus' => 'Ready'
    ],

  ];

<?php

return [

  'courier_tcg' => [

    'title' => 'The Courier Guy Shipping', 
    'page_id' => '34', 
    'icon' => 'fa fa-van', 

    'main_link_database_tables' => [

      'courier_tcgs' => [
        'title' => 'The Courier Guy Setup', 
        'icon' => 'fa fa-cogs', 
        'specific_id' => '', 

        'sub_database_tables' => [
          'courier_tcg_accounts', 
          'courier_tcg_addresses', 
          'courier_tcg_pickdetails', 
        ]

      ], 

    ], 

    'tab_database_tables' => [
      'courier_tcg_accounts', 
      'courier_tcg_addresses', 
      'courier_tcg_pickdetails', 
    ],
  ],

]['courier_tcg'];

@php
$bladePath = 'templates.checkout.ecommerce.checkout.step2._components.new_address.inputs';
$immutableInputArray = [
  'group1' => [
    'address_name',
    'first_name',
    'surname',
    'company',
    'vat_number',
    'phone',
  ],
  'group2' => [
    'street_address',
    '',
    'city_town',
    'state_province',
    'country',
    'postal_code',
  ],
];

if ( $config['external_courier_companies']['Aramex']['courier_enabled'] || $config['external_courier_companies']['TheCourierGuy']['courier_enabled'] ) {
  $immutableInputArray['group2'][1] = 'suburb';
} else {
  $immutableInputArray['group2'][1] = 'suburb_vanilla';
}

$honeypot_submit_input = 'honeypot_submit';
@endphp

<div class="add-address-overlay"></div>
<div class="add-address-form">

    <h1 style="font-size: 16px;">Add Address <a href="#">X</a></h1>
    
    {!! Form::open( ['url' => '/user/address/add', 'data-parsley-validate' => '', 'id' => 'add-address', 'autocapitalization' => 'off'] ) !!}

      @forelse( $immutableInputArray as $groupKey => $groupedItems )
      <div class="col-12 col-md-6">

        @forelse( $groupedItems as $key => $item )
          @include( $bladePath.".".$item )
        @empty
        @endforelse
  
      </div>
      @empty
      @endforelse

      @include( $bladePath . "." . $honeypot_submit_input )

    {!! Form::close() !!}

</div>

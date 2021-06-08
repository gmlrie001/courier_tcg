@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@push( 'pageStyles' )
<style id="payment-options-styling">
p, 
p * {
	line-height: 1.618 !important;
}
.user-address-select div i.fa {
	line-height: 40px !important;
}
.address-info h1 i.active, 
.user-address-select div i.fa.active {
  color: #1cbf01;
}
.payment-order-summary p, 
.payment-order-summary p * {
  font-size: 0.675rem !important;
  line-height: 1.618 !important;
}
.payment-order-summary p {
	line-height: 2 !important;
  margin-bottom: 0.309rem;
  margin-top: 0.309rem;
}
address.shipping-address, 
address.shipping-address p, 
address.shipping-address p *,
.shipping-method, 
.shipping-method p, 
.shipping-method p * {
  line-height: 1.618 !important;
}
</style>
@endpush

@php
  $countries = [
	"Åland Islands"=>"Åland Islands",
    "Afghanistan"=>"Afghanistan",
	"Albania"=>"Albania",
	"Algeria"=>"Algeria",
	"American Samoa"=>"American Samoa",
	"Andorra"=>"Andorra",
	"Angola"=>"Angola",
	"Anguilla"=>"Anguilla",
	"Antarctica"=>"Antarctica",
	"Antiguaand Barbuda"=>"Antiguaand Barbuda",
	"Argentina"=>"Argentina",
	"Armenia"=>"Armenia",
	"Aruba"=>"Aruba",
	"Australia"=>"Australia",
	"Austria"=>"Austria",
	"Azerbaijan"=>"Azerbaijan",
	"Bahamas"=>"Bahamas",
	"Bahrain"=>"Bahrain",
	"Bangladesh"=>"Bangladesh",
	"Barbados"=>"Barbados",
	"Belarus"=>"Belarus",
	"Belgium"=>"Belgium",
	"Belize"=>"Belize",
	"Benin"=>"Benin",
	"Bermuda"=>"Bermuda",
	"Bhutan"=>"Bhutan",
	"Bolivia"=>"Bolivia",
	"Bosniaand Herzegovina"=>"Bosniaand Herzegovina",
	"Botswana"=>"Botswana",
	"Bouvet Island"=>"Bouvet Island",
	"Brazil"=>"Brazil",
	"British Antarctic Territory"=>"British Antarctic Territory",
	"British Indian Ocean Territory"=>"British Indian Ocean Territory",
	"British Virgin Islands"=>"British Virgin Islands",
	"Brunei"=>"Brunei",
	"Bulgaria"=>"Bulgaria",
	"Burkina Faso"=>"Burkina Faso",
	"Burundi"=>"Burundi",
	"Cambodia"=>"Cambodia",
	"Cameroon"=>"Cameroon",
	"Canada"=>"Canada",
	"CantonandEnderburyIslands"=>"CantonandEnderburyIslands",
	"CapeVerde"=>"CapeVerde",
	"Cayman Islands"=>"Cayman Islands",
	"Central African Republic"=>"Central African Republic",
	"Chad"=>"Chad",
	"Chile"=>"Chile",
	"China"=>"China",
	"Christmas Island"=>"Christmas Island",
	"Cocos[Keeling] Islands"=>"Cocos[Keeling] Islands",
	"Colombia"=>"Colombia",
	"Comoros"=>"Comoros",
	"Congo-Brazzaville"=>"Congo-Brazzaville",
	"Congo-Kinshasa"=>"Congo-Kinshasa",
	"Cook Islands"=>"Cook Islands",
	"Costa Rica"=>"Costa Rica",
	"Croatia"=>"Croatia",
	"Cuba"=>"Cuba",
	"Cyprus"=>"Cyprus",
	"Czech Republic"=>"Czech Republic",
	"Côted’Ivoire"=>"Côted’Ivoire",
	"Denmark"=>"Denmark",
	"Djibouti"=>"Djibouti",
	"Dominica"=>"Dominica",
	"Dominican Republic"=>"Dominican Republic",
	"Dronning MaudLand"=>"Dronning MaudLand",
	"East Germany"=>"East Germany",
	"Ecuador"=>"Ecuador",
	"Egypt"=>"Egypt",
	"ElSalvador"=>"ElSalvador",
	"Equatorial Guinea"=>"Equatorial Guinea",
	"Eritrea"=>"Eritrea",
	"Estonia"=>"Estonia",
	"Ethiopia"=>"Ethiopia",
	"Falkland Islands"=>"Falkland Islands",
	"Faroe Islands"=>"Faroe Islands",
	"Fiji"=>"Fiji",
	"Finland"=>"Finland",
	"France"=>"France",
	"French Guiana"=>"French Guiana",
	"French Polynesia"=>"French Polynesia",
	"French Southern Territories"=>"French Southern Territories",
	"French Southern and Antarctic Territories"=>"French Southern and Antarctic Territories",
	"Gabon"=>"Gabon",
	"Gambia"=>"Gambia",
	"Georgia"=>"Georgia",
	"Germany"=>"Germany",
	"Ghana"=>"Ghana",
	"Gibraltar"=>"Gibraltar",
	"Greece"=>"Greece",
	"Greenland"=>"Greenland",
	"Grenada"=>"Grenada",
	"Guadeloupe"=>"Guadeloupe",
	"Guam"=>"Guam",
	"Guatemala"=>"Guatemala",
	"Guernsey"=>"Guernsey",
	"Guinea"=>"Guinea",
	"Guinea-Bissau"=>"Guinea-Bissau",
	"Guyana"=>"Guyana",
	"Haiti"=>"Haiti",
	"Heard Island and McDonald Islands"=>"Heard Island and McDonald Islands",
	"Honduras"=>"Honduras",
	"Hong Kong SAR China"=>"Hong Kong SAR China",
	"Hungary"=>"Hungary",
	"Iceland"=>"Iceland",
	"India"=>"India",
	"Indonesia"=>"Indonesia",
	"Iran"=>"Iran",
	"Iraq"=>"Iraq",
	"Ireland"=>"Ireland",
	"Isle of Man"=>"Isle of Man",
	"Israel"=>"Israel",
	"Italy"=>"Italy",
	"Jamaica"=>"Jamaica",
	"Japan"=>"Japan",
	"Jersey"=>"Jersey",
	"Johnston Island"=>"Johnston Island",
	"Jordan"=>"Jordan",
	"Kazakhstan"=>"Kazakhstan",
	"Kenya"=>"Kenya",
	"Kiribati"=>"Kiribati",
	"Kuwait"=>"Kuwait",
	"Kyrgyzstan"=>"Kyrgyzstan",
	"Laos"=>"Laos",
	"Latvia"=>"Latvia",
	"Lebanon"=>"Lebanon",
	"Lesotho"=>"Lesotho",
	"Liberia"=>"Liberia",
	"Libya"=>"Libya",
	"Liechtenstein"=>"Liechtenstein",
	"Lithuania"=>"Lithuania",
	"Luxembourg"=>"Luxembourg",
	"Macau SAR China"=>"Macau SAR China",
	"Macedonia"=>"Macedonia",
	"Madagascar"=>"Madagascar",
	"Malawi"=>"Malawi",
	"Malaysia"=>"Malaysia",
	"Maldives"=>"Maldives",
	"Mali"=>"Mali",
	"Malta"=>"Malta",
	"Marshall Islands"=>"Marshall Islands",
	"Martinique"=>"Martinique",
	"Mauritania"=>"Mauritania",
	"Mauritius"=>"Mauritius",
	"Mayotte"=>"Mayotte",
	"Metropolitan France"=>"Metropolitan France",
	"Mexico"=>"Mexico",
	"Micronesia"=>"Micronesia",
	"MidwayIslands"=>"MidwayIslands",
	"Moldova"=>"Moldova",
	"Monaco"=>"Monaco",
	"Mongolia"=>"Mongolia",
	"Montenegro"=>"Montenegro",
	"Montserrat"=>"Montserrat",
	"Morocco"=>"Morocco",
	"Mozambique"=>"Mozambique",
	"Myanmar[Burma]"=>"Myanmar[Burma]",
	"Namibia"=>"Namibia",
	"Nauru"=>"Nauru",
	"Nepal"=>"Nepal",
	"Netherlands"=>"Netherlands",
	"Netherlands Antilles"=>"Netherlands Antilles",
	"Neutral Zone"=>"Neutral Zone",
	"New Caledonia"=>"New Caledonia",
	"New Zealand"=>"New Zealand",
	"Nicaragua"=>"Nicaragua",
	"Niger"=>"Niger",
	"Nigeria"=>"Nigeria",
	"Niue"=>"Niue",
	"Norfolk Island"=>"Norfolk Island",
	"North Korea"=>"North Korea",
	"North Vietnam"=>"North Vietnam",
	"Northern Mariana Islands"=>"Northern Mariana Islands",
	"Norway"=>"Norway",
	"Oman"=>"Oman",
	"Pacific Islands Trust Territory"=>"Pacific Islands Trust Territory",
	"Pakistan"=>"Pakistan",
	"Palau"=>"Palau",
	"Palestinian Territories"=>"Palestinian Territories",
	"Panama"=>"Panama",
	"Panama Canal Zone"=>"Panama Canal Zone",
	"Papua New Guinea"=>"Papua New Guinea",
	"Paraguay"=>"Paraguay",
	"People's Democratic Republic of Yemen"=>"People's Democratic Republic of Yemen",
	"Peru"=>"Peru",
	"Philippines"=>"Philippines",
	"Pitcairn Islands"=>"Pitcairn Islands",
	"Poland"=>"Poland",
	"Portugal"=>"Portugal",
	"Puerto Rico"=>"Puerto Rico",
	"Qatar"=>"Qatar",
	"Romania"=>"Romania",
	"Russia"=>"Russia",
	"Rwanda"=>"Rwanda",
	"Réunion"=>"Réunion",
	"Saint Barthélemy"=>"Saint Barthélemy",
	"Saint Helena"=>"Saint Helena",
	"Saint Kitts and Nevis"=>"Saint Kitts and Nevis",
	"Saint Lucia"=>"Saint Lucia",
	"Saint Martin"=>"Saint Martin",
	"Saint Pierre and Miquelon"=>"Saint Pierre and Miquelon",
	"Saint Vincent and the Grenadines"=>"Saint Vincent and the Grenadines",
	"Samoa"=>"Samoa",
	"San Marino"=>"San Marino",
	"Saudi Arabia"=>"Saudi Arabia",
	"Senegal"=>"Senegal",
	"Serbia"=>"Serbia",
	"Serbia and Montenegro"=>"Serbia and Montenegro",
	"Seychelles"=>"Seychelles",
	"Sierra Leone"=>"Sierra Leone",
	"Singapore"=>"Singapore",
	"Slovakia"=>"Slovakia",
	"Slovenia"=>"Slovenia",
	"Solomon Islands"=>"Solomon Islands",
	"Somalia"=>"Somalia",
	"South Africa"=>"South Africa",
	"South Georgia and the South Sandwich Islands"=>"South Georgia and the South Sandwich Islands",
	"South Korea"=>"South Korea",
	"Spain"=>"Spain",
	"Sri Lanka"=>"Sri Lanka",
	"Sudan"=>"Sudan",
	"Suriname"=>"Suriname",
	"Svalbardand Jan Mayen"=>"Svalbardand Jan Mayen",
	"Swaziland"=>"Swaziland",
	"Sweden"=>"Sweden",
	"Switzerland"=>"Switzerland",
	"Syria"=>"Syria",
	"São Tomé and Príncipe"=>"São Tomé and Príncipe",
	"Taiwan"=>"Taiwan",
	"Tajikistan"=>"Tajikistan",
	"Tanzania"=>"Tanzania",
	"Thailand"=>"Thailand",
	"Timor-Leste"=>"Timor-Leste",
	"Togo"=>"Togo",
	"Tokelau"=>"Tokelau",
	"Tonga"=>"Tonga",
	"Trinidad and Tobago"=>"Trinidad and Tobago",
	"Tunisia"=>"Tunisia",
	"Turkey"=>"Turkey",
	"Turkmenistan"=>"Turkmenistan",
	"Turks and Caicos Islands"=>"Turks and Caicos Islands",
	"Tuvalu"=>"Tuvalu",
	"U.S. Minor Outlying Islands"=>"U.S. Minor Outlying Islands",
	"U.S. Miscellaneous Pacific Islands"=>"U.S. Miscellaneous Pacific Islands",
	"U.S. Virgin Islands"=>"U.S. Virgin Islands",
	"Uganda"=>"Uganda",
	"Ukraine"=>"Ukraine",
	"Union of Soviet Socialist Republics"=>"Union of Soviet Socialist Republics",
	"United Arab Emirates"=>"United Arab Emirates",
	"United Kingdom"=>"United Kingdom",
	"United States"=>"United States",
	"Unknown or Invalid Region"=>"Unknown or Invalid Region",
	"Uruguay"=>"Uruguay",
	"Uzbekistan"=>"Uzbekistan",
	"Vanuatu"=>"Vanuatu",
	"Vatican City"=>"Vatican City",
	"Venezuela"=>"Venezuela",
	"Vietnam"=>"Vietnam",
	"Wake Island"=>"Wake Island",
	"Wallis and Futuna"=>"Wallis and Futuna",
	"Western Sahara"=>"Western Sahara",
	"Yemen"=>"Yemen",
	"Zambia"=>"Zambia",
	"Zimbabwe"=>"Zimbabwe",
  ];
@endphp

@section('content')
<div class="container mt-5">
	<div class="row">
		<div class="col-12 col-lg-9 custom-checkout-padding">
				<div class="row">
						@include( 'templates.checkout.ecommerce.checkout.step2._components.navigation.checkout_nav' )

						@if( $user->addresses && count( $user->addresses ) > 0 )
								@include( 'templates.checkout.ecommerce.checkout.step2._components.address_rows.cart_addresses' )
						@else
								@include( 'template.checkout.ecommerce.checkout.step2._components.address_rows.add_address' )
						@endif
				</div>
		</div>

		<div class="col-12 col-lg-3 custom-checkout-padding">
			<div class="row">

        @php
          if ( isset( $cart ) && ! isset( $order ) ) {
            $order = $cart;
          } elseif ( isset( $order ) && ! isset( $cart ) ) {
            $cart  = $order;
          }

          $subTotal = $total_cost;
          $subTotal = $order->subtotal;

          // Number of Items in Cart
          if (($cart_products != null || isset($cart_products)) && count($cart_products) > 0) {
            $cart_total = (($cart_products != null || isset($cart_products)) && count($cart_products) > 0) 
                          ? $cart_products->sum('quantity') : 0;
          }

          // Deduction of DISCOUNTS
          if ( $discount == null || $discount == 0 ) {
            $discountTotal = 0;
          } else {
            $discountTotal = ( $discount_type == 0 ) ? $total_cost * ( $discount * 0.01 ) : $discount;
            $subTotal -= $discountTotal;
          }

          // Deduction of COUPON
          if ( $order->coupon == 0 || $order->coupon == null ) {
            $couponTotal = 0;
          } else {
            $couponTotal = ( $order->coupon_discount_type == 0 ) ? $subTotal * ( $order->coupon_discount * 0.01 ) : $order->coupon_discount;
            $subTotal -= $couponTotal;
          }

          // Deduction of STORE CREDIT
          if ( $order->store_credit_value == 0 || $order->store_credit_value == null ) {
            $creditTotal = 0;
          } else {
            $creditTotal = $order->store_credit_value;
            $subTotal -= $creditTotal;
          }

          // Addition of SHIPPING COST
          $shippingTotal = 0;
          $subTotal += $shippingTotal;
          // if ( $order->shipping_cost == 0 || $order->shipping_cost == null ) {
          //   $shippingTotal = 0;
          // } else {
          //   $shippingTotal = $order->shipping_cost;
          //   $subTotal += $shippingTotal;
          // }
        @endphp

        @include( 'templates.checkout.new_order_summary' )

				@if($order->coupon != null)
					<div class="col-12 applied-coupon">
						<a href="/remove/coupon/{{$order->id}}">
								{{$order->coupon}}
								<i class="fa fa-times"></i>
						</a>
					</div>
				@else
					@if(sizeof($available_coupons))
							<div class="col-12 available-coupons">
									<h2>Available Coupon Codes</h2>
									@foreach($available_coupons as $available_coupon)
											<a href="/apply/coupon/{{$available_coupon->id}}">
													{{$available_coupon->code}}
													<i class="fa fa-plus"></i>
											</a>
									@endforeach
							</div>
					@endif
					<form action="/apply/coupon/code" method="post" class="col-12 p-0 promo-form">
							{!!Form::token()!!}
							<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter Promo Code" name="code">
									<div class="input-group-append">
											<button type="submit">
													GO
											</button>
									</div>
							</div>
					</form>
				@endif
			</div>

			<div class="row continue-checkout-form">
				@php
					$user->load( 'addresses' );
					$defaultUserAddy = $user->addresses->where( 'default_address', 1 )->first();
					$defaultUserAddy = ( NULL == $defaultUserAddy ) ? $user_addresses->first() : $defaultUserAddy;
			                           // ?? $user_addresses[0]->id;
				@endphp

				@if(sizeof($user_addresses) && NULL != $defaultUserAddy )
					@php
						$shippingid = ( ! isset( $shippingid ) ) ? $defaultUserAddy->id : $shippingid;
						$billingid  =  ( ! isset( $billingid ) ) ? $defaultUserAddy->id :  $billingid;
					@endphp
				
					<form action="/cart/delivery/option" method="post" class="col-12 p-0">
						{!! Form::token() !!}
						{!! Form::hidden( 'cart_id', $cart_id ) !!}
						{!! Form::hidden( 'shipping_id', $shippingid )!!}
						{!! Form::hidden(  'billing_id',  $billingid ) !!}
						<input class="continue-button blue-background" type="submit" value="continue checkout"
								name="basketDelivery" />
					</form>
				
				@else
					<form action="/cart/delivery/option" method="post" class="col-12 p-0">
						{!! Form::token() !!}
						{!! Form::hidden( 'cart_id', $cart_id ) !!}
						{!! Form::hidden( 'shipping_id', $defaultUserAddy->id ?? 0 ) !!}
						{!! Form::hidden(  'billing_id', $defaultUserAddy->id ?? 0 ) !!}
						<input class="continue-button blue-background" type="submit" value="continue checkout"
								name="basketDelivery" disabled="" />
					</form>
				@endif
			</div>

		</div>
	</div>
</div>

@include( 'templates.checkout.ecommerce.checkout.step2._components.new_address.add' )

@if( env( 'APP_ENV' ) === 'production' )
  @include('templates.tab_open_check')
@endif

@endsection

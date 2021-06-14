@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@section('content')
<?php
	$countries = array("Afghanistan"=>"Afghanistan","Albania"=>"Albania","Algeria"=>"Algeria","American Samoa"=>"American Samoa","Andorra"=>"Andorra","Angola"=>"Angola","Anguilla"=>"Anguilla","Antarctica"=>"Antarctica","Antiguaand Barbuda"=>"Antiguaand Barbuda","Argentina"=>"Argentina","Armenia"=>"Armenia","Aruba"=>"Aruba","Australia"=>"Australia","Austria"=>"Austria","Azerbaijan"=>"Azerbaijan","Bahamas"=>"Bahamas","Bahrain"=>"Bahrain","Bangladesh"=>"Bangladesh","Barbados"=>"Barbados","Belarus"=>"Belarus","Belgium"=>"Belgium","Belize"=>"Belize","Benin"=>"Benin","Bermuda"=>"Bermuda","Bhutan"=>"Bhutan","Bolivia"=>"Bolivia","Bosniaand Herzegovina"=>"Bosniaand Herzegovina","Botswana"=>"Botswana","Bouvet Island"=>"Bouvet Island","Brazil"=>"Brazil","British Antarctic Territory"=>"British Antarctic Territory","British Indian Ocean Territory"=>"British Indian Ocean Territory","British Virgin Islands"=>"British Virgin Islands","Brunei"=>"Brunei","Bulgaria"=>"Bulgaria","Burkina Faso"=>"Burkina Faso","Burundi"=>"Burundi","Cambodia"=>"Cambodia","Cameroon"=>"Cameroon","Canada"=>"Canada","CantonandEnderburyIslands"=>"CantonandEnderburyIslands","CapeVerde"=>"CapeVerde","Cayman Islands"=>"Cayman Islands","Central African Republic"=>"Central African Republic","Chad"=>"Chad","Chile"=>"Chile","China"=>"China","Christmas Island"=>"Christmas Island","Cocos[Keeling] Islands"=>"Cocos[Keeling] Islands","Colombia"=>"Colombia","Comoros"=>"Comoros","Congo-Brazzaville"=>"Congo-Brazzaville","Congo-Kinshasa"=>"Congo-Kinshasa","Cook Islands"=>"Cook Islands","Costa Rica"=>"Costa Rica","Croatia"=>"Croatia","Cuba"=>"Cuba","Cyprus"=>"Cyprus","Czech Republic"=>"Czech Republic","Côted’Ivoire"=>"Côted’Ivoire","Denmark"=>"Denmark","Djibouti"=>"Djibouti","Dominica"=>"Dominica","Dominican Republic"=>"Dominican Republic","Dronning MaudLand"=>"Dronning MaudLand","East Germany"=>"East Germany","Ecuador"=>"Ecuador","Egypt"=>"Egypt","ElSalvador"=>"ElSalvador","Equatorial Guinea"=>"Equatorial Guinea","Eritrea"=>"Eritrea","Estonia"=>"Estonia","Ethiopia"=>"Ethiopia","Falkland Islands"=>"Falkland Islands","Faroe Islands"=>"Faroe Islands","Fiji"=>"Fiji","Finland"=>"Finland","France"=>"France","French Guiana"=>"French Guiana","French Polynesia"=>"French Polynesia","French Southern Territories"=>"French Southern Territories","French Southern and Antarctic Territories"=>"French Southern and Antarctic Territories","Gabon"=>"Gabon","Gambia"=>"Gambia","Georgia"=>"Georgia","Germany"=>"Germany","Ghana"=>"Ghana","Gibraltar"=>"Gibraltar","Greece"=>"Greece","Greenland"=>"Greenland","Grenada"=>"Grenada","Guadeloupe"=>"Guadeloupe","Guam"=>"Guam","Guatemala"=>"Guatemala","Guernsey"=>"Guernsey","Guinea"=>"Guinea","Guinea-Bissau"=>"Guinea-Bissau","Guyana"=>"Guyana","Haiti"=>"Haiti","Heard Island and McDonald Islands"=>"Heard Island and McDonald Islands","Honduras"=>"Honduras","Hong Kong SAR China"=>"Hong Kong SAR China","Hungary"=>"Hungary","Iceland"=>"Iceland","India"=>"India","Indonesia"=>"Indonesia","Iran"=>"Iran","Iraq"=>"Iraq","Ireland"=>"Ireland","Isle of Man"=>"Isle of Man","Israel"=>"Israel","Italy"=>"Italy","Jamaica"=>"Jamaica","Japan"=>"Japan","Jersey"=>"Jersey","Johnston Island"=>"Johnston Island","Jordan"=>"Jordan","Kazakhstan"=>"Kazakhstan","Kenya"=>"Kenya","Kiribati"=>"Kiribati","Kuwait"=>"Kuwait","Kyrgyzstan"=>"Kyrgyzstan","Laos"=>"Laos","Latvia"=>"Latvia","Lebanon"=>"Lebanon","Lesotho"=>"Lesotho","Liberia"=>"Liberia","Libya"=>"Libya","Liechtenstein"=>"Liechtenstein","Lithuania"=>"Lithuania","Luxembourg"=>"Luxembourg","Macau SAR China"=>"Macau SAR China","Macedonia"=>"Macedonia","Madagascar"=>"Madagascar","Malawi"=>"Malawi","Malaysia"=>"Malaysia","Maldives"=>"Maldives","Mali"=>"Mali","Malta"=>"Malta","Marshall Islands"=>"Marshall Islands","Martinique"=>"Martinique","Mauritania"=>"Mauritania","Mauritius"=>"Mauritius","Mayotte"=>"Mayotte","Metropolitan France"=>"Metropolitan France","Mexico"=>"Mexico","Micronesia"=>"Micronesia","MidwayIslands"=>"MidwayIslands","Moldova"=>"Moldova","Monaco"=>"Monaco","Mongolia"=>"Mongolia","Montenegro"=>"Montenegro","Montserrat"=>"Montserrat","Morocco"=>"Morocco","Mozambique"=>"Mozambique","Myanmar[Burma]"=>"Myanmar[Burma]","Namibia"=>"Namibia","Nauru"=>"Nauru","Nepal"=>"Nepal","Netherlands"=>"Netherlands","Netherlands Antilles"=>"Netherlands Antilles","Neutral Zone"=>"Neutral Zone","New Caledonia"=>"New Caledonia","New Zealand"=>"New Zealand","Nicaragua"=>"Nicaragua","Niger"=>"Niger","Nigeria"=>"Nigeria","Niue"=>"Niue","Norfolk Island"=>"Norfolk Island","North Korea"=>"North Korea","North Vietnam"=>"North Vietnam","Northern Mariana Islands"=>"Northern Mariana Islands","Norway"=>"Norway","Oman"=>"Oman","Pacific Islands Trust Territory"=>"Pacific Islands Trust Territory","Pakistan"=>"Pakistan","Palau"=>"Palau","Palestinian Territories"=>"Palestinian Territories","Panama"=>"Panama","Panama Canal Zone"=>"Panama Canal Zone","Papua New Guinea"=>"Papua New Guinea","Paraguay"=>"Paraguay","People's Democratic Republic of Yemen"=>"People's Democratic Republic of Yemen","Peru"=>"Peru","Philippines"=>"Philippines","Pitcairn Islands"=>"Pitcairn Islands","Poland"=>"Poland","Portugal"=>"Portugal","Puerto Rico"=>"Puerto Rico","Qatar"=>"Qatar","Romania"=>"Romania","Russia"=>"Russia","Rwanda"=>"Rwanda","Réunion"=>"Réunion","Saint Barthélemy"=>"Saint Barthélemy","Saint Helena"=>"Saint Helena","Saint Kitts and Nevis"=>"Saint Kitts and Nevis","Saint Lucia"=>"Saint Lucia","Saint Martin"=>"Saint Martin","Saint Pierre and Miquelon"=>"Saint Pierre and Miquelon","Saint Vincent and the Grenadines"=>"Saint Vincent and the Grenadines","Samoa"=>"Samoa","San Marino"=>"San Marino","Saudi Arabia"=>"Saudi Arabia","Senegal"=>"Senegal","Serbia"=>"Serbia","Serbia and Montenegro"=>"Serbia and Montenegro","Seychelles"=>"Seychelles","Sierra Leone"=>"Sierra Leone","Singapore"=>"Singapore","Slovakia"=>"Slovakia","Slovenia"=>"Slovenia","Solomon Islands"=>"Solomon Islands","Somalia"=>"Somalia","South Africa"=>"South Africa","South Georgia and the South Sandwich Islands"=>"South Georgia and the South Sandwich Islands","South Korea"=>"South Korea","Spain"=>"Spain","Sri Lanka"=>"Sri Lanka","Sudan"=>"Sudan","Suriname"=>"Suriname","Svalbardand Jan Mayen"=>"Svalbardand Jan Mayen","Swaziland"=>"Swaziland","Sweden"=>"Sweden","Switzerland"=>"Switzerland","Syria"=>"Syria","São Tomé and Príncipe"=>"São Tomé and Príncipe","Taiwan"=>"Taiwan","Tajikistan"=>"Tajikistan","Tanzania"=>"Tanzania","Thailand"=>"Thailand","Timor-Leste"=>"Timor-Leste","Togo"=>"Togo","Tokelau"=>"Tokelau","Tonga"=>"Tonga","Trinidad and Tobago"=>"Trinidad and Tobago","Tunisia"=>"Tunisia","Turkey"=>"Turkey","Turkmenistan"=>"Turkmenistan","Turks and Caicos Islands"=>"Turks and Caicos Islands","Tuvalu"=>"Tuvalu","U.S. Minor Outlying Islands"=>"U.S. Minor Outlying Islands","U.S. Miscellaneous Pacific Islands"=>"U.S. Miscellaneous Pacific Islands","U.S. Virgin Islands"=>"U.S. Virgin Islands","Uganda"=>"Uganda","Ukraine"=>"Ukraine","Union of Soviet Socialist Republics"=>"Union of Soviet Socialist Republics","United Arab Emirates"=>"United Arab Emirates","United Kingdom"=>"United Kingdom","United States"=>"United States","Unknown or Invalid Region"=>"Unknown or Invalid Region","Uruguay"=>"Uruguay","Uzbekistan"=>"Uzbekistan","Vanuatu"=>"Vanuatu","Vatican City"=>"Vatican City","Venezuela"=>"Venezuela","Vietnam"=>"Vietnam","Wake Island"=>"Wake Island","Wallis and Futuna"=>"Wallis and Futuna","Western Sahara"=>"Western Sahara","Yemen"=>"Yemen","Zambia"=>"Zambia","Zimbabwe"=>"Zimbabwe","Åland Islands"=>"Åland Islands",);
?>
<div class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-9 custom-checkout-padding">
            <div class="row">
                <div class="col-12 text-center-sm">
                    <div class="row">
                        <a class="arrow col-3 completed" href="/cart/view">
                            <div><span><i class="fa fa-check" aria-hidden="true"></i></span>Order Summary</div>
                        </a>
                        <div class="arrow col-3 active">
                            <div><span>2</span>Shipping Info</div>
                        </div>
                        <div class="arrow col-3">
                            <div><span>3</span>Shipping Method</div>
                        </div>
                        <div class="arrow col-3">
                            <div><span>4</span>Payment</div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="col-12 text-center d-block d-md-none">Shipping Info</h3>
                    </div>
                </div>
                <div class="col-12 cart-addresses">
                    <div class="row">
                        <div class="col-12 p-0 user-address-select">
                            <h1>Select Shipping Address</h1>
                            <span>Billing Address the same as my shipping address <i class="fa fa-check-circle active" aria-hidden="true"></i></span>
                        </div>
                        <div class="col-12 user-addresses shipping-addresses">
                            <div class="row">
                                @foreach($user_addresses as $user_address)
                                    <div class="col-12 p-0 address-info" data-addressid="{{$user_address->id}}">
                                        <h1 class="col-12">
                                            <a class="delete-address float-left confirm-delete" href="/address/delete/{{$user_address->id}}"><i class="fa fa-trash"></i></a>
                                            {{$user_address->address_name}}
                                            @if($user_address->default_address == 1)
                                                <?php $shippingid = $user_address->id; ?>
                                                <i class="fa fa-check-circle active" aria-hidden="true"></i>
                                            @else
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            @endif
                                            <span>Use this address</span>
                                        </h1>
                                        <div class="col-12">
                                            <div class="col-12 col-md-6 float-left">
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">First Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->name}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Company Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->company}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">VAT Number:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->vat_number}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Surburb:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->suburb}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Province / State:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->province}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Postal Code:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->postal_code}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 float-left">
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Last Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->surname}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Street Address:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->address_line_1}}, {{$user_address->address_line_2}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">City / Town:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->city}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Country:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->country}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Phone Number:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->phone}}</p>
                                                    </div>
                                                </div>
                                                <span class="col-12 text-right">May be printed on the label to assist delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 p-0 user-address-select billing-hide">
                            <h1>Select Billing Address</h1>
                        </div>
                        <div class="col-12 p-0 user-addresses billing-addresses billing-hide">
                                @foreach($user_addresses as $user_address)
                                    <div class="col-12 p-0 address-info" data-addressid="{{$user_address->id}}">
                                        <h1>
                                            <a class="delete-address float-left confirm-delete" href="/address/delete/{{$user_address->id}}"><i class="fa fa-trash"></i></a>
                                            {{$user_address->address_name}}
                                            @if($user_address->default_address == 1)
                                                <?php $billingid = $user_address->id; ?>
                                                <i class="fa fa-check-circle active" aria-hidden="true"></i>
                                            @else
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            @endif
                                            <span>Use this address</span>
                                        </h1>
                                        <div class="col-12">
                                            <div class="col-12 col-md-6 float-left">
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">First Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->name}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Company Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->company}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">VAT Number:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->vat_number}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Surburb:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->suburb}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Province / State:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->province}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Postal Code:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->postal_code}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 float-left">
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Last Name:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->surname}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Street Address:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->address_line_1}}, {{$user_address->address_line_2}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">City / Town:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->city}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Country:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->country}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="row">
                                                        <p class="col-12 col-md-6">Phone Number:</p>
                                                        <p class="col-12 col-md-6">{{$user_address->phone}}</p>
                                                    </div>
                                                </div>
                                                <span class="col-12 text-right">May be printed on the label to assist delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0 add-address">
                    <a href="#">Add address</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 custom-checkout-padding">
            <div class="row">
                <div class="col-12 payment-order-summary pre-payment">
                    <h2>Order Summary:</h2>
                    @php 
                        $subTotal = $total_cost;

                        if($discount == 0){
                            $discountTotal = 0;
                        }else{
                            if($discount_type == 0){
                                $discountTotal = $total_cost*($discount/100);
                            }else{
                                $discountTotal = $discount;
                            }
                            $subTotal = $subTotal - $discountTotal;
                        }
                        
                        if($cart->coupon == null){
                            $couponTotal = 0;
                        }else{
                            if($cart->coupon_discount_type == 0){
                                $couponTotal = $subTotal*($cart->coupon_discount/100);
                            }else{
                                $couponTotal = $cart->coupon_discount;
                            }
                            $subTotal = $subTotal - $couponTotal;
                        }
                        
                        if($cart->store_credit_value == null){
                            $creditTotal = 0;
                        }else{
                            $creditTotal = $cart->store_credit_value;
                            $subTotal = $subTotal - $creditTotal;
                        }
                    @endphp
                    <p class="text-right"><span>Cost:</span> R {{number_format($total_cost, 0, "", "")}}</p>
                    @if($discountTotal != 0)
                        <p class="text-right"><span>Discount:</span> -R {{number_format($discountTotal, 0, "", "")}}</p>
                    @endif
                    @if($couponTotal != 0)
                        <p class="text-right"><span>Coupon:</span> -R {{number_format($couponTotal, 0, "", "")}}</p>
                    @endif
                    @if($creditTotal != 0)
                        <p class="text-right"><span>Store Credit:</span> -R {{number_format($creditTotal, 0, "", "")}}</p>
                    @endif
                    <h3 class="text-right"><span>Total</span> R {{number_format($subTotal, 0, "", "")}}</h3>
                       
                    <h4>Items in Basket: <span class="float-right">{{$cart_total}}</span></h4>
                </div>
                @if($cart->coupon != null)
                    <div class="col-12 applied-coupon">
                        <a href="/remove/coupon/{{$cart->id}}">
                            {{$cart->coupon}}
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
                @if($user != null)
                @php
                    $walletTotal = 0;
                    foreach($user->creditItems as $creditItem){
                        if($creditItem->credit_debit == 'credit'){
                            $walletTotal += $creditItem->amount;
                        }else{
                            $walletTotal -= $creditItem->amount;
                        }
                    }
                @endphp
                @if($walletTotal > 0)
                    <div class="col-12 available-coupons">
                        <h2>Use Store Credit?</h2>
                    </div>
                    <div class="col-12 store-credit">
                        <span>R 0</span>
                        <div id="slider"></div>
                        <span class="text-right">R {{number_format($walletTotal, 0, "", "")}}</span>
                        <i class="store-credit-value">Value: R {{number_format($creditTotal, 0, "", "")}}</i>
                    </div>
                    <div class="col-12 apply-store-credit">
                        <span>APPLY</span>
                    </div>
                    <input type="text" name="store-credit-input" style="display:none;" id="amount" value="0">
                    <script>
                        $( function() {
                        $( "#slider" ).slider({
                            range: "max",
                            min: 0,
                            step: 1, 
                            max: {{number_format($walletTotal, 0, "", "")}},
                            value: {{number_format($creditTotal, 0, "", "")}},
                            slide: function( event, ui ) {
                            $( "#amount" ).val( ui.value );
                            $( ".store-credit-value" ).text('Value: R '+ ui.value );
                            }
                        });
                        } );

                        $(".apply-store-credit span").click(function(){
                            window.location.replace("/store/credit/"+$( "#amount" ).val());
                        });
                    </script>
                @endif
            @endif
        </div>
               <div class="row">
                    @if(sizeof($user_addresses))
                        @php
                            if(!isset($shippingid)){
                            $shippingid = $user_addresses[0]->id;
                            }
                            if(!isset($billingid)){
                            $billingid = $user_addresses[0]->id;
                            }
                        @endphp
                        <form action="/cart/delivery/option" method="post" class="col-12 p-0">
                            {!!Form::token()!!}
                            {!!Form::hidden('cart_id', $cart_id)!!}
                            {!!Form::hidden('shipping_id', $shippingid)!!}
                            {!!Form::hidden('billing_id', $billingid)!!}
                            <input class="continue-button" type="submit" value="continue" name="basketDelivery" />
                        </form>
                    @else
                        <form action="/cart/delivery/option" method="post" class="col-12 p-0">
                            {!!Form::token()!!}
                            {!!Form::hidden('cart_id', $cart_id)!!}
                            {!!Form::hidden('shipping_id', 0)!!}
                            {!!Form::hidden('billing_id', 0)!!}
                            <input class="continue-button" type="submit" value="continue" name="basketDelivery" disabled="" />
                        </form>
                    @endif
               </div>
            </div>
        </div>
    </div>
</div>
<div class="add-address-overlay"></div>
<div class="add-address-form">
        <h1 style="font-size: 16px;">Add Address <a href="#">X</a></h1>
        {!! Form::open(array('url' => '/user/address/add', 'data-parsley-validate' => '')) !!}
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="col-12">Address Name*</label>
                    <input name="address_name" placeholder='eg. "Home" or "Work" etc' class="col-12" required="" />
                </div>
                <div class="form-group">
                    <label class="col-12">First Name*</label>
                    <input name="name" placeholder="First Name" class="col-12" required="" />
                </div>
                <div class="form-group">
                    <label class="col-12">Last Name*</label>
                    <input name="surname" placeholder="Last Name" class="col-12" required="" />
                </div>
                <div class="form-group">
                    <label class="col-12">Company</label>
                    <input name="company" placeholder="Company" class="col-12"  />
                </div>
                <div class="form-group">
                    <label class="col-12">VAT Number</label>
                    <input name="vat_number" placeholder="VAT Number" class="col-12"  />
                </div>
                <div class="form-group">
                    <label class="col-12">Phone Number*</label>
                    <input name="phone" placeholder="eg. 0832688122" class="col-12" required=""
                    data-parsley-required="true" 
                    data-parsley-length="[10, 10]"
                    />
                </div>
                <div class="form-group">
                    <label class="col-12">Confirm Phone Number*</label>
                    <input name="phone_confirmation" placeholder="eg. 0832688122" class="col-12" required=""
                    data-parsley-required="true" 
                    data-parsley-length="[10, 10]"
                    />
                    <p class="col-12">May be printed on the label to assist delivery</p>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="col-12">Street Address*</label>
                    <input name="address_line_1" placeholder="Street Address Line 1" class="col-12" required="" />
                    <input name="address_line_2" placeholder="Street Address Line 2" class="col-12" />
                </div>
                <div class="form-group">
                    <label class="col-12">Suburb*</label>
                    <input name="suburb" placeholder="Suburb" class="col-12" required="" />
                </div>
                <div class="form-group">
                    <label class="col-12">City/Town*</label>
                    <input name="city" placeholder="City/Town" class="col-12" required="" />
                </div>
                <div class="form-group">
                    <label class="col-12">Province*</label>
                    {!! Form::select('province', ['Eastern Cape' => 'Eastern Cape', 'Free State' => 'Free State', 'Gauteng' => 'Gauteng', 'Kwa-Zulu Natal' => 'Kwa-Zulu Natal', 'Limpopo' => 'Limpopo', 'Mpumalanga' => 'Mpumalanga', 'Northern Cape' => 'Northern Cape', 'North West' => 'North West', 'Western Cape' => 'Western Cape'], null, array('placeholder' => 'Province',  'class' => 'col-xs-12', 'required' => '')) !!}
                </div>
                <div class="form-group">
                    <label class="col-12">Country*</label>
                    {!! Form::text('country', "South Africa", array('placeholder' => 'Country',  'class' => 'col-xs-12', 'required' => '', 'readonly'=>'')) !!}
                </div>
                <div class="form-group">
                    <label class="col-12">Postal Code*</label>
                    <input name="postal_code" placeholder="Postal Code" class="col-12" required="" />
                </div>
            </div>
            <div class="col-12 full-width">
                {!! Honeypot::generate('my_name', 'my_time') !!}
                {!! Form::button('Save changes', array('type' => 'submit')) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection



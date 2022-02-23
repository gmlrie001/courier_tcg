@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@section('content')
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
        $subTotal = $subTotal - $couponTotal + $cart->shipping_cost;
    }
    
    if($cart->store_credit_value == null){
        $creditTotal = 0;
    }else{
        $creditTotal = $cart->store_credit_value;
        $subTotal = $subTotal - $creditTotal;
    }
@endphp
<div class="container mt-3">
		<div class="row">
			<div class="col-12 col-lg-9 custom-checkout-padding">
				<div class="row">
                    <div class="col-12 padding-0 text-center-sm">
                        <div class="row">
                            <a class="arrow col-3 completed" href="/cart/view">
                                <div><span><i class="fa fa-check" aria-hidden="true"></i></span>Order Summary</div>
                            </a>
                            <a class="arrow col-3 completed" href="/cart/delivery">
                                <div><span><i class="fa fa-check" aria-hidden="true"></i></span>Shipping Info</div>
                            </a>
                            <a class="arrow col-3 completed" href="/cart/delivery/option">
                                <div><span><i class="fa fa-check" aria-hidden="true"></i></span>Shipping Method</div>
                            </a>
                            <div class="arrow col-3 active">
                                <div><span>4</span>Payment</div>
                            </div>
                        </div>
                        <div class="row">
                            <h3 class="col-12 text-center d-block d-md-none">Payment Method</h3>
                        </div>
                    </div>
                    <div class="col-12 padding-0 payment-options" data-equalizer>
                        <div class="row">
                            <h1>Select Payment Method</h1>
                        </div>
                        <div class="row">
                            @if($cart->total-$creditTotal-$couponTotal != 0)
                            <div class="col-12 payment-option-block">
                                    <h2 class="">
                                        <i class="fa fa-circle-o"></i>
                                        Payfast
                                        <div class="payment-image-block">
                                            <img class="img-fluid" src="/assets/images/template/payfast.png" />
                                        </div>
                                    </h2>
                                    <div class="payment-info-block row">
                                    <script language="JavaScript" type="text/javascript">

                                        function click_e898b393aeca7cf12731a076d8f7ed8f( aform_reference ) {
                            
                                                var aform = aform_reference;
                            
                                                aform['amount'].value = Math.round( aform['amount'].value*Math.pow( 10,2 ) )/Math.pow( 10,2 );
                            
                                                    aform['custom_quantity'].value = aform['custom_quantity'].value.replace( /^\s+|\s+$/g,"" );
                            
                                                    if( !aform['custom_quantity'].value || 0 === aform['custom_quantity'].value.length || /^\s*$/.test( aform['custom_quantity'].value ) ) {
                            
                                                        alert ( 'A quantity is required' );
                            
                                                        return false;
                            
                                                    }aform['amount'].value *=  parseInt( aform['custom_quantity'].value );
                            
                                        }
                            
                                        </script>
                                        <form action="https://www.payfast.co.za/eng/process" name="form_e898b393aeca7cf12731a076d8f7ed8f" onsubmit="return click_e898b393aeca7cf12731a076d8f7ed8f( this );" method="post">

                                            <input type="hidden" name="cmd" value="_paynow">
                                
                                            <input type="hidden" name="receiver" value="daniel@kantorinc.co.za">
                                
                                            <input type="hidden" name="item_name" value="Order ID: {{$cart->id}}">
                                
                                            <input type="hidden" name="amount" value="{{$subTotal}}">
                                
                                            <input type="hidden" name="item_description" value="">
                                
                                            <input type="hidden" name="return_url" value="{{url('/')}}/success">
                                
                                            <input type="hidden" name="cancel_url" value="{{url('/')}}/error">
                                
                                
                                
                                            <input type="submit" value="Pay with Payfast" />
                                            </form>
                                    </div>
                                </div>
                                @else
                                <div class="col-12 payment-option-block">
                                    <h2 class="">
                                        <i class="fa fa-circle-o"></i>
                                        Store Credit
                                    </h2>
                                    <div class="payment-info-block row">
                                        <div class="payment-info-form col-12 col-md-10">
                                        <p>Use this option to pay for your order by using your Store Credit.</p>
                                        </div>
                                        <form action="/success" method="GET">
                                            {!! Form::token() !!}
                                            {!! Form::hidden('orderId', $cart->id) !!}
                                            <input type="submit" value="Pay via Store Credit" />
                                        </form>
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
                @if($can_assemble && sizeof($cart->assemblyProducts))
                    <div class="row">
                        <div class="col-12">
                            <h1>NEED ANY OF YOUR ITEMS ASSEMBLED FOR YOU?</h1>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @foreach($cart->assemblyProducts as $product)
                                    @include('includes.pages.products.assembly_block', ['product' => $product])
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
			</div>
			<div class="col-12 col-lg-3 custom-checkout-padding">
				<div class="row">
                    <div class="col-12 payment-order-summary">
                        <h2>Order Summary:</h2>
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
                        <p class="text-right"><span>Shipping Cost:</span> R {{number_format($cart->shipping_cost, 0, "", "")}}</p>
                        <h3 class="text-right"><span>Total</span> R {{number_format($cart->total-$creditTotal-$couponTotal, 0, "", "")}}</h3>
                        
                        <h4>Items in Basket: <span class="float-right">{{$cart_total}}</span></h4>
                        <h4>Shipping Info:</h4>
                        <p>
                            {{$cart->delivery_address_line_1}}, <br>
                            @if($cart->delivery_address_line_2 != "")
                                {{$cart->delivery_address_line_2}}, <br>
                            @endif
                            {{$cart->delivery_suburb}}, <br>
                            {{$cart->delivery_city}}, <br>
                            {{$cart->delivery_postal_code}}, <br>
                            {{$cart->delivery_province}}, <br>
                            {{$cart->delivery_country}}
                        </p>
                        <h4>Shipping Method:</h4>
                        <p>
                            {{$cart->shipping_description}} - {{$cart->shipping_title}}: <br>
                            {{$cart->shipping_time_of_arrival}}
                        </p>
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
			</div>
		</div>
	</div>
@endsection
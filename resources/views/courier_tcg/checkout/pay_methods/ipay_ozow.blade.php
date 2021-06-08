@extends('templates.layouts.index')
@section( 'title', $site_settings->site_name . ' | ' . $page->title )
@section('content')
@php
    /**/
    if( ($cart_products != NULL || isset( $cart_products )) && count( $cart_products ) > 0 ):
	$cart_total = $cart_products->sum( 'quantity' );
    endif;
    /**/
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
    $subTotal += ( NULL != $cart->shipping_cost ) ? $cart->shipping_cost : 0;
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
                            <h1 class="mb-lg-3 mb-2">Select Payment Method</h1>
                        </div>
                        <div class="row">
                            @if($cart->total-$creditTotal-$couponTotal != 0)
                                <!-- PAYFAST -->
                                <div class="col-12 payment-option-block mb-3">
                                    <h2 class="mb-lg-3 mb-2 active">
                                        <i class="fa fa-check-circle"></i>
                                        Payfast
                                        <div class="payment-image-block">
                                            @foreach($pay_options AS $option)
                                                @if($option->title == 'payfast')
                                                    <img class="img-fluid" src="/{{ $option->link_image }}" />
                                                @endif
                                            @endforeach
                                        </div>
                                    </h2>
                                    <div class="payment-info-block row">
				    {{-- SANDBOX Mode --}}
				    {{--
                                        <form action="https://sandbox.payfast.co.za/eng/process" method="POST">
                                            <input type="hidden" name="merchant_id" value="10000100">
                                            <input type="hidden" name="merchant_key" value="46f0cd694581a">
                                            <input type="hidden" name="item_name" value="Order ID: {{ $cart->id }}">
                                            <input type="hidden" name="amount" value="{{ $cart->total }}">
                                            <input type="hidden" name="item_description" value="">
                                            <input type="hidden" name="return_url" value="{{url('/')}}/success">
                                            <input type="hidden" name="cancel_url" value="{{url('/')}}/error">
                                            <input type="submit" value="Pay with Payfast" />
                                        </form>
				     --}}
				    {{-- LIVE Mode --}}
				       <script language="JavaScript" type="text/javascript">
					 function click_a7275aa3b7abd9c3f49f369ad392987f( aform_reference ) {
					   var aform = aform_reference;
					   aform['amount'].value = Math.round( aform['amount'].value*Math.pow( 10,2 ) )/Math.pow( 10,2 );
					 }
				       </script>
				      <form action="https://www.payfast.co.za/eng/process" name="form_a7275aa3b7abd9c3f49f369ad392987f" onsubmit="return click_a7275aa3b7abd9c3f49f369ad392987f( this );" method="post">
					  <input type="hidden" name="cmd" value="_paynow">
					  <input type="hidden" name="receiver" value="15514262">
					  <input type="hidden" name="merchant_key" value="5gajd08znxwe4">
					  <input type="hidden" name="payment_method" value=""> 
					  <input type="hidden" name="item_name" value="OrderID-{{ $cart->id }}">
					  <input type="hidden" name="amount" value="{{ $subTotal }}">
					  <input type="hidden" name="item_description" value="InGoodHealth Online Purchase: OrderID-{{ $cart->id }}">
					  <input type="hidden" name="return_url" value="{{ url( 'success' ) }}">
					  <input type="hidden" name="cancel_url" value="{{ url( 'error' ) }}">
					  <table>
					    <tr>
					      <td colspan="2" align="center">
						<input type="image" src="https://www.payfast.co.za/images/buttons/light-small-paynow.png" width="165" height="36" alt="Pay Now" title="Pay Now with PayFast">
					      </td>
					    </tr>
					  </table>
				      </form>
				  </div>
                                </div>
                                <!-- Ozow Instant EFT -->
                                @if( !empty($config['ozow_payment_option']['enable']) )
                                    <div class="col-12 payment-option-block mb-3">
                                        <h2 class="mb-lg-3 mb-2">
                                            <i class="fa fa-circle"></i>
                                            Ozow Instant EFT
                                            <div class="payment-image-block">
                                                <img class="img-fluid" src="/assets/images/template/ipay.jpg" />
                                            </div>
                                        </h2>
                                        <div class="payment-info-block row">
                                            <div class="payment-info-form col-12 col-md-10">
                                                <p>Ozow is an instant payment solution that facilitates online EFT payments across South Africa’s major banks, including ABSA, Capitec, FNB, Investec, Nedbank, and Standard Bank.</p>
                                                <p><strong>HOW DOES IT WORK?</strong></p>
                                                <ul>
                                                  <li>Click on “Ozow Instant EFT” to start the payment process.</li>
                                                  <li>Select your bank and log in using your internet banking credentials.</li>
                                                  <li>Select an account to pay from, and your order number will be automatically added as your reference.</li>
                                                  <li>Your bank will send you an OTP (One Time Pin) or mobile authentication message to verify the payment.</li>
                                                  <li>Enter the OTP or accept the authentication message to complete the payment.</li>
                                                </ul>
                                                <p>Once the payment is complete, we’ll send you an email confirming your order and direct you to the Order confirmation page.<br> No further action is required from your side!<br> Capitec users: Note that there’s a transaction limit of R14000 per order.</p>
                                                <p>By clicking "Pay via iPay" you confirm you have read and accept our <a href="{{ url('terms-conditions') }}" target="_blank">T&Cs</a></p>

                                            </div>
                                            @php
                                                $hash = hash("SHA512", strtolower($config['ozow_payment_option']['SITE_CODE'].$config['ozow_payment_option']['COUNTRY_CODE'].$config['ozow_payment_option']['CURRENCY_CODE'].$subTotal."AO-".$cart->id."AO-".$cart->id.url("/")."/error".url("/")."/ipay?orderId=".$cart->id."false".$config['ozow_payment_option']['SECRET_KEY']));
                                            @endphp
                                            <a target="_self" class="payment-button" href="https://pay.ozow.com?SiteCode=AFR-AFR-016&CountryCode=ZA&CurrencyCode=ZAR&Amount={{$subTotal}}&TransactionReference=AO-{{$cart->id}}&BankReference=AO-{{$cart->id}}&IsTest=false&HashCheck={{$hash}}&SuccessUrl={{url("/")."/ipay?orderId=".$cart->id}}&ErrorUrl={{url("/")."/error"}}">Pay via OZOW</a>
                                        </div>
                                    </div>
                                @endif
                                <!-- EFT -->
                                @if( !empty($config['eft_payment_option']['enable']) )
                                  <div class="col-12 payment-option-block mb-3" >
                                      <h2 class="mb-lg-3 mb-2">
                                          <i class="fa fa-circle"></i>
                                          EFT
                                          <div class="payment-image-block">
                                              @foreach($pay_options AS $option)
                                                  @if($option->title == 'eft')
                                                      <img class="img-fluid" src="/{{ $option->link_image }}" />
                                                  @endif
                                              @endforeach
                                          </div>
                                      </h2>
                                      <div class="payment-info-block row">
                                          <div class="payment-info-form col-12 col-md-10">
                                              {!! $site_settings->eft_info !!}
                                          </div>
                                          <form action="{{ url('eft') }}">
                                              {!! Form::token() !!}
                                              {!! Form::hidden('orderId', $cart->id) !!}
                                              <input type="submit" value="Pay via EFT" />
                                          </form>
                                      </div>
                                  </div>
                              @endif
                            @else
                              <div class="col-12 payment-option-block mb-3">
                                  <h2 class="mb-lg-3 mb-2">
                                      <i class="fa fa-circle"></i>
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
                        <p class="text-right"><span>Cost:</span> R {{ number_format($total_cost, 2, '.', ',') }}</p>
                        @if($discountTotal != 0)
                            <p class="text-right"><span>Discount:</span> -R {{ number_format($discountTotal, 2, '.', ',') }}</p>
                        @endif
                        @if($couponTotal != 0)
                            <p class="text-right"><span>Coupon:</span> -R {{ number_format($couponTotal, 2, '.', ',') }}</p>
                        @endif
                        @if($creditTotal != 0)
                            <p class="text-right"><span>Store Credit:</span> -R {{ number_format($creditTotal, 2, '.', ',') }}</p>
                        @endif
                        <p class="text-right"><span>Shipping Cost:</span> R  {{ number_format($cart->shipping_cost, 2, '.', ',') }}</p>
                        <h3 class="text-right"><span>Total</span> R {{ number_format($cart->total, 2, '.', ',') }}</h3>
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
                            @include('templates.checkout.use_store_credit')
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
    @include('templates.tab_open_check')
@endsection

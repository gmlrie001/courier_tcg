@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@push( 'pageStyles' )
<style id="payment-options-styling">
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
  }

  // Deduction of COUPON
  if ( $order->coupon == 0 || $order->coupon == null ) {
    $couponTotal = 0;
  } else {
    $couponTotal = ( $order->coupon_discount_type == 0 ) ? $subTotal * ( $order->coupon_discount * 0.01 ) : $order->coupon_discount;
  }

  // Addition of SHIPPING COST
  if ( $order->shipping_cost == 0 || $order->shipping_cost == null ) {
    $shippingTotal = 0;
  } else {
    $shippingTotal = $order->shipping_cost;
  }

  // Deduction of STORE CREDIT
  $storeCreditUpdate = (object) StoreCredit::getUsersStoreCredits( auth()->user() );
  $walletMaxTotal = $storeCreditUpdate->walletMaxTotal;

  if ( $order->store_credit_value == 0 || $order->store_credit_value == null ) {
    $creditTotal = $walletMaxTotal;
  } else {
    $creditTotal = $order->store_credit_value;
  }

  $subTotal -= ( $creditTotal + $couponTotal + $discountTotal );
  $subTotal += $shippingTotal;

  $cart->calculateOrderTotal();
  $subTotal = $cart->total;
@endphp

@section('content')
<div class="container mt-5">
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
                    @php
                      $pay_options = ( new $config['payment_options']['model'] )
                        ->where('status', 'PUBLISHED')->orWhere('status', 'SCHEDULED')->where('status_date', '>=', now())
                        ->orderBy('order', 'asc')
                      ->get();
                      
                      $subTotal = $cart->total;
                    @endphp
                </div>
                <div class="row">
                  @if ( $subTotal >= 0 )
                    <!-- PAYFAST -->
                    @if( !empty($config['payfast_payment_option']['enable']) || $config['payfast_payment_option']['enable'] )
                    <div class="col-12 payment-option-block mb-3">
                        <h2 class="mb-lg-3 mb-2">
                          <i class="fa fa-circle @if( in_array( 'PAYFAST', $initOpenOption ) ) active @endif"></i>
                          Payfast
                          <div class="payment-image-block">
                          @foreach($pay_options->where('title', 'payfast') AS $option)
                            @if($option->title == 'payfast')
                              <img class="img-fluid" src="/{{ $option->link_image }}" />
                            @endif
                          @endforeach
                          </div>
                        </h2>
                        <div class="payment-info-block row @if( in_array( 'PAYFAST', $initOpenOption ) ) initialOpenOption @endif">
                          @if ( $config['payfast_payment_option']['is_test'] )
                          {{-- SANDBOX Mode --}}                            
                            <form action="https://sandbox.payfast.co.za/eng/process" method="POST">
                            <input type="hidden" name="merchant_id" value="10000100">
                            <input type="hidden" name="merchant_key" value="46f0cd694581a">
                            <input type="hidden" name="item_name" value="Order ID: {{ $cart->id }}">
                            <input type="hidden" name="amount" value="{{ $subTotal }}">
                            <input type="hidden" name="amounta" value="{{ $cart->total }}">
                            <input type="hidden" name="item_description" value="{{ ucwords( $site_settings->site_name ) }} Online Purchase: OrderID-{{ $cart->id }}">
                            <input type="hidden" name="return_url" value="{{url('/')}}/success">
                            <input type="hidden" name="cancel_url" value="{{url('/')}}/error">
                            <input type="hidden" name="notify_url" value="{{url('/')}}/notify">
                            {{-- <input type="submit" value="Pay with Payfast" /> --}}
                            <table>
                                <tr>
                                  <td colspan="2" align="center">
                                    <input type="image" src="https://www.payfast.co.za/images/buttons/light-small-paynow.png" width="165" height="36" alt="Pay Now" title="Pay Now with PayFast">
                                  </td>
                                </tr>
                              </table>
                            </form>
                          @elseif( $config['payfast_payment_option']['live'] )
                          {{-- LIVE Mode --}}
                            <script language="JavaScript" type="text/javascript">
                              function click_{{ $config['payfast_payment_option']['live']['frontendUUID'] }}(aform_reference) {
                                var aform = aform_reference;
                                aform['amount'].value = Math.round(aform['amount'].value * Math.pow(10, 2)) / Math.pow(10, 2);
                              }
                            </script>
                            <form action="https://www.payfast.co.za/eng/process" name="form_{{ $config['payfast_payment_option']['live']['frontendUUID'] }}"
                                onsubmit="return click_{{ $config['payfast_payment_option']['live']['frontendUUID'] }}( this );" method="post">
                              <input type="hidden" name="cmd" value="_paynow">
                              <input type="hidden" name="receiver" value="15514262">
                              <input type="hidden" name="merchant_key" value="5gajd08znxwe4">
                              <input type="hidden" name="payment_method" value="">
                              <input type="hidden" name="item_name" value="OrderID-{{ $cart->id }}">
                              <input type="hidden" name="amount" value="{{ $subTotal }}">
                              <input type="hidden" name="item_description" value="{{ ucwords( $site_settings->site_name ) }} Online Purchase: OrderID-{{ $cart->id }}">
                              <input type="hidden" name="return_url" value="{{ url( 'success' ) }}">
                              <input type="hidden" name="cancel_url" value="{{ url( 'error' ) }}">
                              <input type="hidden" name="notify_url" value="{{url('/')}}/notify">
                              <table>
                                <tr>
                                  <td colspan="2" align="center">
                                    <input type="image" src="https://www.payfast.co.za/images/buttons/light-small-paynow.png" width="165" height="36" alt="Pay Now" title="Pay Now with PayFast">
                                  </td>
                                </tr>
                              </table>
                            </form>
                          @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Ozow Instant EFT -->
                    @if( !empty($config['ozow_payment_option']['enable']) || $config['ozow_payment_option']['enable'] )
                    <div class="col-12 payment-option-block mb-3">
                        <h2 class="mb-lg-3 mb-2">
                            <i class="fa fa-circle @if( in_array( 'OZOW', $initOpenOption ) ) active @endif"></i>
                            Ozow Instant EFT
                            <div class="payment-image-block">
                                <img class="img-fluid" src="/assets/images/template/ipay.jpg" />
                            </div>
                        </h2>
                        <div class="payment-info-block row @if( in_array( 'OZOW', $initOpenOption ) ) initialOpenOption @endif">
                            <div class="payment-info-form col-12 col-md-10">
                                <p>Ozow is an instant payment solution that facilitates online EFT payments across
                                    South Africa’s major banks, including ABSA, Capitec, FNB, Investec, Nedbank, and
                                    Standard Bank.</p>
                                <p><strong>HOW DOES IT WORK?</strong></p>
                                <ul>
                                    <li>Click on “Ozow Instant EFT” to start the payment process.</li>
                                    <li>Select your bank and log in using your internet banking credentials.</li>
                                    <li>Select an account to pay from, and your order number will be automatically
                                        added as your reference.</li>
                                    <li>Your bank will send you an OTP (One Time Pin) or mobile authentication
                                        message to verify the payment.</li>
                                    <li>Enter the OTP or accept the authentication message to complete the payment.
                                    </li>
                                </ul>
                                <p>Once the payment is complete, we’ll send you an email confirming your order and
                                    direct you to the Order confirmation page.<br> No further action is required
                                    from your side!<br> Capitec users: Note that there’s a transaction limit of
                                    R14000 per order.</p>
                                <p>By clicking "Pay via iPay" you confirm you have read and accept our <a
                                        href="{{ url('terms-conditions') }}" target="_blank">T&Cs</a></p>

                            </div>
                            @php
                            $hash = hash("SHA512",
                            strtolower($config['ozow_payment_option']['SITE_CODE'].$config['ozow_payment_option']['COUNTRY_CODE'].$config['ozow_payment_option']['CURRENCY_CODE'].$subTotal."AO-".$cart->id."AO-".$cart->id.url("/")."/error".url("/")."/ipay?orderId=".$cart->id."false".$config['ozow_payment_option']['SECRET_KEY']));
                            @endphp
                            <a target="_self" class="payment-button"
                                href="https://pay.ozow.com?SiteCode={{$config['ozow_payment_option']['SITE_CODE']}}&CountryCode={{$config['ozow_payment_option']['COUNTRY_CODE']}}&CurrencyCode={{$config['ozow_payment_option']['CURRENCY_CODE']}}&Amount={{$subTotal}}&TransactionReference=AO-{{$cart->id}}&BankReference=AO-{{$cart->id}}&IsTest=false&HashCheck={{$hash}}&SuccessUrl={{url("/")."/ipay?orderId=".$cart->id}}&ErrorUrl={{url("/")."/error"}}">Pay
                                via OZOW</a>
                        </div>
                    </div>
                    @endif

                {{--
                    <!-- NOT POSSIBLE HERE - Not enough credit and would require a partner payment method to complete checkout -->
                    @if ( $config['store_credit_checkout_only_option'] )
                    <div class="col-12 payment-option-block mb-3">
                        <h2 class="mb-lg-3 mb-2">
                            <i class="fa fa-circle @if( in_array( 'Store Credit', $initOpenOption ) ) active @endif"></i>
                            <div class="payment-image-block">
                            @foreach($pay_options AS $option)
                              @if( strtolower( $option->title ) == 'store credit')
                                {{ ucwords( $option->title ) }}
                                @isset( $option->link_image )
                                <img class="img-fluid" src="/{{ $option->link_image }}" />
                                @endisset
                              @endif
                            @endforeach
                            </div>
                        </h2>
                        <div class="payment-info-block row no-gutters @if( in_array( 'Store Credit', $initOpenOption ) ) initialOpenOption @endif">
                            <form action="{{ url('storeCredit') }}">
                                {!! Form::token() !!}
                                {!! Form::hidden('orderId', $cart->id) !!}
                                {!! Form::hidden('payment_method', 'StoreCredit') !!}
                                <input class="form-control px-5 ml-0" type="submit" value="Checkout with Store Credit" />
                            </form>
                        </div>
                    </div>
                    @endif
                --}}
                    <!-- EFT -->
                    @if( !empty($config['eft_payment_option']['enable']) || $config['eft_payment_option']['enable'])
                    <div class="col-12 payment-option-block mb-3">
                        <h2 class="mb-lg-3 mb-2">
                            <i class="fa fa-circle @if( in_array( 'EFT', $initOpenOption ) ) active @endif"></i>
                            EFT
                            <div class="payment-image-block">
                                @foreach($pay_options AS $option)
                                @if($option->title == 'eft')
                                <img class="img-fluid" src="/{{ $option->link_image }}" />
                                @endif
                                @endforeach
                            </div>
                        </h2>
                        <div class="payment-info-block row @if( in_array( 'EFT', $initOpenOption ) ) initialOpenOption @endif">
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
                    <!-- Store Credit Only Checkout - Payment made in full by Store Credit -->
                    @if ( $config['store_credit_checkout_only_option'] )
                    <div class="col-12 payment-option-block mb-3">
                        <h2 class="mb-lg-3 mb-2">
                            <i class="fa fa-circle @if( in_array( 'Store Credit', $initOpenOption ) ) active @endif"></i>
                            <div class="payment-image-block">
                            @foreach($pay_options AS $option)
                              @if( strtolower( $option->title ) == 'store credit')
                                {{ ucwords( $option->title ) }}
                                @isset( $option->link_image )
                                <img class="img-fluid" src="/{{ $option->link_image }}" />
                                @endisset
                              @endif
                            @endforeach
                            </div>
                        </h2>
                        <div class="payment-info-block row no-gutters @if( in_array( 'Store Credit', $initOpenOption ) ) initialOpenOption @endif">
                            <form action="{{ url('storeCredit') }}">
                                {!! Form::token() !!}
                                {!! Form::hidden('orderId', $cart->id) !!}
                                {!! Form::hidden('payment_method', 'StoreCredit') !!}
                                <input class="form-control px-5 ml-0" type="submit" value="Checkout with Store Credit" />
                            </form>
                        </div>
                    </div>
                    @endif
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
                <button type="submit">GO</button>
              </div>
            </div>
          </form>
        @endif

      </div>
    </div>
  </div>
</div>

@push( 'pageScripts' )
<script type="text/javascript" id="payment-option-most-used-method">
document.addEventListener('DOMContentLoaded', function(evt) {
  try {
    var initOpen = [].slice.call( document.querySelectorAll( '.initialOpenOption' ) );
    initOpen.forEach( (e, k) => {
      setTimeout(function() { 
        e.style.display = 'block'; 
      }, ( k + 1 ) * 1500);
    })
  } catch( err ) {}
}, false);
</script>
@endpush

@if( env( 'APP_ENV' ) === 'production' )
  @include('templates.tab_open_check')
@endif

@endsection

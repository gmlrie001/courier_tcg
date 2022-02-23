@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@push( 'pageStyles' )
<style>
.row.striken *,
.row.striken * input {
  text-decoration: line-through;
  cursor: not-allowed;
}
p small,
small {
  font-weight: 500;
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
.shipping-options-list-options input[type="radio"] + label:before {
  font-family: 'Font Awesome 5 Free';
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
  $shipment_courier = $shipper;
  if ( ! isset( $shipment_courier ) || NULL == $shipment_courier || $shipment_courier == '' ) $shipment_courier = 'Default';
@endphp

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
  // if ( $order->shipping_cost == 0 || $order->shipping_cost == null ) {
    $shippingTotal = 0;
  // } else {
    // $shippingTotal = $order->shipping_cost;
    $subTotal += $shippingTotal;
  // }
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
            <div class="arrow col-3 active">
              <div><span>3</span>Shipping Method</div>
            </div>
            <div class="arrow col-3">
              <div><span>4</span>Payment</div>
            </div>
          </div>
          <div class="row">
            <h3 class="col-12 text-center d-block d-md-none">Shipping Method</h3>
          </div>
        </div>
        <div class="shipping-options-block">
          <div class="col-12 px-0 shipping-options-list">
            <div class="row no-gutters">
              <h1 class="col-12 col-md-1 text-center"></h1>
              <h1 class="col-12 col-md-2">Type</h1>
              <h1 class="col-12 col-md-4">Description</h1>
              <h1 class="col-12 col-md-4">Estimated Time of arrival</h1>
              <h1 class="col-12 col-md-1">Price</h1>
            </div>
          </div>
          @php
            $cart = $cart_products->first()->basket;
            $user = $cart->user;
            $cart_products_unique = $cart_products->unique( 'product_id' );

            if ( $config['external_courier_companies']['TheCourierGuy']['courier_enabled'] ) {
              $shipper = 'Ppapi_tcg';
              $courierName = $config['external_courier_companies']['TheCourierGuy']['courier'];

            } elseif ( $config['external_courier_companies']['Aramex']['courier_enabled'] ) {
              $shipper = 'Aramex';
              $courierName = $config['external_courier_companies']['Aramex']['courier'];

            } elseif ( $config['external_courier_companies']['ParcelNinja']['courier_enabled'] ) {
              $shipper = 'ParcelNinja';
              $courierName = $config['external_courier_companies']['ParcelNinja']['courier'];

            } elseif ( $config['external_courier_companies']['Default']['courier_enabled'] ) {
              $shipper = 'Default';
              $courierName = $config['external_courier_companies']['Default']['courier'];
            }
          @endphp

          <form class="col-12">
            <div class="row">
              <div class="col-12 px-0 shipping-options-list-options">
              @switch( strtolower( $shipper ) )

                @case( 'free shipping' )
                  @if(isset($free_shipping) && $free_shipping)
                    <div class="row no-gutters pt-lg-2 pt-3">
                      <div class="col-12 col-md-1 text-center-lg">
                        <input id="option_1" data-description="Qualified for free shipping" data-arrival="ESTIMATED 10-14 working days" data-title="FREE Shipping" data-service="free" type="radio" name="option" value="0" required="">
                        <label for="option_1"></label>
                      </div>
                      <div class="col-12 col-md-2 strong">FREE Shipping</div>
                      <div class="col-12 col-md-4">Qualified for free shipping</div>
                      <div class="col-12 col-md-4">ESTIMATED 10&ndash;14 working days</div>
                      <div class="col-12 col-md-1">FREE</div>
                    </div>
                  @endif
                  @break
                
                @case( 'aramex' )
                  @php
                    $opts = shipperOpt; // $courier['aramex'];
                    $decoded_opts = json_decode( $opts, false );
                    $shipperOpt = $decoded_opts->rates;
                    unset( $opts, $decoded_opts, $courier );
                  @endphp
                  @include( 'templates.checkout.ecommerce.checkout.step3.couriers.aramex' )
                  @break
                
                @case( 'ppapi_tcg' )
                  @php
                    $opts = $courier['Ppapi_tcg'];
                    $decoded_opts = json_decode( $opts, false );
                    $shipperOpt = $decoded_opts->rates;
                    unset( $opts, $decoded_opts, $courier );
                  @endphp
                  {{-- ideally use @each blade directive --}}
                  @include( 'courier_tcg::ecommerce.checkout.step3.couriers.ppapi_tcg', ['shipperOpt' => $shipperOpt] )
                  @break
                
                @case( 'default' )
                  @php
                    $opts = $shipperOpt; // $courier['ppapi_tcg'];
                    $shipperOpt = $opts;
                  @endphp
                  @include( 'templates.checkout.ecommerce.checkout.step3.couriers.default_manual' )
                  @break
                
                @default
                  <div class="row pt-lg-4 pt-3">
                    <div class="col-12">
                      <h4><strong>Yikes! Unfortunately there are no shipping methods available based on your postal code.</strong></h4>
                      <p>Please <a rel="noopener noreferer" title="Checkout delivery options - no shipping methods available for supplied address and/or postal code" target="_blank" href="/contact-us" class="">contact us</a> with your issue and we will get as soon as we can.</p>
                    </div>
                  </div>
                  @break

              @endswitch
              </div>
            </div>
          </form>
        </div>
      </div>
      @if($can_assemble && sizeof($order->assemblyProducts))
      <div class="row">
        <div class="col-12">
          <h1>NEED ANY OF YOUR ITEMS ASSEMBLED FOR YOU?</h1>
        </div>
        <div class="col-12">
          <div class="row">
          @foreach($order->assemblyProducts as $product)
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
              @forelse($available_coupons as $available_coupon)
                <a href="/apply/coupon/{{$available_coupon->id}}">
                  {{$available_coupon->code}}
                  <i class="fa fa-plus"></i>
                </a>
              @empty
              @endforelse
            </div>
          @endif

          <form action="/apply/coupon/code" method="post" class="col-12 p-0 promo-form">
            {!! Form::token() !!}
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Enter Promo Code" name="code">
              <div class="input-group-append">
                <button type="submit">GO</button>
              </div>
            </div>
          </form>
        @endif

        <form class="col-12 p-0 shipping-option-form-results" action="/cart/payment" method="post">
          {!!Form::token()!!}
          {!!Form::hidden('cart_id', $order->id)!!}
          <input type="hidden" name="shipping_title" value="" />
          <input type="hidden" name="option" value="" />
          <input type="hidden" name="shipping_courier_service_type" value="" />
          <input type="hidden" name="shipping_description" value="" />
          <input type="hidden" name="shipping_time_of_arrival" value="" />
          <input class="continue-button blue-background" type="submit" value="continue checkout" name="basketDelivery" />
        </form>

      </div>
    </div>
  </div>
</div>

@push( 'pageScripts' )
$(document).ready(function()
{
  // Prevent Form Submission
  $(".no-submit").submit(function(e)
  {
    e.preventDefault();
    return false;
  });

  // Dynamically Update hidden form elements when new shipping option selected
  $(".shipping-options-list-options input").change(function()
  {
    try {
      $(".shipping-option-form-results input[name='option']").val($(this).val());
    } catch( error ) {}
    
    var assocInputNames = {
      'title':       "shipping_title",
      'service':     "shipping_courier_service_type", 
      'description': "shipping_description", 
      'arrival':     "shipping_time_of_arrival", 
    }
    for ( key in assocInputNames ) {
      var inpName  = assocInputNames[key] );
      var inpValue = key;
      $( ".shipping-option-form-results input[name='" + inputName + "]" )
        .val( $( this ).data( inpValue ) );
    }
    try {
      $(".shipping-option-form-results input[name='shipping_title']").val($(this).data('title'));
    } catch( error ) {}

    try {
      $(".shipping-option-form-results input[name='shipping_courier_service_type']").val($(this).data('service'));
    } catch( error ) {}
    
    try {
      $(".shipping-option-form-results input[name='shipping_description']").val($(this).data('description'));
    } catch( error ) {}
    
    try {
      $(".shipping-option-form-results input[name='shipping_time_of_arrival']").val($(this).data('arrival'));
    } catch( error ) {}
  });

})();
@endpush

@includeIf( env( 'APP_ENV' ) === 'production' ,'templates.tab_open_check' )

@endsection

{{--
include( 'templates.checkout.checkout_functions.helpers'/*, ['order' => $cart,'discount' => $discount,'discount_type' => $discount_type]*/ )
--}}
@include( 'templates.checkout.checkout_functions.helpers' )

@php
    $subTotal = $total_cost;
    if( isset( $cart ) && ! isset( $order ) ): $order = $cart; endif;
    if( ($cart_products != NULL || isset( $cart_products )) && count( $cart_products ) > 0 ):
        $cart_total = $cart_products->sum( 'quantity' );
    endif;
    list( $subTotal, $discountTotal ) = checkout_deductions( $subTotal, $discount, $discount_type );
    list( $subTotal, $couponTotal )   = checkout_deductions( $subTotal, $order->coupon, $order->coupon_discount_type );
    list( $subTotal, $creditTotal )   = checkout_deductions( $subTotal, $order->store_credit_value, NULL );
    // list( $subTotal, $_ ) = checkout_deductions( $subTotal, 0, NULL );
    dd( get_defined_vars() );
@endphp

<div class="col-12 col-lg-3 custom-checkout-padding">
    <div class="row">
        <div class="col-12 payment-order-summary pre-payment">
            <h2>Order Summary:</h2>
            <p class="text-right"><span>Cost:</span> R {{ number_format(($total_cost), 2, ".", "") }}</p>
            @if($discountTotal != 0)
                <p class="text-right"><span>Discount:</span> -R {{ number_format(($discountTotal), 2, ".", "") }}</p>
            @endif
            @if($couponTotal != 0)
                <p class="text-right"><span>Coupon:</span> -R {{ number_format(($couponTotal), 2, ".", "") }}</p>
            @endif
            @if($creditTotal != 0)
                <p class="text-right"><span>Store Credit:</span> -R {{ number_format(($creditTotal), 2, ".", "") }}</p>
            @endif
            <h3 class="text-right"><span>Total</span> R {{ number_format(($subTotal), 2, ".", "") }}</h3>

            <h4>Items in Basket: <span class="float-right">{{ $cart_total }}</span></h4>
        </div>
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
                    <span class="text-right">R {{number_format($walletTotal, 2, "", "")}}</span>
                    <i class="store-credit-value">Value: R {{number_format($creditTotal, 2, "", "")}}</i>
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
                            max: {{number_format($walletTotal, 2, "", "")}},
                            value: {{number_format($creditTotal, 2, "", "")}},
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
        <form action="/cart/delivery" method="post" class="col-12 p-0">
            {!!Form::token()!!}
            {!!Form::hidden('cart_id', $cart_id)!!}
            {!!Form::hidden('discount', number_format($discountTotal, 2, '.', ''))!!}
            {!!Form::hidden('total', number_format($total_cost, 2, '.', ''))!!}
            @if($cart_total > 0)
                @if(isset($cant_checkout) && $cant_checkout == true)
                    <input type="submit" value="continue" disabled class="continue-button" />
                @else
                    <input type="submit" value="continue" class="continue-button" />
                @endif
            @endif
        </form>
    </div>
</div>
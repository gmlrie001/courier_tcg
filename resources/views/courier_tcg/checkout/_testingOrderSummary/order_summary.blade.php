<div class="col-12 col-lg-3 custom-checkout-padding">
    <div class="row">
        <div class="col-12 payment-order-summary pre-payment">
            <h2>Order Summary:</h2>
            @php
              $order = $cart;

              if ( ( $cart_products != NULL || isset( $cart_products ) ) && count( $cart_products ) > 0 ):
                $cart_total = $cart_products->sum( 'quantity' );
              endif;

              $subTotal = $total_cost;
              
              if ( $discount == 0 ) {
                $discountTotal = 0;
              } else {
                if ( $discount_type == 0 ) {
                  $discountTotal = $total_cost*($discount/100);
                } else {
                  $discountTotal = $discount;
                }
                $subTotal = $subTotal - $discountTotal;
              }
              
              if ( $order->coupon == null ) {
                $couponTotal = 0;
              } else {
                if ( $order->coupon_discount_type == 0 ) {
                  $couponTotal = $subTotal*($order->coupon_discount/100);
                } else {
                  $couponTotal = $order->coupon_discount;
                }
                $subTotal = $subTotal - $couponTotal;
              }

              if ( $order->store_credit_value == null ) {
                  $creditTotal = 0;
              } else {
                  $creditTotal = $order->store_credit_value;
                  $subTotal = $subTotal - $creditTotal;
              }

              $subTotal += ( $order->shipping_cost != NULL && $order->shipping_cost > 0 ) ? $order->shipping_cost : 0.00;
            @endphp
            
            <p class="text-right"><span>Subtotal Cost:</span> R {{ number_format(($total_cost), 0, ",", ".") }}</p>
            @if($discountTotal > 0)
              <p class="text-right"><span>Discount:</span> -R {{ number_format(($discountTotal), 0, ",", ".") }}</p>
            @endif
            @if($couponTotal > 0)
              <p class="text-right"><span>Coupon:</span> -R {{ number_format(($couponTotal), 0, ",", ".") }}</p>
            @endif

            <p class="text-right" style="border-top:1px solid #333;">
              <span class="font-weight-bold">Total</span> 
              R {{ number_format(($order->subtotal), 0, ",", ".") }}
            </p>

            @if ( in_array( "Vault\StoreCredit\StoreCreditServiceProvider", get_declared_classes() ) ) 
              {!! StoreCredit::renderCheckoutOrderSummary( $order ) !!}
            @endif

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
        <form action="/cart/delivery" method="post" class="col-12 p-0">
            {!!Form::token()!!}
            {!!Form::hidden('cart_id', $cart_id)!!}
            {!!Form::hidden('discount', number_format($discountTotal, 2, '.', ''))!!}
            {!!Form::hidden('total', number_format($total_cost, 2, '.', ''))!!}
            <div class="mb-5">
                @include('templates.checkout.continue_shopping_button')
            </div>
            @if($cart_total > 0)
                @if(isset($cant_checkout) && $cant_checkout == true)
                    <input type="submit" value="continue checkout" disabled class="continue-button blue-background" />
                @else
                    <input type="submit" value="continue checkout" class="continue-button blue-background" />
                @endif
            @endif

        </form>
    </div>
</div>
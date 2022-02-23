<div class="col-12 payment-order-summary pre-payment">
    <h2>Order Summary:</h2>

  @if( $cart_total && $cart_total > 0 )
    <p class="text-right mt-1 mb-0 pt-2 font-weight-bold" style="border-top:1px dashed #33333333;"><span>Items in Basket:</span> {{ $cart_total }}</p>
  @endif

  @if( $total_cost && $total_cost > 0 )
    <p class="text-right mt-1 mb-0"><span>Subtotal:</span> R {{ number_format($total_cost, 0) }}</p>
  @endif

  @if( $discountTotal && $discountTotal > 0 )
    <p class="text-right mt-1 mb-0"><span>Discount:</span> -R {{ number_format($discountTotal, 0) }}</p>
  @endif

  @if( $couponTotal && $couponTotal > 0)
    <p class="text-right mt-1 mb-0"><span>Coupon:</span> -R {{ number_format($couponTotal, 0) }}</p>
  @endif

  @if ( request()->is( 'cart/payment' ) && ( $cart->shipping_cost >= 0 && ( $cart->shipping_title != NULL || $cart->collection_code != NULL ) ) )
  <p class="text-right mt-1 mb-0">
    <span>Shipping Cost:</span> R
    {{ number_format($cart->shipping_cost, 0, ".", "") }}
  </p>
  @endif

  @if ( class_exists( 'StoreCredit' ) ) 
    @if ( $user != null ) {!! StoreCredit::render() !!} @endif
  @endif

  <p class="text-right font-weight-bold clearfix py-2 mt-1 mb-0" style="border-top:1px solid #333;border-bottom:1px solid #333;">
    <span class="font-weight-bold">Total</span> 
    <span class="total-amount font-weight-bold float-right">R {{ number_format( $cart->subtotal + $cart->orderTotalAdds(), 0 ) }}</span>
  </p>

  @if ( request()->is( 'cart/delivery/*' ) || request()->is( 'cart/pay*' ) )
    @if ( $order && ( $order->delivery_postal_code != NULL || $order->delivery_country != NULL ) )
      <h4>Shipping Info:</h4>
      <address class="shipping-address">
        <p>
          @if($order->delivery_address_line_1 != "")
            {{$order->delivery_address_line_1}}, <br>
          @endif
          @if($order->delivery_address_line_2 != "")
            {{$order->delivery_address_line_2}}, <br>
          @endif
          @if($order->delivery_suburb != "")
            {{$order->delivery_suburb}}, <br>
          @endif
          @if($order->delivery_city != "")
            {{$order->delivery_city}}, <br>
          @endif
          @if($order->delivery_postal_code != "")
            {{$order->delivery_postal_code}}, <br>
          @endif
          @if($order->delivery_province != "")
            {{$order->delivery_province}}, <br>
          @endif
          @if($order->delivery_country != "")
            {{$order->delivery_country}}
          @endif
        </p>
      </address>
    @endif
  @endif

  @if ( request()->is( 'cart/pay*' ) )
    @if ( $cart->shipping_description && $cart->shipping_description != NULL )
      <h4>Shipping Method:</h4>
      <div class="shipping-method">
        <p>
          {{$cart->shipping_description}}:<br>
          {{$cart->shipping_title}}</br>
          <span class="font-weight-bold">{{ str_replace( 'ESTIMATED', 'ETA: ', $cart->shipping_time_of_arrival ) }}</span>
        </p>
      </div>
    @endif
  @endif

</div>

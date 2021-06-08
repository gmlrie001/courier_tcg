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

  if ( $order->store_credit_value == 0 || $order->store_credit_value == null ) {
    $creditTotal = 0;
  } else {
    $creditTotal = $order->store_credit_value;
    $subTotal = $subTotal - $creditTotal;
  }

  $subTotal += ( NULL != $order->shipping_cost ) ? $order->shipping_cost : 0;

  // dd( $order, get_defined_vars() );
@endphp

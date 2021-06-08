@include( 'templates.checkout._testingOrderSummary.payment_preCalcs' )

<div class="col-12 col-lg-3 custom-checkout-padding">
    <div class="row">
        <div class="col-12 payment-order-summary">
            <h2>Order Summary:</h2>

            <p class="text-right"><span>Subtotal Cost:</span> R {{ number_format(($total_cost), 0, ",", ".") }}</p>
            @if($discountTotal != 0)
              <p class="text-right"><span>Discount:</span> -R {{ number_format($discountTotal, 0, '.', ',') }}</p>
            @endif
            @if($couponTotal != 0)
              <p class="text-right"><span>Coupon:</span> -R {{ number_format($couponTotal, 0, '.', ',') }}</p>
            @endif

            <p class="text-right">
              <span>Total</span> 
              R {{ number_format(($order->total + $creditTotal), 0, ",", ".") }}
            </p>

            @if($creditTotal != 0)
              @php
                $credit = $order->user->storeCredits->where( 'credit_debit', 'credit' )->sum( 'amount' );
                    $debit = $order->user->storeCredits->where( 'credit_debit',  'debit' )->sum( 'amount' );
                $walletTotal = number_format( $credit - $debit, 0, "", "" );
              @endphp
              <p class="text-right" hidden>
                <span>Store Credit:</span> 
                -R {{ number_format(($creditTotal), 0, ",", ".") }}
              </p>
              <p class="text-right" hidden>
                <span class="font-weight-bold">Use Wallet</span> 
                -R {{ number_format(($creditTotal), 0, ",", ".") }}
              </p>
              <div class="text-right clearfix">
                <p>
                  <span class="font-weight-bold">
                    Use Wallet 
                    {{-- <a class="store-credit-edit collapse text-success" href="javascript:void(0);" >EDIT</a> --}}
                  </span> 
                  <span class="store-credit-value float-right">-R {{ number_format($creditTotal, 0, ",", ".") }}</span>
                </p>
              </div>
              @if( ! request()->is( '*cart*/payment') )
                @if($user != null) {!! StoreCredit::renderCheckoutOrderSummary( $order ) !!} @endif
              @endif
              <p class="text-right font-weight-bold"><span>Shipping Cost:</span> R
              {{ number_format($order->shipping_cost, 0, '.', ',') }}</p>
              <h3 class="text-right clearfix pt-2" style="border-top:1px solid #333;">
                <span style="font-size:85%;text-transform:capitalize!important;">Amount Outstanding</span> 
                <span class="outstanding-amount float-right" style="font-size:85%;text-transform:capitalize!important;">R {{ number_format(($subTotal), 0, ",", ".") }}
              </h3>
            @endif
          {{--
            <p class="text-right"><span>Shipping Cost:</span> R
                {{ number_format($order->shipping_cost, 0, '.', ',') }}</p>
            <h3 class="text-right"><span>Amount Outstanding</span> R {{ number_format($order->total, 0, '.', ',') }}</h3>
          --}}
            <h4>Items in Basket: <span class="float-right">{{$order_total}}</span></h4>
            <h4>Shipping Info:</h4>
            <p>
                {{$order->delivery_address_line_1}}, <br>
                @if($order->delivery_address_line_2 != "")
                {{$order->delivery_address_line_2}}, <br>
                @endif
                {{$order->delivery_suburb}}, <br>
                {{$order->delivery_city}}, <br>
                {{$order->delivery_postal_code}}, <br>
                {{$order->delivery_province}}, <br>
                {{$order->delivery_country}}
            </p>
            <h4>Shipping Method:</h4>
            <p>
                {{$order->shipping_description}} - {{$order->shipping_title}}: <br>
                {{$order->shipping_time_of_arrival}}
            </p>
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
                    <button type="submit">GO</button>
                </div>
            </div>
        </form>
      @endif
    </div>
</div>
@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@section('content')
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
                        <div class="col-12 padding-0 shipping-options-list">
                            <div class="row">
                                <h1 class="col-12 col-md-1">Select</h1>
                                <h1 class="col-12 col-md-2">Type</h1>
                                <h1 class="col-12 col-md-3">Description</h1>
                                <h1 class="col-12 col-md-4">Estimated Time of arrival</h1>
                                <h1 class="col-12 col-md-2">Price</h1>
                            </div>
                        </div>
                        <form class="col-12 no-submit">
                            <div class="row">
                                <div class="col-12 padding-0 shipping-options-list-options">
                                    @if(isset($free_shipping) && $free_shipping == true)
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 col-lg-1"><input id="option_1" data-description="Qualified for free shipping" data-arrival="10-14 working days" data-title="FREE Shipping" type="radio" name="option" value="0" required="" /><label for="option_1"></label></div>
                                                    <div class="col-12 col-lg-2 strong">FREE Shipping</div>
                                                    <div class="col-12 col-lg-3">Qualified for free shipping</div>
                                                    <div class="col-12 col-lg-4">10-14 working days</div>
                                                    <div class="col-12 col-lg-2">FREE</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(sizeof($areas))
                                        @php
                                            $counter = 0;
                                        @endphp
                                        @foreach($areas as $areaKey => $area)
                                            @foreach($area->displayOptions as $optionKey => $option)
                                                @if($option->shippingOption != null)
                                                    @if(sizeof($option->shippingOption->displayRates))
                                                        @foreach($option->shippingOption->displayRates as $rateKey => $rate)
                                                            @php
                                                                $orderCount = $order->products->sum('quantity');
                                                            @endphp
        
                                                            @if(($rate->condition == "Price" && ($rate->min_condition <= $order->total && $rate->max_condition >= $order->total))
                                                                || ($rate->condition == "Item Count" && ($rate->min_condition <= $orderCount && $rate->max_condition >= $orderCount)))
        
                                                                @if($rate->cost_type == "percentage")
                                                                    @php
                                                                        $cost = $order->total*($rate->cost/100);
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $cost = $rate->cost*$order->products->count();
                                                                    @endphp
                                                                @endif
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-12 col-lg-1"><input id="option_{{$counter}}" data-description="{{$area->title}}" data-arrival="{{$area->delivery_time}}" data-title="{{$option->shippingOption->title}}" type="radio" name="option" value="{{number_format($cost, 0, "", "")}}" required="" /><label for="option_{{$counter}}"></label></div>
                                                                            <div class="col-12 col-lg-2 strong">{{$option->shippingOption->title}}</div>
                                                                            <div class="col-12 col-lg-3">{{$area->title}}</div>
                                                                            <div class="col-12 col-lg-4">{{$area->delivery_time}}</div>
                                                                            <div class="col-12 col-lg-2">R {{number_format($cost, 0, "", "")}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @php
                                                            $default_cost = $option->shippingOption->default_cost;
                                                            $calc_type = $option->shippingOption->calculation_type;

                                                            if($calc_type == 'Per Order'){
                                                                $cost = $default_cost;
                                                            }elseif($calc_type == 'Per Item'){
                                                                $orderCount = $order->products->sum('quantity');
                                                                $cost = ($default_cost*$orderCount);
                                                            }elseif($calc_type == 'Per Line Item'){
                                                                $orderCount = $order->products->count('id');
                                                                $cost = ($default_cost*$orderCount);
                                                            }
                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-12 col-lg-1"><input id="option_{{$counter}}" data-description="{{$area->title}}" data-arrival="{{$area->delivery_time}}" data-title="{{$option->shippingOption->title}}" type="radio" name="option" value="{{number_format($cost, 0, "", "")}}" required="" /><label for="option_{{$counter}}"></label></div>
                                                                    <div class="col-12 col-lg-2 strong">{{$option->shippingOption->title}}</div>
                                                                    <div class="col-12 col-lg-3">{{$area->title}}</div>
                                                                    <div class="col-12 col-lg-4">{{$area->delivery_time}}</div>
                                                                    <div class="col-12 col-lg-2">R {{number_format($cost, 0, "", "")}}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $counter++;
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        Yikes! Unfortunately there are no shipping methods available based on your postal code. <br> Please contact us at <a href="mailto:info@decofurnsa.co.za">info@decofurnsa.co.za</a> for assitance. <br>
                                                        <br>
                                                        Thank you for your patience.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                        
                        if($order->coupon == null){
                            $couponTotal = 0;
                        }else{
                            if($order->coupon_discount_type == 0){
                                $couponTotal = $subTotal*($order->coupon_discount/100);
                            }else{
                                $couponTotal = $order->coupon_discount;
                            }
                            $subTotal = $subTotal - $couponTotal;
                        }
                        
                        if($order->store_credit_value == null){
                            $creditTotal = 0;
                        }else{
                            $creditTotal = $order->store_credit_value;
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
                    <form class="col-12 p-0 shipping-option-form-results" action="/cart/payment" method="post">
                        {!!Form::token()!!}
                        {!!Form::hidden('cart_id', $order->id)!!}
                        <input type="hidden" name="shipping_title" value="" />
                        <input type="hidden" name="option" value="" />
                        <input type="hidden" name="shipping_description" value="" />
                        <input type="hidden" name="shipping_time_of_arrival" value="" />
                        @if(sizeof($areas) || isset($free_shipping))
                            <input class="continue-button" type="submit" value="continue" name="basketDelivery" />
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
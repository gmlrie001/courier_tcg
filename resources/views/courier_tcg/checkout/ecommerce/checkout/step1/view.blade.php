@extends('templates.layouts.index')

@section( 'title', $site_settings->site_name . ' | ' . $page->title )

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-lg-9 custom-checkout-padding">
                <div class="row">
                    <div class="col-12 text-center-sm">
                        <div class="row">
                            <div class="arrow col-3 active">
                                <div><span>1</span>Order Summary</div>
                            </div>
                            <div class="arrow col-3">
                                <div><span>2</span>Shipping Info</div>
                            </div>
                            <div class="arrow col-3">
                                <div><span>3</span>Shipping Method</div>
                            </div>
                            <div class="arrow col-3">
                                <div><span>4</span>Payment</div>
                            </div>
                        </div>
                        <div class="row">
                            <h3 class="col-12 text-center d-block d-md-none">Order Summary</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 order-container">
                        <div class="row">
                            <div class="col-12 cart-header-row">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <h2>Product</h2>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <h2>Options</h2>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <h2>Unit Price</h2>
                                    </div>
                                    <div class="col-12 col-md-1 p-0">
                                        <h2>Qty</h2>
                                    </div>
                                    <div class="col-12 col-md-2" style="padding-left: 40px;">
                                        <h2>Total</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        @foreach($cart_prods as $cart_prod)
                          <div class="cart-product col-12">
                            <a href="/cart/delete/{{$cart_prod->id}}" class="delete-button">x</a>
                            <div class="row d-flex d-sm-none">
                              <a class=" col-5" href="/product/{{$cart_prod->product->url_title}}">
                                  @php
                                      $variant = \App\Models\ProductVariant::where('product_id', $cart_prod->product_id)->where('filters', $cart_prod->filters)->first();

                                      if($variant != null){
                                          if($variant->variant != null && sizeof($variant->variant->displayGalleries)){
                                              $image = $variant->variant->product_image;
                                          }else{
                                              $image = $cart_prod->product->product_image;
                                          }
                                      }else{
                                          $image = $cart_prod->product->product_image;
                                      }
                                  @endphp
                                  <img src="{{url('/').'/'.$image}}" class="img-fluid thumbnail" />
                              </a>
                              <div class="col-7">
                                <div class="row">
                                  <div class="col-12 col-lg-6">
                                      <h2><a href="/product/{{$cart_prod->product->url_title}}">{{$cart_prod->product->title}}</a></h2>
                                      <h3>{{$cart_prod->code}}</h3>
                                      <a href="#" class="wishlist-modal-button fa fa-heart-o" data-id="{{$cart_prod->product->id}}"></a>
                                  </div>
                                  <div class="col-12 col-lg-2">
                                      @if($cart_prod->components != null && $cart_prod->components != 'null')
                                      <?php
                                          $components = json_decode($cart_prod->components);
                                          foreach($components as $key => $component){
                                              $product = \App\Models\Product::find($component);
                                              $productVariant = \App\Models\ProductVariant::where('variant_id', $product->id)->first();
                                              if($product->parent_id != null){
                                                  if($key == 0){
                                                      echo '<h4 style="margin-top: 10px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->parent->title.'</strong></h4>';
                                                  }else{
                                                      echo '<h4 style="margin-top: 15px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->parent->title.'</strong></h4>';
                                                  }
                                              }else{
                                                  if($key == 0){
                                                      echo '<h4 style="margin-top: 10px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->title.'</strong></h4>';
                                                  }else{
                                                      echo '<h4 style="margin-top: 15px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->title.'</strong></h4>';
                                                  }
                                              }
                                              $fils = json_decode($productVariant->filters);
                                              foreach($fils as $key => $value){
                                                      $group = \App\Models\FilterOptionGroup::find($key);
                                                      $option = \App\Models\FilterOption::find($value);
                                                      echo '<h4><span>'.optional($group)->title.':</span> '.optional($option)->title.'</h4>';
                                              }
                                          }
                                      ?>
                                      @elseif($cart_prod->filters != null && $cart_prod->filters != 'null')
                                      <?php
                                          $fils = json_decode($cart_prod->filters);
                                          $group_id = 0;
                                          foreach($fils as $key => $value){
                                                  $group = App\Models\FilterOptionGroup::find($key);
                                                  $option = \App\Models\FilterOption::find($value);
                                                  echo '<h4><span>'.optional($group)->title.':</span> '.optional($option)->title.'</h4>';
                                          }
                                      ?>
                                      @endif
                                      @if($cart_prod->assembly_cost != null && $cart_prod->assembly_cost != 0)
                                        <h4><span>Assembly Cost:</span>R {{ number_format($cart_prod->assembly_cost, 0)}}</h4>
                                      @endif
                                  </div>
                                  <div class="col-12 col-lg-6">
                                    <form action="/cart/update/{{$cart_prod->id}}" method="post" data-parsley-validate="" class="row">
                                      {!!Form::token()!!}
                                      <div class="col-12 col-lg-4">
                                        {{--
                                        @if($cart_prod->original_price != null)
                                            <label style="text-decoration: line-through;"><span class="d-block d-lg-none" style="text-decoration: line-through;">Price</span>R {{number_format(($cart_prod->original_price), 0)}}</label>
                                            <label style="color: #ce0000; font-weight: 600;"><span class="d-block d-lg-none">Price</span>R {{ number_format(($cart_prod->price), 0) }}</label>
                                        @else
                                            <label><span class="d-block d-lg-none">Price</span>R {{ number_format(($cart_prod->price), 0) }}</label>
                                        @endif
                                        --}}
                                        <label><span class="d-block d-lg-none">Price</span>R {{ number_format(($cart_prod->price), 0) }}</label>
                                      </div>
                                      <div class="col-12 col-lg-4">
                                        <span class="d-block d-lg-none prod-label">Qty</span>
                                        <div class="input-append spinner" data-trigger="spinner">
                                          <input type="text" value="{{$cart_prod->quantity}}" name="quantity" data-rule="quantity" class="checkout-quantity-input">
                                          <div class="add-on">
                                            <a href="javascript:;" class="spin-up" data-spin="up">
                                              <i class="fa fa-caret-up"></i>
                                            </a>
                                            <a href="javascript:;" class="spin-down" data-spin="down">
                                              <i class="fa fa-caret-down"></i>
                                            </a>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-12 col-lg-4">
                                        <label><span class="d-block d-lg-none">Total</span>R {{number_format(($cart_prod->price*$cart_prod->quantity), 0)}}</label>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row d-none d-sm-flex">
                                <div class="col-12 col-lg-4">
                                    <div class="row">
                                        <a class="thumbnail col-12 col-lg-6" href="/product/{{$cart_prod->product->url_title}}">
                                            @php
                                                $variant = \App\Models\ProductVariant::where('product_id', $cart_prod->product_id)->where('filters', $cart_prod->filters)->first();

                                                if($variant != null){
                                                    if($variant->variant != null || sizeof($variant->variant->displayGalleries)){
                                                        $image = $variant->variant->product_image;
                                                        $product_title = $variant->variant->title;
                                                    }else{
                                                        $image = $cart_prod->product->product_image;
                                                        $product_title = $cart_prod->product->title;
                                                    }
                                                }else{
                                                    $image = $cart_prod->product->product_image;
                                                    $product_title = $cart_prod->product->title;
                                                }
                                            @endphp
                                            <img src="{{url('/').'/'.$image}}" class="img-fluid" />
                                        </a>
                                        <div class="col-12 col-lg-6">
                                            <h2><a href="/product/{{$cart_prod->product->url_title}}">{{$cart_prod->product->title}}</a></h2>
                                            <h3>{{$cart_prod->code}}</h3>
                                            <a href="#" class="wishlist-modal-button fa fa-heart-o" data-id="{{$cart_prod->product->id}}"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    @if($cart_prod->components != null && $cart_prod->components != 'null')
                                        <?php
                                            $components = json_decode($cart_prod->components);
                                            foreach($components as $key => $component){
                                                $product = \App\Models\Product::find($component);
                                                $productVariant = \App\Models\ProductVariant::where('variant_id', $product->id)->first();
                                                if($product->parent_id != null){
                                                    if($key == 0){
                                                        echo '<h4 style="margin-top: 10px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->parent->title.'</strong></h4>';
                                                    }else{
                                                        echo '<h4 style="margin-top: 15px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->parent->title.'</strong></h4>';
                                                    }
                                                }else{
                                                    if($key == 0){
                                                        echo '<h4 style="margin-top: 10px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->title.'</strong></h4>';
                                                    }else{
                                                        echo '<h4 style="margin-top: 15px;margin-bottom: 2px;text-transform:uppercase;"><strong>'.$product->title.'</strong></h4>';
                                                    }
                                                }
                                                $fils = json_decode($productVariant->filters);
                                                foreach($fils as $key => $value){
                                                        $group = \App\Models\FilterOptionGroup::find($key);
                                                        $option = \App\Models\FilterOption::find($value);
                                                        echo '<h4><span>'.optional($group)->title.':</span> '.optional($option)->title.'</h4>';
                                                }
                                            }
                                        ?>
                                    @elseif($cart_prod->filters != null && $cart_prod->filters != 'null')
                                        <?php
                                            $fils = json_decode($cart_prod->filters);
                                            $group_id = 0;
                                            foreach($fils as $key => $value){
                                                    $group = \App\Models\FilterOptionGroup::find($key);
                                                    $option = \App\Models\FilterOption::find($value);
                                                    echo '<h4><span>'.optional($group)->title.':</span> '.optional($option)->title.'</h4>';
                                            }
                                        ?>
                                    @endif
                                    @if($cart_prod->assembly_cost != null && $cart_prod->assembly_cost != 0)
                                        <h4><span>Assembly Cost:</span>R {{ number_format($cart_prod->assembly_cost, 0)}}</h4>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-5">
                                    <form action="/cart/update/{{$cart_prod->id}}" method="post" data-parsley-validate="" class="row">
                                        {!!Form::token()!!}
                                        <div class="col-12 col-lg-4">
                                          {{--
                                            @if($cart_prod->original_price != null)
                                                <label style="text-decoration: line-through;"><span class="d-block d-lg-none" style="text-decoration: line-through;">Price</span>R {{ $cart_prod->original_price }}</label>
                                                <label style="color: #ce0000; font-weight: 600;
                                                position: relative;
                                                top: -20px;"><span class="d-block d-lg-none">Price</span>R {{ number_format($cart_prod->price, 0)}} </label>
                                            @else
                                                <label><span class="d-block d-lg-none">Price</span>R {{ number_format($cart_prod->price, 0)}} </label>
                                            @endif
                                          --}}
                                            <label><span class="d-block d-lg-none">Price</span>R {{ number_format(($cart_prod->price), 0) }}</label>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <span class="d-block d-lg-none prod-label">Qty</span>
                                            <div class="input-append spinner" data-trigger="spinner">
                                                <input type="text" value="{{$cart_prod->quantity}}" name="quantity" data-rule="quantity" class="checkout-quantity-input">
                                                <div class="add-on">
                                                    <a href="javascript:;" class="spin-up" data-spin="up">
                                                        <i class="fa fa-caret-up"></i>
                                                    </a>
                                                    <a href="javascript:;" class="spin-down" data-spin="down">
                                                        <i class="fa fa-caret-down"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <label><span class="d-block d-lg-none">Total</span>R {{number_format(($cart_prod->price*$cart_prod->quantity), 0)}} </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12 offset-md-12 order-continue-row p-0">
                        <div class="float-right">
                            <span>We accept:</span>
                            @foreach($payment_options as $payment_option)
                                <a href="{{$payment_option->link}}" target="_blank" title="{{$payment_option->title}}">
                                    <img src="/{{$payment_option->link_image}}" alt="{{$payment_option->title}}" class="img-fluid" />
                                </a>
                            @endforeach
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>

          <!-- Order Summary -->
            {{--  
            @include( 'templates.checkout.new_order_summary' )
            --}}
            <div class="col-12 col-lg-3 custom-checkout-padding">
                <div class="row">
                    <div class="col-12 payment-order-summary pre-payment">
                        <h2>Order Summary:</h2>
                        @php
                        if( ($cart_products != NULL || isset( $cart_products )) && count( $cart_products ) > 0 ):
                            $cart_total = $cart_products->sum( 'quantity' );
                        endif;
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
                        
                        <p class="text-right"><span>Subtotal Cost:</span> R {{ number_format(($total_cost), 0) }}</p>
                        @if($discountTotal > 0)
                          <p class="text-right"><span>Discount:</span> -R {{ number_format(($discountTotal), 0) }}</p>
                        @endif
                        @if($couponTotal > 0)
                          <p class="text-right"><span>Coupon:</span> -R {{ number_format(($couponTotal), 0) }}</p>
                        @endif

                        <p class="text-right" style="border-top:1px solid #333;">
                          <span class="font-weight-bold">Total</span> 
                          R {{ number_format(($cart->subtotal), 0) }}
                        </p>


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
        </div>
    </div>

    @include('templates.tab_open_check')
@endsection

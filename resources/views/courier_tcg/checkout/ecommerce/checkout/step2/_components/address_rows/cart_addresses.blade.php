<div class="col-12 cart-addresses">
    <div class="row">
        <div class="col-12 p-0 user-address-select">
            <h1>Select Shipping Address</h1>
            <span>
                Billing Address the same as my shipping address 
                <i class="fa fa-check-circle active" aria-hidden="true"></i>
            </span>
        </div>
        <div class="col-12 user-addresses shipping-addresses">
            <div class="row">
            @foreach($user_addresses as $user_address)
                <div class="col-12 p-0 address-info" data-addressid="{{$user_address->id}}">
                    <h1 class="col-12">
                        <a class="delete-address float-left confirm-delete" href="/address/delete/{{$user_address->id}}">
                            <i class="fa fa-trash"></i>
                        </a>
                        {{$user_address->address_name}}
                        @if($user_address->default_address == 1)
                            @php $shippingid = $user_address->id; @endphp
                            <i class="fa fa-check-circle active" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        @endif
                        <span>Use this address</span>
                    </h1>
                    <div class="col-12">
                        <div class="col-12 col-md-6 float-left">
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">First Name:</p>
                                    <p class="col-12 col-md-6">{{$user_address->name}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Company Name:</p>
                                    <p class="col-12 col-md-6">{{$user_address->company}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">VAT Number:</p>
                                    <p class="col-12 col-md-6">{{$user_address->vat_number}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Surburb:</p>
                                    <p class="col-12 col-md-6">{{$user_address->suburb}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Province / State:</p>
                                    <p class="col-12 col-md-6">{{$user_address->province}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Postal Code:</p>
                                    <p class="col-12 col-md-6">{{$user_address->postal_code}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 float-left">
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Last Name:</p>
                                    <p class="col-12 col-md-6">{{$user_address->surname}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Street Address:</p>
                                    <p class="col-12 col-md-6">{{$user_address->address_line_1}},
                                        {{$user_address->address_line_2}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">City / Town:</p>
                                    <p class="col-12 col-md-6">{{$user_address->city}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Country:</p>
                                    <p class="col-12 col-md-6">{{$user_address->country}}</p>
                                </div>
                            </div>
                            <div class="col-12 p-0">
                                <div class="row">
                                    <p class="col-12 col-md-6">Phone Number:</p>
                                    <p class="col-12 col-md-6">{{$user_address->phone}}</p>
                                </div>
                            </div>
                            <span class="col-12 text-right">May be printed on the label to assist
                                delivery</span>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="col-12 p-0 user-address-select billing-hide">
            <h1>Select Billing Address</h1>
        </div>
        <div class="col-12 p-0 user-addresses billing-addresses billing-hide">
        @foreach($user_addresses as $user_address)
            <div class="col-12 p-0 address-info" data-addressid="{{$user_address->id}}">
                <h1>
                    <a class="delete-address float-left confirm-delete" href="/address/delete/{{$user_address->id}}">
                        <i class="fa fa-trash"></i>
                    </a>
                    {{ $user_address->address_name }}
                    @if ( $user_address->default_address == 1 )
                        <?php $billingid = $user_address->id; ?>
                        <i class="fa fa-check-circle active" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-circle" aria-hidden="true"></i>
                    @endif
                    <span>Use this address</span>
                </h1>
                <div class="col-12">
                    <div class="col-12 col-md-6 float-left">
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">First Name:</p>
                                <p class="col-12 col-md-6">{{$user_address->name}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Company Name:</p>
                                <p class="col-12 col-md-6">{{$user_address->company}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">VAT Number:</p>
                                <p class="col-12 col-md-6">{{$user_address->vat_number}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Surburb:</p>
                                <p class="col-12 col-md-6">{{$user_address->suburb}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Province / State:</p>
                                <p class="col-12 col-md-6">{{$user_address->province}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Postal Code:</p>
                                <p class="col-12 col-md-6">{{$user_address->postal_code}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 float-left">
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Last Name:</p>
                                <p class="col-12 col-md-6">{{$user_address->surname}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Street Address:</p>
                                <p class="col-12 col-md-6">{{$user_address->address_line_1}},
                                    {{$user_address->address_line_2}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">City / Town:</p>
                                <p class="col-12 col-md-6">{{$user_address->city}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Country:</p>
                                <p class="col-12 col-md-6">{{$user_address->country}}</p>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="row">
                                <p class="col-12 col-md-6">Phone Number:</p>
                                <p class="col-12 col-md-6">{{$user_address->phone}}</p>
                            </div>
                        </div>
                        <span class="col-12 text-right">May be printed on the label to assist
                            delivery</span>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <div class="col-12 p-0 add-address">
            <a href="#" class="text-center float-left">
                <i class="fa fa-plus mr-lg-2 mr-3"></i>
                <strong>address</strong>
            </a>
        </div>
    </div>
</div>

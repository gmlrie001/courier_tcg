@php
  $noWeights        = [];
  $shipping_options = [];
  $shipping_error   = NULL;

  $option = $shipperOpt;
  $shipping_options[$shipper] = $option;
@endphp

@if( $shipper && preg_match( "/default/isU", $shipper, $m ) )
  @forelse( $shipping_options as $key=>$option )
  <div class="row no-gutters py-lg-1 py-2 courier-{{ $key }} @if( count( $noWeights ) > 0 ) striken @endif">

    @if ( is_array( $option ) ) @php $option = (object) $option; @endphp @endif
    <div class="col-12 col-md-1 text-center-lg">
      <input 
        id="{{ camel_case( $key ) }}" type="radio" name="option" value="{{ $option->cost }}" 
        data-description="{{ ucwords( $option->service_type ) }}" 
        data-arrival="{{ $option->expected_delivery_date }}" 
        data-title="{{ $option->title }}" 
        required
      >
      <label for="{{ camel_case( $key ) }}"></label>
    </div>

    @isset( $shipper )
      <div class="col-12 col-md-2">{{ ucwords( $key ) }}</div>
    @endisset

    @isset( $option->service_type )
      <div class="col-12 col-md-4">{{ $option->service_type }}</div>
    @else
      <div class="col-12 col-md-4">Shipping by {{ $key }}</div>
    @endisset

    @isset( $option->expected_delivery_date )
      <div class="col-12 col-md-4">*Delivery Date: {{ $option->expected_delivery_date }}</div>
    @else
      <div class="col-12 col-md-4">*ESTIMATED delivery time is usually between 7-14 working days</div>
    @endisset
      <div class="col-12 col-lg-11 disclaimer my-1 order-last">
        <p style="line-height:inherit;margin:0.5rem auto !important;">
          <small>
            <em class="mr-3">*</em> Indicated <u>ESTIMATED</u> time of arrival or delivery date provided by shipper/courier company. {{ $site_settings->site_name }} cannot be held liable for any changes, delays or damages that may occur during transit.
          </small>
        </p>
      </div>

    @isset( $option->cost )
      <div class="col-12 col-md-1" style="font-size:65%!important;line-height:23px;font-weight:400;">R{{ number_format( $option->cost, 0, '.', '' ) }}</div>
    @endisset

  </div>

  @empty
    @isset ( $shipping_error )
    <section class="col-12">
      @php error( 'Default Shipping Error: ' . $shipping_error ); @endphp
      {{-- OUTPUT the error here --}}
      <h2>Sorry, there seems to have been a problem with your request!</h2>
      <h3>Please go back to step 2, select shipping and billing addresses and continue to retry.</h3>
      <p>{{ $shipping_error }}</p>
    </section>
    @endisset
  @endforelse
@endif

  {{-- <div class="row pt-lg-2 pt-3">
    <div class="col-12 col-md-1 text-center-lg">
      <input id="option_{{$counter}}"
        data-description="{{$area->title}}"
        data-arrival="ESTIMATED {{$area->delivery_time}}"
        data-title="{{$option->shippingOption->title}}"
        type="radio" name="option"
        value="{{ $cost }}" required="" 
      >
      <label for="option_{{$counter}}"></label>
    </div>
    <div class="col-12 col-md-2 strong">{{$option->shippingOption->title}}</div>
    <div class="col-12 col-md-4">{{$area->title}}</div>
    <div class="col-12 col-md-4">ESTIMATED {{ $area->delivery_time }}</div>
    <div class="col-12 col-md-1">R {{ number_format( $cost, 0, '.', '' ) }}</div>
  </div> --}}
  {{-- @endif --}}
{{-- 
  <div class="row pt-lg-2 pt-3">
    <div class="col-12 col-md-1 text-center-lg">
      <input id="option_{{$counter}}" 
        data-description="{{$area->title}}" 
        data-arrival="ESTIMATED {{$area->delivery_time}}" 
        data-title="{{$option->shippingOption->title}}" 
        type="radio" 
        name="option" 
        value="{{number_format($cost, 0, '.', '')}}" 
        required
      >
      <label for="option_{{$counter}}"></label>
    </div>
    <div class="col-12 col-md-2 strong">{{$option->shippingOption->title}}</div>
    <div class="col-12 col-md-4">{{$area->title}}</div>
    <div class="col-12 col-md-4">ESTIMATED {{str_replace( '-', '&ndash;', $area->delivery_time ) }}</div>
    <div class="col-12 col-md-1">R {{number_format($cost, 0, '.', '')}}</div>
  </div>
  @php $counter++; @endphp
@endif --}}

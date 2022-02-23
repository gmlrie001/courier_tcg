@php
  $noWeights        = [];
  $shipping_options = [];
  $shipping_error   = NULL;

  $option = $shipperOpt;
  $shipping_options[$shipper] = $option;
@endphp

@if( $shipper && strtolower( $shipper ) === "aramex" )
  @forelse( $shipping_options as $key=>$option )
  <div class="row no-gutters py-lg-1 py-2 courier-{{ $key }} @if( count( $noWeights ) > 0 ) striken @endif">
    @if ( is_array( $option ) ) @php $option = (object) $option; @endphp @endif
    <div class="col-12 col-md-1 text-center-lg">
      <input id="{{ $key }}" type="radio" name="option" value="{{ $option->cost }}" 
        data-description="{{ $key }} Courier - Service: {{ ucwords( $option->service_type ) }}" 
        data-arrival="ESTIMATED {{ $option->expected_delivery_date }}" 
        data-title="{{ $option->title }}" 
        required
      >
      <label for="{{ $key }}"></label>
    </div>

    @isset( $key )
    <div class="col-12 col-md-2">{{ ucwords( $key ) }}</div>
    @endisset

    @isset( $service_type )
      <div class="col-12 col-md-4">{{ $service_type }}</div>
    @else
      <div class="col-12 col-md-4">Shipping by {{ $key }}</div>
    @endisset

    @isset( $expected_delivery_date )
      <div class="col-12 col-md-4">*Delivery Date: {{ $expected_delivery_date }}</div>
    @else
      <div class="col-12 col-md-4">*ESTIMATED delivery time is usually between 5-7 working days</div>
    @endisset
      <div class="col-12 col-lg-10 offset-lg-1 disclaimer my-1 order-last">
        <p>
          <small>
            <em>*</em> Indicated <u>ESTIMATED</u> time of arrival or delivery date provided by shipper/courier company. {{ $site_settings->site_name }} cannot be held liable for any changes, delays or damages that may occur during transit.
          </small>
        </p>
      </div>

    @isset( $option->cost )
      <div class="col-12 col-md-1" style="font-size:65%!important;line-height:23px;font-weight:400;">R{{ $option->cost }}</div>
    @endisset

    </div>
  </div>
  @empty
    @isset ( $shipping_error )
      @php error( $shipper . " error: " . $shipping_error ); @endphp
      {{-- OUTPUT the error here --}}
      <h2>Sorry, there seems to have been a problem with your request!</h2>
      <h3>Please go back to step 2, select shipping and billing addresses and continue to retry.</h3>
      <p>{{ $shipping_error }}</p>
    @endisset
  @endforelse
@endif

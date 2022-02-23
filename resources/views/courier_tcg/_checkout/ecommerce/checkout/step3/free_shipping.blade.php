@php
  $shipping_options = [];
  $option = $shipperOpt;
  $shipping_options[] = $option;

  dd( get_defined_vars() );
@endphp

@if( $shipper && preg_match( "/free/isU", $shipper, $m ) )
  @forelse( $shipping_options as $key=>$option )
  <div class="row no-gutters py-lg-1 py-2 {{ $shipper }}-{{ $service_type }} @if( count( $noWeights ) > 0 ) striken @endif">
    @if ( is_array( $option ) ) @php $option = (object) $option; @endphp @endif
    <div class="col-12 col-md-1 text-center-lg">
      <input 
        id="{{ camel_case( $shipper ) }}" type="radio" name="option" value="{{ $option->cost }}" 
        data-description="{{ ucwords( $option->service_type ) }}" 
        data-arrival="{{ $option->expected_delivery_date }}" 
        data-title="{{ $option->title }}" 
        data-service="free" 
        required
      >
      <label for="{{ camel_case( $shipper ) }}"></label>
    </div>

    @isset( $shipper )
    <div class="col-12 col-md-2">{{ ucwords( $shipper ) }}</div>
    @endisset

    @isset( $option->service_type )
      <div class="col-12 col-md-4">{{ $option->service_type }}</div>
    @else
      <div class="col-12 col-md-4">Shipping by {{ $shipper }}</div>
    @endisset

    @isset( $option->expected_delivery_date )
      <div class="col-12 col-md-4">*Delivery Date: {{ $option->expected_delivery_date }}</div>
    @else
      <div class="col-12 col-md-4">*ESTIMATED delivery time is usually between 7-14 working days</div>
    @endisset
      <div class="col-12 col-lg-10 offset-lg-1 disclaimer my-1 order-last">
        <p>
          <small>
            <em>*</em> Indicated <u>ESTIMATED</u> time of arrival or delivery date provided by shipper/courier company. {{ $site_settings->site_name }} cannot be held liable for any changes, delays or damages that may occur during transit.
          </small>
        </p>
      </div>

    @isset( $option->shipping_cost )
      <div class="col-12 col-md-1" style="font-size:65%!important;line-height:23px;font-weight:400;">R{{ $option->shipping_cost }}</div>
    @endisset

    </div>
  </div>
  @empty
    @isset ( $shipping_error )
      @php error( 'FREE Shipping Error: ' . $shipping_error ); @endphp
      {{-- OUTPUT the error here --}}
      <h2>Sorry, there seems to have been a problem with your request!</h2>
      <h3>Please go back to step 2, select shipping and billing addresses and continue to retry.</h3>
      <p>{{ $shipping_error }}</p>
    @endisset
  @endforelse
@endif

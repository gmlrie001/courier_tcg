@php
  $noWeights        = [];
  $shipping_options = [];
  $shipping_error   = NULL;

  $shipping_options = $shipperOpt;
@endphp

@push( 'pageStyles' )
<style>
details, label {
  font-family: 'Montserrat', sans-serif;
}
details summary {
  color: #000000;
  font-weight: 700;
  font-size: 14px;
  margin-bottom: 10px;
  margin-top: 1rem;
}
details p, label p, 
details span, label span, 
details strong, label strong, 
details em, label em, 
details u, label u, 
details a, label a,
details div, label div {
  color: #000000;
  font-size: 12px;
  line-height: inherit;
  font-weight: 400;
  margin-bottom: 10px;
}

.shipping-options-list-options input {
  opacity: 0;
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto 0;
}
.shipping-options-list-options label {
  /* display: inline; */
  color: #d0d0d0;
  cursor: pointer;
  font-size: 14px;
  font-family: 'Montserrat', sans-serif;
}
.shipping-options-list-options label {
  position: absolute;
  max-width: 100%;
  width: 100%;
  height: 75px;
  line-height: 45px;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #f0f0f0;
}
.shipping-options-list-options label label {
  padding-top: 0;
  padding-bottom: 0;
  border-bottom: 0;
}
.shipping-options-list-options input[type="radio"] label:before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  font-family: FontAwesome;
  content: "\f111";
}
.shipping-options-list-options input[type="radio"]:checked label:before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  font-family: FontAwesome;
  content: "\f058";
}
@media only screen and (max-width: 992px) {
  .shipping-options-list-options label {
    position: relative !important;
    left: 0;
    height: auto;
    line-height: unset;
    padding-top: 1.5rem !important;
    padding-bottom: 1.5rem !important;
  }
}
</style>
@endpush

@if( $shipper && strtolower( $shipper ) === "ppapi_tcg" )
{{-- <details class="courier-{{ $shipper }}" open> --}}
  {{-- <summary>The Courier Guy Rate Options</summary> --}}

  @forelse( $shipping_options as $key=>$option )
    <label for="courier-option-{{ $key }}" class="row no-gutters py-lg-3 py-2 courier-{{ $shipper }}-options option-{{ $key }} @if( count( $noWeights ) > 0 ) striken @endif position-relative">

      @if ( is_array( $option ) ) @php $option = (object) $option; @endphp @endif

      <div class="col-auto col-md-1 text-center-lg">
        <input id="courier-option-{{ $key }}" type="radio" name="option" value="{{ $option->total }}" 
          data-description="{{ $key }} Courier - Service: {{ ucwords( $option->service ) }}" 
          data-arrival="ESTIMATED {{ $option->duedate }}" 
          data-title="{{ $option->name }}" 
          required
        >
        <label for="courier-option-{{ $key }}"></label>
      </div>

      @isset( $option->service )
        <div class="col col-md-2 font-weight-bold px-4 px-lg-0">{{ ucwords( $option->service ) }}</div>
      @else
        <div class="col col-md-4">Shipping by {{ $key }}</div>
      @endisset

      @isset( $option->name )
        <div class="col-12 col-md-4">The Courier Guy - {{ $option->name }}</div>
      @endisset

      @isset( $option->duedate )
        <div class="col-12 col-md-4">* Delivery Date: {{ $option->duedate }}</div>
      @else
        <div class="col-12 col-md-4">* ESTIMATED delivery time is usually between 5-7 working days</div>
      @endisset

      @isset( $option->total )
        <div class="col-12 col-md-1" style="font-size:82.5%;line-height:inherit;font-weight:600;">R {{ number_format( $option->total, 0, '.', '' ) }}</div>
      @endisset

    </label>

  @empty
    @isset ( $shipping_error )
      @php error( $shipper . " error: " . $shipping_error ); @endphp
      {{-- OUTPUT the error here --}}
      <h2>Sorry, there seems to have been a problem with your request!</h2>
      <h3>Please go back to step 2, select shipping and billing addresses and continue to retry.</h3>
      <p>{{ $shipping_error }}</p>
    @endisset
  
  @endforelse

  <div class="row no-gutters pt-lg-3 pt-2 disclaimer">
    <div class="col-12 disclaimer mt-2 order-last">
      <p style="font-family:'Montserrat',sans-serif;font-size:0.75rem;line-height:1.618;margin-bottom:0;">
        <small style="font-weight:600;">
          <em>*</em> Indicated <u>ESTIMATED</u> time of arrival or delivery date provided by shipper/courier company. 
          {{ $site_settings->site_name }} cannot be held liable for any changes, delays or damages that may occur during transit.
        </small>
      </p>
    </div>
  </div>

{{-- </details> --}}
@endif

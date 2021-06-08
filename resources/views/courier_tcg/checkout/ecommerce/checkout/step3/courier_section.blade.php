@if ( NULL != $shipper && $shipper )
  @if( $aramex_shipping_cost )
  {{-- && count( $noWeights ) == 0)--}}
    {{--  1<div class="row">  --}}
        {{--  2<div class="col-12">  --}}
        <div class="row no-gutters pt-lg-2 pt-3 @if( count( $noWeights ) > 0 ) striken @endif">
          <div class="col-12 col-md-1 text-center-lg">
            <input id="aramex"
              type="radio" 
              name="option" 
              data-description="Aramex Courier - Service: {{ $service_type }}" 
              data-arrival="ESTIMATED {{ $expected_delivery_date }}" 
              data-title="Aramex" 
              value="{{ $aramex_shipping_cost }}" 
              required
            >
            <label for="aramex"></label>
          </div>
          <div class="col-12 col-md-2">{{ ucwords( $shipper ) }}</div>
          @isset( $service_type )
            <div class="col-12 col-md-4">{{ $service_type }}</div>
          @else
            <div class="col-12 col-md-4">Shipping by Aramex</div>
          @endisset
          @isset( $expected_delivery_date )
            <div class="col-12 col-md-4">*Delivery Date: {{ $expected_delivery_date }}</div>
          @else
            <div class="col-12 col-md-4">*ESTIMATED 5&ndash;7 working days</div>
          @endisset
            <div class="col-12 disclaimer my-1 order-last">
              <p><small><em>*</em> Indicated <u>ESTIMATED</u> time of arrival or delivery date provided by shipper/courier company. {{ $site_settings->site_name }} cannot be held liable for any changes, delays or damages that may occur during transit.</small></p>
            </div>
            <div class="col-12 col-md-1" style="font-size:65%!important;line-height:23px;font-weight:400;">R {{ number_format( $aramex_shipping_cost ?? 0, 2, ".", "" ) }}</div>
          </div>
        </div>
        {{--  2</div>  --}}
    {{--  1</div>  --}}
  @endif
@endif

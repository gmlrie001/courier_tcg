@php
if( ! function_exists( 'checkout_deductions' ) ) {
  function checkout_deductions($subTotal, $value=0, $type=NULL)
  {
    if( !isset( $subTotal ) || $subTotal == NULL ): return number_format( float( 0.0 ), 2 , '.', '' ); endif;

    if( $type != NULL || $type ):
      if( $type == 0 ) {
        $percentOff  = ( $value > 1 && $value <= 100 ) ? $value * 0.01 : $value;
        $deductValue = $subTotal * $percentOff;
      } else {
        $deductValue = ( $value == 0 ) ? 0 : $value;
      }
    endif;

    $subTotal -= $deductValue;

    // Return an array containing the NEW subTotal and the deducted values.
    return [number_format( $subTotal, 2, '.', '' ), $deductValue];
  }
}

if (! function_exists('checkout_deductions_initialize')) {
  function checkout_deductions_initialize($key, $value=0)
  {
    if( ! isset( $key ) || ! $key )
  }
}

@endphp 
<div class="col-12 full-width my-0 py-3">
  {!! Honeypot::generate( 'my_name', 'my_time' ) !!}

  {!! Form::button( 
    'Save changes', 
    [
      'type'  => 'submit', 
      'class' => 'py-0 mb-lg-4 mb-3', 
      'style' => 'line-height: 40px !important;'
    ] 
  ) !!}
</div>

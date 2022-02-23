<div class="form-group">
    <label class="col-12">Country*</label>
    {!! Form::select(
        'country', 
        $countries,
        ([
            'placeholder' => 'Country', 
            'class'       => 'col-xs-12',
            'readonly'    => !1,
            'required'    => '', 
        ])
    ) !!}
</div>

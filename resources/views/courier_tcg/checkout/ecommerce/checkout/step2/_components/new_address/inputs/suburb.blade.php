@if ( $config['aramex_shipping_enable'] )
<div class="form-group" data-verify-provider="aramex">
    <label class="col-12" for="suburb">Suburb*</label>
    <input name="suburb" placeholder="Suburb" class="col-12" id="suburb" list="suburbia" autocomplete="off" required />
    <datalist id="suburbia"></datalist>
</div>

<script id="aramex-postal-code-validation" type="text/javascript">
/**
 * // keys should match input's parent data-verify-provider value.
 * // Example valid values for key: aramex |OR| pp_tcg |OR| ...
 */
var verificationUrls = {
  'aramex': '/user/address/verify',
  'pp_tcg': '/user/address/verify/provider/pp_tcg',
};

$( document ).ready( function () {
  $( "#add-address" ).on("submit", function (event) {
    event.preventDefault();

    var formValues = $( this ).serialize();

    if ( ! formValues.has( '_token' ) )
      formValues.append( '_token', {{ csrf_token() }} );

    if ( $( "#add-address input[name=suburb]" ).val() === "" )
      $( "#add-address input[name=suburb]" ).val( "suburb" );

    var provider  = $( '.form-group[data-verify-provider]' );
    var verifyUri = verificationUrls[provider];
    $.post( verifyUri, formValues, function ( data ) {
      var parsedData = JSON.parse( data );

      if ( parsedData.status !== undefined && parsedData.status ) {
        $.post( "/user/address/add", formValues, function ( data ) {
          $(this).submit();

          return window.location.reload();
        });

      } else {
        var suburbList = parsedData;

        if ( suburbList ) {
          var dlist = $( "datalist#suburbia" );
          
          $( "#add-address input[name=suburb]" ).val( '' );
          $( "#add-address input[name=suburb]" ).attr(
            'style',
            'box-shadow: 0 0 1px 5px rgb( 250 0 0 / 37.5% ); border-radius: 0.125em;'
          );

          $.each( suburbList, function ( i, item ) {
            dlist.append(
              $( "<option>" ).attr( 'value', item )
            );
          });

          unset( suburbList );
        }
      }

      return;
    });

  });
});
</script>

{{--
<!-- Use PP_TCG API postal-code and namelookup functionality -->
@elseif ( $config['ppapi_tcg_shipping_enable'] )
    <label class="col-12" for="suburb">Suburb*</label>
    <input name="suburb" placeholder="Suburb" class="col-12" id="suburb" list="suburbia" autocomplete="off" required />
    <datalist id="suburbia"></datalist>
</div>

<script id="ppapi_tcg-postal-code-validation" type="text/javascript">
$(document).ready(function () {
    $("#add-address").on("submit", function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();

        if ($("#add-address input[name=suburb]").val() === "") $("#add-address input[name=suburb]").val("suburb");

        $.post("/user/address/verify", formValues, function (data) {
            var parsedData = JSON.parse(data);

            if (parsedData.status !== 'undefined' && parsedData.status) {
                $.post("/user/address/add", formValues, function (data) {
                    $(this).submit();
                    
                    return window.location.reload();
                });

            } else {
                var suburbList = parsedData;

                if (suburbList) {
                    var dlist = $("datalist#suburbia");
                    $("#add-address input[name=suburb]").val("");
                    $("#add-address input[name=suburb]").attr(
                        'style',
                        'box-shadow: 0 0 1px 5px rgb( 250 0 0 / 37.5% ); border-radius: 0.125em;'
                    );
                    $.each(suburbList, function (i, item) {
                        dlist.append($("<option>").attr('value', item));
                    });
                }
                
                return;
            }
        });
    });
});
</script>
--}}

@else
<div class="form-group">
    <label class="col-12" for="suburb">Suburb*</label>
    <input name="suburb" placeholder="Suburb" class="col-12" id="suburb" list="suburbia" autocomplete="off" required />
</div>
@endif

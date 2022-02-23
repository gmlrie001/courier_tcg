<div class="form-group">
    <label class="col-12" for="suburb">Suburb*</label>
    <input name="suburb" placeholder="Suburb" class="col-12" id="suburb" list="suburbia" autocomplete="off" required />
    <datalist id="suburbia"></datalist>
</div>

<script>
    $(document).ready(function () {

        $("#add-address").on("submit", function (event) {
            event.preventDefault();
            var formValues = $(this).serialize();

            if ($("#add-address input[name=suburb]").val() === "") $("#add-address input[name=suburb]")
                .val("suburb");

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

<div class="col-12 available-coupons">
  <h2>Use Store Credit?</h2>
</div>
<div class="col-12 store-credit">
  <span>R 0</span>
  <div id="slider"></div>
  <span class="text-right">R {{number_format($walletTotal, 0, ",", ".")}}</span>
  <i class="store-credit-value">Value: R {{number_format($creditTotal, 0, ",", ".")}}</i>
</div>
<div class="col-12 apply-store-credit">
  <span>APPLY</span>
</div>
<input type="text" name="store-credit-input" style="display:none;" id="amount" value="0">

<script>
  $(function () {
    $("#slider").slider({
      range: "max",
      min: 0,
      step: 1,
      max: {{ number_format($walletTotal, 0, "", "") }},
      value: {{ number_format($creditTotal, 0, "", "") }},
      slide: function (event, ui) {
        $("#amount").val(ui.value);
        $(".store-credit-value").text('Value: R ' + ui.value);
      }
    });
  });

  $(".apply-store-credit span").click(function () {
    window.location.replace("/store/credit/" + $("#amount").val());
  });
</script>

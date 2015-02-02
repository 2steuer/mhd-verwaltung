$("#fetch_barcode_link").click(function() {
    var field = $("#Barcode input");

    var fetch = true;

    if(field.val() != '') {
        fetch = confirm("Barcode überschreiben?");
    }

    $.get("$AjaxBarcodeUrl", function(data) {
            field.val(data.barcode);
        }, "json");

    return false;
});

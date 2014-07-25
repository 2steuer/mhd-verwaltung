$(document).ready(function() {
    $("#Barcode input:not(#quick_add_form #Barcode input)").bind("keyup keypress", function(e) {
        var code = e.keyCode;
        if (code  == 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#quick_add_form #Barcode input").focus()
});
$("#all_link").click(function() {
    $(".selectprintBox").each(function() {
        $(this).prop('checked', true);
    });
    return false;
});

$("#none_link").click(function() {
    $(".selectprintBox").each(function() {
        $(this).prop('checked', false);
    });
    return false;
});

$("#generate_barcode_pdf_link").click(function() {
   $("#check_resource_form").submit();

    return false;
});

$("#print_single_bc").click(function() {
   $("#single_bc_form").submit();

    return false;
});
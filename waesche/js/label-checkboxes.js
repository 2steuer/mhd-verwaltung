$(document).ready(function() {
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

	$("#print_link").click(function() {
        $("#form-destination").val('printlabels');
		$("#print_label_checkform").submit();
		return false;
	});

    $("#print_change_request").click(function() {
       $("#form-destination").val("printchangerequest");
        $("#print_label_checkform").submit();
        return false;
    });
});
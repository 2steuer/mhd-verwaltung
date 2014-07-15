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
		$("#print_label_checkform").submit();
		return false;
	});
});
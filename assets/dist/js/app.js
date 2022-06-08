$(document).ready(function(){

	$('input[data-type="datepicker"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 1901,
		maxYear: parseInt(moment().format('YYYY'), 10)
	});

	$('#show-pwd').click(function(){
		var box = $("#pwd");
		if(box.attr("type") == "password") {
			box.attr("type", "text");
		} else {
			box.attr("type", "password");
		}
	});

	$('[data-widget="pushmenu"]').on('click', function () {
		$('[data-widget="pushmenu"]').PushMenu('toggle');
	});

	$('[data-widget="pushmenu"]').click(function(){
		$('.main-sidebar').PushMenu('toggle');
	});

	$("input[data-bootstrap-switch]").each(function(){
    	$(this).bootstrapSwitch('state', $(this).prop('checked'));
  	});
});

function calculateConversion(value1, value2, answerInput) {
	var total               				= isNaN(parseInt(value1/value2)) ? 0 : ((value1/value2)*100).toFixed(1);
	$(answerInput).val(total);
}


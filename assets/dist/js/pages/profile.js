
	var display = false;

	$('#toggleHidden').click(function(e) {
		e.preventDefault();
		display = !display; // default is false, because they are not shown.
		fields = $('[id^=pass]')
		type = (display) ? 'text' : 'password'
		if (display) {
			$(this).text('Hide Password');
		} else {
			$(this).text('Show Password');
		}
		$.each(fields, function(indexInArray, valueOfElement) {
			$(this).attr("type", type);
		});
	});

	$('#FRM_passwordReset').on('submit', function(e) {
		passedTest = true;
		errMsg = [];
		pass1 = $('#pass1').val();
		pass2 = $('#pass2').val();

		if (pass1.length < 8) {
			passedTest = false;
			errMsg.push('Password must be at least 8 Characters.')
		}

		if (pass1 != pass2) {
			passedTest = false;
			errMsg.push('Password do not match.')
		}

		if (passedTest) {
			return true;
		} else {
			alert(errMsg);
			return false;
		}
	});

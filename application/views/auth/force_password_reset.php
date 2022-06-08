<div class="container">
	<div class="col-lg-4 col-md-6 ml-auto mr-auto">
		<form class="form" method='post' action="<?= site_url('auth/login/savePassword') ?>" id='FRM_passwordReset'>
			<input type="hidden" name="sessionID" value='<?= session_id() ?>'>
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<div class="card card-login card-black">
				<div class="card-header">
					<img src="/assets/bdp/assets/img/card-primary.png" alt="">
					<h1 class="card-title">New Password</h1>
				</div>
				<div class="card-body">
					<label>
						New Password
					</label>
					<input name='password1' id='password1' type="password" class="form-control form-control-lg" required=true>

					<label>
						Confirm Password
					</label>
					<input name='password2' id='password2' type="password" class="form-control form-control-lg" required=true>

				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Change Password</button>
					<div class="pull-right">
						<h6>
							<a href="#" id="toggleHidden" class="link footer-link">Show/Hide Password</a>
						</h6>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	var display = false;

	$('#toggleHidden').click(function(e) {
		e.preventDefault();
		display = !display; // default is false, because they are not shown.
		fields = $('[id^=password]')
		type = (display) ? 'text' : 'password'
		$.each(fields, function(indexInArray, valueOfElement) {
			$(this).attr("type", type);
		});
	});

	$('#FRM_passwordReset').on('submit', function(e) {

		passedTest = true;
		errMsg = [];
		pass1 = $('#password1').val();
		pass2 = $('#password2').val();

		if (pass1.length < 9) {
			passedTest = false;
			errMsg.push('Password must be at least 8 Characters.')
		}

		if (pass1 != pass2) {
			passedTest = false;
			errMsg.push('Password do not match.')
		}
		if (passedTest) {
			return true;
		}
		else
		{
			return false;
			alert(errMsg);
		}
	});

</script>

<div class="container">
	<div class="col-lg-4 col-md-6 ml-auto mr-auto">
		<form class="form" method='post' action="<?= site_url('auth/login/validate_challenge') ?>">
			<input type="hidden" name="sessionID" value='<?= session_id() ?>'>
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<div class="card card-login card-black">
				<div class="card-header">
					<img src="/assets/bdp/assets/img/card-primary.png" alt="">
					<h1 class="card-title">Challenge Accepted</h1>
				</div>
				<div class="card-body">
					<label>
						<?= $this->authuser->getChallengeQuestion($user->question1); ?>
					</label>
						<input name='question1_answer' id='question1_answer' type="password" class="form-control form-control-lg" required=true>


					<label>
						<?= $this->authuser->getChallengeQuestion($user->question2); ?>
					</label>
						<input name='question2_answer' id='question2_answer' type="password" class="form-control form-control-lg" required=true>


				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Validate Answers</button>
					<div class="pull-right">
						<h6>
							<a href="#" id="toggleHidden" class="link footer-link">Show/Hide Answers</a>
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
		display = !display;		// default is false, because they are not shown.
		fields = $('[id$=answer]')
		type = (display) ? 'text' : 'password'
		$.each(fields, function(indexInArray, valueOfElement) {
			$(this).attr("type", type);
		});
	});
</script>

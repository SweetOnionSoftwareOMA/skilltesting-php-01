<div class="container">
	<div class="col-lg-4 col-md-6 ml-auto mr-auto">
		<form class="form" method='post' action="<?= site_url('auth/login/challenge_questions') ?>">
			<input type="hidden" name="sessionID" value='<?= session_id() ?>'>
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<div class="card card-login card-black">
				<div class="card-header">
					<img src="/assets/bdp/assets/img/card-primary.png" alt="">
					<h1 class="card-title">Verified</h1>
				</div>
				<div class="card-body">
				</div>
				<div class="card-footer">
					<div class="card-description">
						<p>
							In the next step you will be asked for the answer to your security questions. If you don't remember the answers,
							please contact your MTM representative for assistance.
						</p>
					</div>
					<br><br>
					<button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Answer Challenge Questions</button>
				</div>
			</div>
		</form>
	</div>
</div>

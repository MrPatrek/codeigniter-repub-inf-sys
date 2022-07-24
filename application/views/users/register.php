<?= validation_errors('

<div class="row justify-content-center">
	<div class="alert alert-dismissible alert-warning col-lg-3">
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		<!-- <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again. -->
		<strong>Warning! </strong>

', '

	</div>
</div>

'

) ?>



<?= form_open('register') ?>

	<div class="row justify-content-center">
		<div class="col-lg-4">
			
			<h2 class="text-center my-3"><?= $title ?></h2>

			<div class="form-group form-floating my-2">
				<input type="text" class="form-control" id="floatingFName" placeholder="First name" name="f_name">
				<label for="floatingFName">First name</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="text" class="form-control" id="floatingLName" placeholder="Last name" name="l_name">
				<label for="floatingLName">Last name</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="text" class="form-control" id="floatingUsername" placeholder="Username" name="username">
				<label for="floatingUsername">Username</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm password" name="password_confirm">
				<label for="floatingPasswordConfirm">Confirm password</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" name="email">
				<label for="floatingEmail">Email</label>
			</div>

			<div class="d-grid">
				<button type="submit" class="btn btn-lg btn-secondary">Register</button>
			</div>

		</div>
	</div>

<?= form_close() ?>
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



<?= form_open('login') ?>

	<div class="row justify-content-center">
		<div class="col-lg-4">
			
			<h2 class="text-center my-3"><?= $title ?></h2>

			<div class="form-group form-floating my-2">
				<input type="text" class="form-control" id="floatingUsername" placeholder="Username" name="username">
				<label for="floatingUsername">Username</label>
			</div>

			<div class="form-group form-floating my-2">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="d-grid">
				<button type="submit" class="btn btn-lg btn-secondary">Log in</button>
			</div>

		</div>
	</div>

<?= form_close() ?>
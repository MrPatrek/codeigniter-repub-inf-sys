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



<?= form_open('create') ?>

	<div class="row">

		<h2 class="text-center my-3"><?= $title ?></h2>

		<div class="form-group my-2 lead">
			<label class="form-label" for="reportTitle">Title</label>
			<input type="text" class="form-control" placeholder="Title" id="reportTitle" name="title">
		</div>

		<div class="form-group my-2 lead">
			<label for="selectCategory" class="form-label">Category</label>
			<select class="form-select" id="selectCategory" name="category_id">
				<option disabled selected value></option>
				<?php foreach($categories as $category) : ?>
					<option value="<?= $category['id']?>"><?= $category['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group my-2 lead">
			<label for="editor1" class="form-label">Statement</label>
			<textarea class="form-control" id="editor1" rows="3" name="body"></textarea>
		</div>

		<div class="mt-2 lead">
			<button type="submit" class="btn btn-secondary">Publish</button>
		</div>

	</div>

<?= form_close() ?>
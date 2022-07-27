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



<?= form_open('answer/'.$report['id']) ?>

	<div class="row">

		<h2 class="text-center my-3"><?= $title ?></h2>

		<div class="form-group my-2 lead">
			<label for="selectDecision" class="form-label">Decision</label>
			<select class="form-select" id="selectDecision" name="decision">
				<option disabled selected value></option>
					<option value="0">NOT APPROVED</option>			<!-- It's like a boolean FALSE (because of MySQL boolean data type) -->
					<option value="1">APPROVED</option>				<!-- It's like a boolean True -->
			</select>
		</div>

		<div class="form-group my-2 lead">
			<label for="editor1" class="form-label">Explanation</label>
			<textarea class="form-control" id="editor1" rows="3" name="body"></textarea>
		</div>

		<div class="mt-2 lead">
			<button type="submit" class="btn btn-secondary">Publish</button>
		</div>

	</div>

<?= form_close() ?>
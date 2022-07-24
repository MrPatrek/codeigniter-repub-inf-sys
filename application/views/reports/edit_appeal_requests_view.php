<div class="lead">
	<h2 class="mb-3"><?= $title ?></h2>

	<a class="btn btn-primary mb-2" href="<?= site_url('reports/'.$appeal['report_id']) ?>">Original report page</a>

	<div class="alert alert-light">
		<span class="badge bg-light">Old statement</span>
		<p><?= $appeal['body'] ?></p>
		<hr>
		<span class="badge bg-warning">New statement</span>
		<p><?= $appeal['new_body'] ?></p>
	</div>

	<a class="btn btn-success" href="<?= site_url('approve-appeal-edit/'.$appeal['edit_id']) ?>">Approve</a>
	<a class="btn btn-danger" href="<?= site_url('disapprove-appeal-edit/'.$appeal['edit_id']) ?>">Disapprove</a>

</div>
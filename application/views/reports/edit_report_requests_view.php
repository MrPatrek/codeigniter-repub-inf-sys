<div class="lead">
	<h2 class="mb-3"><?= $title ?></h2>

	<a class="btn btn-primary mb-2" href="<?= site_url('reports/'.$report['id']) ?>">Original report page</a>

	<div class="alert alert-light">
		<p class="my-0"><span class="badge bg-light">Old title</span> <?= $old_report['title'] ?></p>
		<hr>
		<p class="my-0"><span class="badge bg-warning">New title</span> <?= $report['new_title'] ?></p>
	</div>

	<div class="alert alert-light">
		<p class="my-0"><span class="badge bg-light">Old category</span> <?= $old_report['cat_name'] ?></p>
		<hr>
		<p class="my-0"><span class="badge bg-warning">New category</span> <?= $report['cat_name'] ?></p>
	</div>

	<div class="alert alert-light">
		<span class="badge bg-light">Old statement</span>
		<p><?= $old_report['body'] ?></p>
		<hr>
		<span class="badge bg-warning">New statement</span>
		<p><?= $report['new_body'] ?></p>
	</div>

	<a class="btn btn-success" href="<?= site_url('approve-report-edit/'.$report['edit_id']) ?>">Approve</a>
	<a class="btn btn-danger" href="<?= site_url('disapprove-report-edit/'.$report['edit_id']) ?>">Disapprove</a>

</div>
<div class="lead">
	<h2 class="mb-3"><?= $title ?></h2>
	
	<?php foreach($reports as $report) : ?>
		<div class="alert alert-secondary">
			<h4 class="alert-heading"><?= $report['title'] ?></h4>
			<p class="mb-0"><?= word_limiter($report['body'], 50) ?></p>
			<br>
			<a class="btn btn-info" href="<?= site_url('delete-requests/'.$report['delete_id']) ?>">Continue</a>
			<p class="my-css-float-right"><small><em>Published on <strong><?= date_format(date_create($report['created_at']), 'd.m.Y (H:i)') ?></strong> in </em></small><span class="badge bg-primary"><?= $report['cat_name'] ?></span></p>
		</div>
	<?php endforeach; ?>
</div>
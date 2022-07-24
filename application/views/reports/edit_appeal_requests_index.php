<div class="lead">
	<h2 class="mb-3"><?= $title ?></h2>
	
	<?php foreach($appeals as $appeal) : ?>
		<div class="alert alert-secondary">
			<p class="mb-0"><?= word_limiter($appeal['body'], 50) ?></p>
			<br>
			<a class="btn btn-info" href="<?= site_url('edit-appeal-requests/'.$appeal['edit_id']) ?>">Check</a>
			<p class="my-css-float-right"><small><em>Published on <strong><?= date_format(date_create($appeal['created_at']), 'd.m.Y (H:i)') ?></strong></em></small></p>
		</div>
	<?php endforeach; ?>
</div>
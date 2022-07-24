<div class="lead">
	<h2 class="mb-3"><?= $title ?></h2>
	<div class="alert alert-light">
		<p class="mb-0"><?= $report['body'] ?></p>
		<br>
		<p class="my-css-float-right"><small><em>Published by <strong><a href="<?= site_url() ?><?php echo 'profile/' ?><?= $user_info['id'] ?>"><?= $user_info['f_name'] ?> <?= $user_info['l_name'] ?></a></strong> (complaintant)<br>on <strong><?= date_format(date_create($report['created_at']), 'd.m.Y (H:i)') ?></strong> in </em></small><span class="badge bg-primary"><?= $report['cat_name'] ?></span></p>
	</div>

	<?php

	$answers_len = sizeof($answers);
	$appeals_len = sizeof($appeals);
	$loop_len = max($answers_len, $appeals_len);

	for ($i = 0; $i < $loop_len; $i++) {

		if (array_key_exists($i, $answers)) : ?>

			<!-- Answers HTML block -->
			<div class="alert alert-primary">
				<h3>Authorities' answer</h3>
				<h5>Decision: <?php if ($answers[$i]['decision'] == false) echo '<span class="badge bg-danger">NOT APPROVED</span>'; else echo '<span class="badge bg-success">APPROVED</span>'; ?></h5>
				<p class="mb-0"><?= $answers[$i]['body'] ?></p>
				<br>
				<p class="my-css-float-right"><small><em>Published by <strong><a href="<?= site_url() ?><?php echo 'profile/' ?><?= $answers[$i]['authorities_id'] ?>"><?= $answers[$i]['f_name'] ?> <?= $answers[$i]['l_name'] ?></a></strong><br>on <strong><?= date_format(date_create($answers[$i]['created_at']), 'd.m.Y (H:i)') ?></strong></em></small></p>
			</div>


		<?php endif;

		if (array_key_exists($i, $appeals)) : ?>

			<!-- Appeals HTML block -->
			<div class="alert alert-light">
				<h3>Citizen's appeal/addition</h3>
				<p class="mb-0"><?= $appeals[$i]['body'] ?></p>
				<br>
				<p class="my-css-float-right"><small><em>Published by the <a href="<?= site_url() ?><?php echo 'profile/' ?><?= $user_info['id'] ?>">complaintant</a><?php if ($this->session->userdata('login_status') && $this->session->userdata('id') === $report['citizen_id']) echo "<strong> (you)</strong>"; ?><br>on <strong><?= date_format(date_create($appeals[$i]['created_at']), 'd.m.Y (H:i)') ?></strong></em></small></p>
			</div>

		<?php endif;

	}

	?>

	<a class="btn btn-success" href="<?= site_url('approve-delete/'.$report['delete_id']) ?>">Approve Delete</a>
	<a class="btn btn-danger" href="<?= site_url('disapprove-delete/'.$report['delete_id']) ?>">Disapprove Delete</a>

</div>
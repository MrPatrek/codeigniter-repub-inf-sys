<div class="lead">
	<h2 class="mb-3"><?= $user_info['f_name'] ?> <?= $user_info['l_name'] ?></h2>
	<div class="alert alert-info">
		<p><span class="badge bg-light">ID</span> <?= $user_info['id'] ?></p>
		<p><span class="badge bg-light">First name</span> <?= $user_info['f_name'] ?></p>
		<p><span class="badge bg-light">Last name</span> <?= $user_info['l_name'] ?></p>
		<p><span class="badge bg-light">Email</span> <a href="mailto:<?= $user_info['email'] ?>"><?= $user_info['email'] ?></a></p>
		<p><span class="badge bg-light">Registration date</span> <?= $user_info['registered_at'] ?></p>
		<p>
			<span class="badge bg-light">Roles</span>
			<ul style="list-style-type:square;">

				<?php if ($citizen_mode) : ?>
					<li>Citizen</li>
				<?php endif; ?>

				<?php if ($authorities_mode) : ?>
					<li>Authorities</li>
				<?php endif; ?>

				<?php if ($moderator_mode) : ?>
					<li>Moderator</li>
				<?php endif; ?>

			</ul>
		</p>
	</div>
</div>
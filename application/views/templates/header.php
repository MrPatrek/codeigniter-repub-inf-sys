<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RePub</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container">
		<a class="navbar-brand" href="<?php echo site_url(); ?>">RePub</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">

			<ul class="navbar-nav me-auto">				<!-- me-auto - это список слева,		а ms-auto - это список справа -->

				<?php
				// All the links in the navbar via array:
				$nav_links = array(site_url() => 'Home', site_url().'about' => 'About', site_url().'reports' => 'Reports');
				foreach ($nav_links as $link => $link_name) { ?>
					<li class="nav-item">
					<?php if (current_url() === $link) : ?>				<!-- if the link is active, it is "highlighted" -->
						<a class="nav-link active" href="<?= $link ;?>"><?= $link_name ;?>
							<span class="visually-hidden">(current)</span>
						</a>
					<?php else : ?>				<!-- if it is not active, then it's just an ordinary link -->
						<a class="nav-link" href="<?= $link ;?>"><?= $link_name ;?></a>
					<?php endif; ?>
					</li>
				<?php } ?>

			</ul>

			<ul class="navbar-nav ms-auto">

				<?php
				// All the links in the navbar via array:
				if (!$this->session->userdata('login_status'))		// if NOT logged in:
					$nav_links = array(site_url().'login' => 'Log In', site_url().'register' => 'Sign Up');

				else {																								// if logged in:

					$nav_links = array();																			// empty array

					if ($this->session->userdata('citizen_mode'))
						$nav_links += array(site_url().'create' => 'Create Report');

					if ($this->session->userdata('authorities_mode'))
						$nav_links += array(site_url().'delete-requests' => 'Delete Requests');						// потом допишешь, когда надо будет
					
					if ($this->session->userdata('moderator_mode'))
						$nav_links += array(site_url().'edit-report-requests' => 'Edit Report Requests',
							site_url().'edit-appeal-requests' => 'Edit Appeal Requests');							// потом допишушь, когда надо будет

					$user_navbar = $this->session->userdata('f_name') . ' ' . $this->session->userdata('l_name') . ' (You)';
					$nav_links += array(site_url().'logout' => 'Log Out', site_url().'profile/'.$this->session->userdata('id') => $user_navbar);

				}

				foreach ($nav_links as $link => $link_name) { ?>
					<li class="nav-item">
					<?php if (current_url() === $link) : ?>				<!-- if the link is active, it is "highlighted" -->
						<a class="nav-link active" href="<?= $link ;?>"><?= $link_name ;?>
							<span class="visually-hidden">(current)</span>
						</a>
					<?php else : ?>				<!-- if it is not active, then it's just an ordinary link -->
						<a class="nav-link" href="<?= $link ;?>"><?= $link_name ;?></a>
					<?php endif; ?>
					</li>
				<?php } ?>

			</ul>

		</div>
	</div>
</nav>



<?php

if ($this->session->flashdata())
	echo '<div class="mt-2">';						//	open activated Flash Messages div
else
	echo '<div>';									//	open deactivated Flash Messages div

// Flash messages regarding warning
$flash_messages_warning = array('is_username_free', 'is_email_free', 'login_fail');
foreach ($flash_messages_warning as $f_mess) {
	$mess_text = $this->session->flashdata($f_mess);
	if ($this->session->flashdata($f_mess)) : ?>

		<div class="row justify-content-center">
			<div class="alert alert-dismissible alert-warning col-lg-3">
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				<!-- <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again. -->
				<strong>Warning! </strong>
				<?= $mess_text ?>
			</div>
		</div>

	<?php endif;
}

// Flash messages regarding success
$flash_messages_success = array('registered', 'login', 'logout', 'create',
	'edit-report', 'edit-report-approve', 'edit-report-disapprove',
	'edit-appeal', 'edit-appeal-approve', 'edit-appeal-disapprove',
	'delete-request', 'delete-approve', 'delete-disapprove'
);
foreach ($flash_messages_success as $f_mess) {
	$mess_text = $this->session->flashdata($f_mess);
	if ($this->session->flashdata($f_mess)) : ?>

		<div class="row justify-content-center">
			<div class="alert alert-dismissible alert-success col-lg-3">
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				<!-- <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again. -->
				<strong>Success! </strong>
				<?= $mess_text ?>
			</div>
		</div>

	<?php endif;
}

echo '</div>';										//	close Flash Messages div
?>



<div class="container my-3">	<!--	my-3 - это margin сверху и снизу,				а lead - это приятный шрифт -->

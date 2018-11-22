<html>

<head>
	<title>LycaHealth</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<link href="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/EasyAutocomplete-1.3.5/easy-autocomplete.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/alertifyjs/css/alertify.min.css" rel="stylesheet">
</head>

<body>
	<script src="<?php echo base_url(); ?>assets/jquery-3.3.1/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery-validation-1.17.0/jquery.validate.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/jquery-validation-1.17.0/additional-methods.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/alertifyjs/alertify.min.js"></script>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/patients">
			<img src="<?php echo base_url(); ?>assets/lyca/images/logo.png" height='35px' alt="">Patient Management
		</a>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<?php if($this->ion_auth->is_admin()) :?>
				<li class="nav-item"><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">User Management</a></li>
				<li class="nav-item"><a class="nav-link" href="<?php echo site_url('useractivity/view'); ?>">User Activity</a></li>
				<?php endif?>
			</ul>
				<!-- User Tab -->
			<ul class="navbar-nav ml-auto">
				<?php if (!$this->ion_auth->logged_in()): ?>
				<li class="nav-item"><a class="nav-link" href="<?php echo site_url('auth/login'); ?>">Log in</a></li>
				<?php else: ?>
				<li class="nav-item dropdown " >
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
					 aria-expanded="false">
						<?php $user = $this->ion_auth->user()->row(); echo $user->first_name ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="<?php echo site_url('auth/change_password'); ?>">change password</a>
						<a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Log out</a>
					</div>
				</li>
				<?php endif ?>
			</ul>
		</div>
	</nav>
	<div class="container">

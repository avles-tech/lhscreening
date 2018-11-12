<html>

<head>
	<title>LycaHealth</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<link href="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet">
</head>

<body>
	<script src="<?php echo base_url(); ?>assets/jquery-3.3.1/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/patients">
			<img src="<?php echo base_url(); ?>assets/lyca/images/logo.png" height='35px' alt="">Patient Management
		</a>
		<ul class="nav navbar-nav pull-right">
			<!-- User Tab -->
			<?php if (!$this->ion_auth->logged_in()): ?>
			<li><a href="<?php echo site_url('auth/login'); ?>">Log in</a></li>
			<?php else: ?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					My Account <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url('auth/change_password'); ?>">change password</a></li>
					<li><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
				</ul>
			</li>
			<?php endif ?>
		</ul>
	</nav>
	<div class="container">

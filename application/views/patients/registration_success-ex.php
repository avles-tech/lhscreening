
<!DOCTYPE HTML>

<html>
<head>
	<title>LycaHealth</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/lyca/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<noscript><link rel="stylesheet" href="<?php echo base_url(); ?>assets/lyca/css/noscript.css" /></noscript>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

	<!-- Header -->
	<header id="header">
		<div class="logo">
			<span class="icon fa-heartbeat"></span>
		</div>
		<div class="content">
			<div class="inner">
				<h1>LYCA HEALTH PATIENT REGISTRATIONS</h1>
				<img src="<?php echo base_url(); ?>assets/lyca/images/logo.png" alt="Lyca Health Logo" />
				<br/><br/>
				<h3 style='color:#009802;'><b style='color:#009802;'>Thank you for Registering!</b><br/>Please be patient, one of our staff member will approach you.</h3>			</div>
		</div>
		<nav>
			<ul>
				<li><a href="<?php echo base_url(); ?>patients/create">Click here to register</a></li>
			</ul>
		</nav>
	</header>

	<!-- Main -->
	<div id="main">

		<!-- Register -->
		
	</div>

	<!-- Footer -->
	<footer id="footer">
		<p class="copyright">&copy; 2018, LycaHealth</p>
	</footer>

</div>

<!-- BG -->
<div id="bg"></div>

<!-- Scripts -->
<script src="<?php echo base_url(); ?>assets/lyca/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lyca/js/skel.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lyca/js/util.js"></script>
<script src="<?php echo base_url(); ?>assets/lyca/js/main.js"></script>

<script>

	//Age
	function getAge(birthDate) {

		var birth_date = new Date(birthDate);
		var currentDate = new Date();

		var years = (currentDate.getFullYear() - birth_date.getFullYear());

		if (currentDate.getMonth() < birth_date.getMonth() ||
			currentDate.getMonth() == birth_date.getMonth() && currentDate.getDate() < birth_date.getDate()) {
			years--;
		}

		$('#age').val(years);
	}
</script>

</body>
</html>

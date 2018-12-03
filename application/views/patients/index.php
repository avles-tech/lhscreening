<br>
<div class="float-right">
	<a href="<?php echo base_url().'patients/create' ?>"> Register Patient</a>
</div>
<br>
<br>
<div class='row'>
	<div class='col'>
		<div class="input-group ">
			<div class="input-group-prepend">
				<span class="input-group-text">Search</span>
			</div>
			<input type="text" name="search_text" id="search_text" placeholder="Search by Patient Details" class="form-control" />
		</div>
	</div>
	<div class='col'>
		<div class="input-group ">
			<div class="input-group-prepend">
				<span class="input-group-text">DOB</span>
			</div>
			<input type='date' name='dob' id='dob' class="form-control" />
		</div>
	</div>
</div>
<br />
<div id="result">
</div>
<div style="clear:both"></div>

<script>
	$(document).ready(function () {

		load_data();

		function load_data(query,dob) {
			$.ajax({
				url: "<?php echo base_url(); ?>patients/search",
				method: "POST",
				data: {
					query: query
					,dob : dob
				},
				success: function (data) {
					$('#result').html(data);
				}
			});
		}

		function search_call() {
			let search_text = $('#search_text').val();
			let dob = $('#dob').val();

			load_data(search_text, dob);
		}

		$('#search_text').keyup(search_call);
		$('#dob').change(search_call);
	});

</script>

<br />
<br />
<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text">Search</span>
	</div>
	<input type="text" name="search_text" id="search_text" placeholder="Search by Patient Details" class="form-control" />
</div>
<br />
<div id="result">
	<!-- <table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">First Name</th>
				<th scope="col">Last Name</th>
				<th scope="col">Email</th>
				<th scope="col">Date of Birth</th>
				<th scope="col">Gender</th>
				<th scope="col">Address</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($patients as $patient_item): ?>
			<tr>
				<th scope="row">
					<?php echo $patient_item['id']; ?>
				</th>
				<td>
					<?php echo $patient_item['first_name']; ?>
				</td>
				<td>
					<?php echo $patient_item['last_name']; ?>
				</td>
				<td>
					<?php echo $patient_item['email']; ?>
				</td>
				<td>
					<?php echo $patient_item['dob']; ?>
				</td>
				<td>
					<?php echo $patient_item['gender']; ?>
				</td>
				<td>
					<?php echo $patient_item['address']; ?>
				</td>
				<td>
					<a href="<?php echo site_url('patients/view/'.$patient_item['id']); ?>">View patient</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table> -->
</div>
<div style="clear:both"></div>

<script>
	$(document).ready(function () {

		load_data();

		function load_data(query) {
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/patients/search",
				method: "POST",
				data: {
					query: query
				},
				success: function (data) {
					$('#result').html(data);
				}
			})
		}

		$('#search_text').keyup(function () {
			var search = $(this).val();
			if (search != '') {
				load_data(search);
			} else {
				load_data();
			}
		});
	});

</script>

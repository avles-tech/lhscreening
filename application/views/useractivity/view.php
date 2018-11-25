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
				<span class="input-group-text">Search</span>
			</div>
			<input type="text" name="search_by_user" id="search_by_user" placeholder="Search by User Details" class="form-control" />
		</div>
	</div>
</div>
<br>
<div class='row'>
	<div class='col'>
		<div class="input-group ">
		<div class="input-group-prepend">
		<span class="input-group-text">From</span>
	</div>
	<input type='date' name='from_date_time' id='from_date_time' class="form-control" />
		</div>
	</div>
	<div class='col'>
		<div class="input-group ">
		<div class="input-group-prepend">
		<span class="input-group-text">To</span>
	</div>
	<input type='date' name='to_date_time' id='to_date_time' class="form-control" />
		</div>
	</div>
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
					<?php echo $patient_item['gender'] == '1' ? 'Male' : 'Female'; ?>
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

		search_call();

		function load_data(search_text, from_date_time, to_date_time,search_by_user) {
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/useractivity/search",
				method: "POST",
				data: {
					search_text: search_text,
					from_date_time: from_date_time,
					to_date_time: to_date_time
					,search_by_user : search_by_user
				},
				success: function (data) {
					$('#result').html(data);
				}
			});
		}

		function search_call() {
			let search_text = $('#search_text').val();
			let from_date_time = $('#from_date_time').val();
			let to_date_time = $('#to_date_time').val();
			let search_by_user = $('#search_by_user').val();

			load_data(search_text, from_date_time, to_date_time ,search_by_user);
		}

		$('#search_text').change(search_call);
		$('#search_by_user').change(search_call);
		$('#from_date_time').change(search_call);
		$('#to_date_time').change(search_call);
	});

</script>

<script>
	var options2 = {

		url: function (phrase) {
			return "<?php echo base_url(); ?>index.php/patients/get_patients";
		},

		list: {
			match: {
				enabled: true
			}
		},

		getValue:"first_name",

		ajaxSettings: {
			dataType: "json",
			method: "POST",
			data: {
				dataType: "json"
			},
			success: function (data) {
				console.log('data', data);
				}
		},

		preparePostData: function (data) {
			data.phrase = $("input[name=search_by_user]").val();
			return data;
		},

		requestDelay: 400
	};

	var options = {

		url: function (phrase) {
			return "<?php echo base_url(); ?>index.php/useractivity/get_users";
		},
		list: {
			match: {
				enabled: true
			}
		},

		getValue:"first_name",

		ajaxSettings: {
			dataType: "json",
			method: "POST",
			data: {
				dataType: "json"
			}
		},

		preparePostData: function (data) {
			data.phrase = $("input[name=search_by_user]").val();
			return data;
		},

		requestDelay: 400
	};

	$("input[name=search_by_user]").easyAutocomplete(options);
	$("input[name=search_text]").easyAutocomplete(options2);

</script>

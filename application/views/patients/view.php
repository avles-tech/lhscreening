<?php
//echo $patient_id;
//echo $tab;
$patient_details = $this->patients_model->get_patients($patient_id);
$save_exited = empty($patient_details) ? '0' : $patient_details['save_exit']=='1';

$user = $this->ion_auth->user()->row(); 

$read_only = empty($patient_details) ? '' : $patient_details['save_exit']=='1' ? 'disabled' : '';

if ($save_exited=='1' && $this->ion_auth->is_admin())
{
	$button_code = "<div class='float-sm-right'>
		<button id='edit_user_button' class='btn btn-primary btn-block '> edit user details</button>
	</div>";
	echo $button_code;
}

echo '<h2>'.$patient_details['first_name'].' '.$patient_details['last_name'].'</h2>';
//echo $phq_list[0]['question'];
$this->user_activity_model->set('selected '.$patient_details['first_name'].'(patient ID:'.$patient_details['patient_id'].') for update');
?>
<ul class="nav nav-tabs flex-sm-row" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="basic_details-tab" data-toggle="tab" href="#basic_details" role="tab" aria-controls="basic_details"
		 aria-selected="true">Basic Details</a>
	</li>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened PHQ-9 of  '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="phq-tab" data-toggle="tab" href="#phq" role="tab" aria-controls="phq" aria-selected="false">PHQ-9</a>
	</li>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened GAD-7 of  '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="gad-tab" data-toggle="tab" href="#gad" role="tab" aria-controls="gad" aria-selected="false">GAD-7</a>
	</li>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened Medical history results of '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="medical_history-tab" data-toggle="tab" href="#medical_history" role="tab" aria-controls="medical_history"
		 aria-selected="false">Medical History</a>
	</li>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened Laboratory test results of '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="lab_test-tab" data-toggle="tab" href="#lab_test" role="tab" aria-controls="lab_test"
		 aria-selected="false">Laboratory Test</a>
	</li>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened uploads of '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="upload_report-tab" data-toggle="tab" href="#upload_report" role="tab" aria-controls="upload_report"
		 aria-selected="false">Reports</a>
	</li>
	<?php if ($this->ion_auth->in_group('gp')): ?>
	<li class="nav-item" onclick="setActivity('<?php echo 'opened GP Summary and Recommendations of '.$patient_details['first_name'].' (Patient ID:'.$patient_id.')' ?>')">
		<a class="nav-link" id="gp-tab" data-toggle="tab" href="#gp" role="tab" aria-controls="gp" aria-selected="false">GP
			summary & recommendation</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="generate_report-tab" data-toggle="tab" href="#generate_report" role="tab" aria-controls="generate_report"
		 aria-selected="false">Generate Reports</a>
	</li>
	<?php endif ?>
</ul>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane active" id="basic_details" role="tabpanel" aria-labelledby="basic_details-tab">
		<div class="card">
			<article class="card-body">
				<?php 
					echo validation_errors();  
					echo form_open('basic_details_form',array( 'id' => 'basic_details_form'));  
					echo form_hidden('patient_id',$patient_id);
					$this->load->view('patients/patient_basic_details', array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
				?>
				<div class="form-row">
					<!-- form-group end.// -->
					<div class="form-group btn-group mr-2">
						<button type="submit" id='basic_details_save_button' class="btn btn-primary btn-block" <?php echo
						 empty($patient_details) ? '' : $patient_details['save_exit']=='1' ? 'disabled' : '' ?>> Save </button>
					</div> <!-- form-group// -->
					<div class="form-group btn-group mr-2">
						<button id='save_exit' class="btn btn-primary " <?php echo $read_only ?>>Save & Exit</button>
					</div> <!-- form-group// -->
					<div class="form-group btn-group mr-2">
						<a href="<?php echo base_url().'patients'?>" class="btn btn-danger" role='button'>Cancel</a>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article>
		</div>
	</div>
	<div class="tab-pane" id="phq" role="tabpanel" aria-labelledby="phq-tab">
		<?php
			$this->load->view('patients/patient_phq',array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only));
		?>
	</div>
	<div class="tab-pane" id="gad" role="tabpanel" aria-labelledby="gad-tab">
		<?php 
			$this->load->view('patients/patient_gad',array( 'patient_id' => $patient_id)); 
		?>
	</div>
	<div class="tab-pane" id="medical_history" role="tabpanel" aria-labelledby="gad-tab">
		<?php 
			$this->load->view('patients/patient_medical_history',array( 'patient_id' => $patient_id, 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
		?>
	</div>
	<div class="tab-pane" id="lab_test" role="tabpanel" aria-labelledby="gad-tab">
		<?php 
			$this->load->view('patients/patient_lab_test',array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
		?>
	</div>
	<div class="tab-pane" id="upload_report" role="tabpanel" aria-labelledby="gad-tab">
		<?php 
		$this->load->view('patients/patient_upload', array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
	?>
	</div>
	<div class="tab-pane" id="gp" role="tabpanel" aria-labelledby="gad-tab">
		<?php 
		$this->load->view('patients/patient_gp', array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
	?>
	</div>
	<div class="tab-pane" id="generate_report" role="tabpanel" aria-labelledby="generate_report-tab">
		<?php 
		$this->load->view('patients/patient_report', array( 'patient_id' => $patient_id , 'patient_details'=>$patient_details ,'read_only'=>$read_only)); 
	?>
	</div>
</div>
<Script>
	function setActivity(activity) {
		$.ajax({
			url: "<?php echo base_url(); ?>Useractivity/set_activity",
			method: "POST",
			data: {
				activity: activity
			}
		});
	}

	// var params = {},
	//                queryString = location.hash.substring(1),
	//                regex = /([^&=]+)=([^&]*)/g,
	//                m;
	//            while (m = regex.exec(queryString)) {
	//              params[m[1]] = m[2];
	//            }
	//alert("your access token is : " + params["tab"]);

</Script>
<!-- <Script>
		$('#myTab a').click(function(e) {
			e.preventDefault();
			$(this).tab('show');
		});

		// store the currently selected tab in the hash value
		$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
			var id = $(e.target).attr("href").substr(1);
			window.location.hash = id;
		});

		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;

		$('#myTab a[href="' + hash + '"]').tab('show');
	</Script> -->
<script>
	$('form#basic_details_form').submit(function (e) {
		var form = $(this);
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('patients/update'); ?>",
			data: form.serialize(), 
			dataType: "html",
			success: function (data) {
				alertify.set('notifier', 'position', 'top-right');
				alertify.notify('Patient details updated', 'success', 5);
			},
			error: function () {
				alert("Error posting feed.");
			}
		});

	});

	$("button[id^='save_exit']").click(()=>{
			alertify.set('notifier', 'position', 'top-right');
			alertify.notify('patient save and exit', 'success', 5, function () {
				console.log('dismissed');
			});
			location.href = "<?php echo base_url().'patients'?>";
		});
		
	$("#edit_user_button").click(function () {
		alertify.prompt('Reason for edit', 'Reason', '', function (evt, value) {
			alertify.success('You entered: ' + value);
			setActivity("<?php echo 'edited '.$patient_details['first_name'].'(Patient ID: '.$patient_id.'), reason: '?>" + value);
			$(":input").prop('disabled', false);
			$(":button").prop('disabled', false);
		}, function () {
			alertify.error('Cancel')
		});
	});

</script>

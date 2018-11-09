<?php
echo '<h2>'.$patient['first_name'].' '.$patient['last_name'].'</h2>';
//echo $phq_list[0]['question'];
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="basic_details-tab" data-toggle="tab" href="#basic_details" role="tab" aria-controls="basic_details"
		 aria-selected="true">Basic Details</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="phq-tab" data-toggle="tab" href="#phq" role="tab" aria-controls="phq" aria-selected="false">PHQ-9</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="gad-tab" data-toggle="tab" href="#gad" role="tab" aria-controls="gad" aria-selected="false">GAD-7</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="medical_history-tab" data-toggle="tab" href="#medical_history" role="tab" aria-controls="medical_history" aria-selected="false">Medical history</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="lab_test-tab" data-toggle="tab" href="#lab_test" role="tab" aria-controls="lab_test" aria-selected="false">Laboratory test</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="upload_report-tab" data-toggle="tab" href="#upload_report" role="tab" aria-controls="upload_report" aria-selected="false">Upload reports</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="gp-tab" data-toggle="tab" href="#gp" role="tab" aria-controls="gp" aria-selected="false">GP summary & recommendation</a>
	</li>
</ul>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane active" id="basic_details" role="tabpanel" aria-labelledby="basic_details-tab">
		<div class="card">
			<article class="card-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open('patients/update'); ?>
				<?php 
					$data['patient'] = $patient; 
					echo form_hidden('id',$patient['id']);
					$this->load->view('patients/patient_basic_details',$patient); 
					?>
				<div class="form-row">
					<!-- form-group end.// -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block"> Save </button>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article>
		</div>
	</div>
	<div class="tab-pane" id="phq" role="tabpanel" aria-labelledby="phq-tab">
		<div class="card">
			<article class="card-body">
				<?php 
					echo validation_errors();  
					echo form_open('patients/update_phq');
					$this->load->view('patients/patient_phq',$phq_list); 
				?>
				<div class="form-row">
					<!-- form-group end.// -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block"> Save </button>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article>
		</div>
	</div>
	<div class="tab-pane" id="gad" role="tabpanel" aria-labelledby="gad-tab">
	<div class="card">
			<article class="card-body">
				<?php 
					echo validation_errors();  
					echo form_open('patients/update_gad'); 
					$this->load->view('patients/patient_gad',$gad_list); 
				?>
				<div class="form-row">
					<!-- form-group end.// -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block"> Save </button>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article>
		</div>
	</div>
	<div class="tab-pane" id="medical_history" role="tabpanel" aria-labelledby="gad-tab">medical history</div>
	<div class="tab-pane" id="lab_test" role="tabpanel" aria-labelledby="gad-tab">lap_test</div>
	<div class="tab-pane" id="upload_report" role="tabpanel" aria-labelledby="gad-tab">
	<?php 
		$this->load->view('patients/patient_upload',$patient_reports); 
	?>
	</div>
	<div class="tab-pane" id="gp" role="tabpanel" aria-labelledby="gad-tab">gp_recommend</div>
</div>
<script>
	$(document).on('click', '#refresh', function () {
    var $link = $('li.active a[data-toggle="tab"]');
    $link.parent().removeClass('active');
    var tabLink = $link.attr('href');
    $('#mainTabs a[href="' + tabLink + '"]').tab('show');
});
</script>
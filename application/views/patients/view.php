<?php
echo '<h2>'.$patient['first_name'].' '.$patient['last_name'].'</h2>';
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
					$this->load->view('patients/patient_basicdetails_form',$data); 
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
	<div class="tab-pane" id="phq" role="tabpanel" aria-labelledby="phq-tab">test</div>
	<div class="tab-pane" id="gad" role="tabpanel" aria-labelledby="gad-tab">test2</div>
</div>

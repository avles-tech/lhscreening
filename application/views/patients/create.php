<br>
<style>
body {
   background-image:  url("<?php echo base_url(); ?>assets/lyca/images/Lyca-Westferry.jpg");
}
</style>>
<div class="row justify-content-center">
	<div class="col-md-9">
		<div class="card">
			<header class="card-header">
				<h4 class="card-title mt-2">
					<u>
						<?php echo strtoupper('PATIENTS REGISTRATION FORM') ?></u>
				</h4>
			</header>
			<article class="card-body">
				<h5>
					<?php echo strtoupper('description') ?>
				</h5>
				<p style='border-left: solid 4px #1b1f22;padding: 0.5rem 0.5rem 0.5rem 0.5rem;'>Please do read the instructions
					carefully and fill up the registration form with
					answers to the best of your knowledge.</p>
			</article>
			<article class="card-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open('patients/create',array('id' => 'create_form')); ?>
				<?php $this->load->view('patients/patient_basic_details',array( 'patient_id' => '0' , 'patient_details'=>array() ,'read_only'=>'0')); ?>
				<div class='form-group'>
				<div id='confirm_medical_history_group'>
					<div class="form-check form-check-inline">
						<label class="form-check">
							<input type="checkbox" value="1" name="confirm_medical_history" required>
							<span class="form-check-label">I confirm that the information I have provided in this form is a true reflection of my current health, and past medical history</span>
						</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12" style='border: 1px solid #00070e;'></div>
				</div> <!-- form-group end.// -->
				<div class="form-group">
					<h6><u> DISCLAIMER: </u></h6>
					<p>The LycaHealth Ultra Health Assessment report is based wholly on the information provided by the
						client/patient in their responses to the questions and from the results of tests undertaken.</p>
					<p>The LycaHealth Ultra Health Assessment is not a replacement for formal medical diagnosis, however it will
						provide an indication of any abnormalities evidenced through the tests conducted.</p>
					<p>LycaHealth, its staff or affiliates accept no liability or responsibility for;</p>
					<ul>
						<li>Any Decisions, Acts or Omissions that the client/patient takes in reliance upon the information contained or
							provided through the LycaHealth Ultra Health Assessment,</li>
						<li>Claims arising out of or related to the LycaHealth Ultra Health Assessment,</li>
						<li>Clients use of the LycaHealth Ultra Health Assessment tool,</li>
						<li>For any incidental, indirect, special, consequential or punitive damages, including but not limited to,
							possible health side effects.</li>
					</ul>
					<p>The LycaHealth Ultra Health Assessment report makes no warranties or guarantees of any kind and expressly
						disclaims any and all warranties of any kind or nature.</p>
				</div> <!-- form-group end.// -->
				<div class="form-group">
					<div class="col-md-12" style='border: 1px solid #00070e;'></div>
				</div> <!-- form-group end.// -->

				<div class="form-row">
					<!-- form-group end.// -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id='create'> Save & Register </button>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article> <!-- card-body end .// -->
		</div> <!-- card.// -->
	</div> <!-- col.//-->
</div> <!-- row.//-->
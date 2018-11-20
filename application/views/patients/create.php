<br>

<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card">
			<header class="card-header">
				<h4 class="card-title mt-2">
					<u>
						<?php echo strtoupper('register form') ?></u>
				</h4>
			</header>
			<article class="card-body">
				<h5>
					<?php echo strtoupper('description') ?>
				</h5>
				<p style='border-left: solid 4px #1b1f22;padding: 0.5rem 0.5rem 0.5rem 0.5rem;'>Please
					do read the instructions carefully and do fill up the registration form with
					answer to best of your knowledge.</p>
			</article>
			<article class="card-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open('patients/create'); ?>
				<?php $this->load->view('patients/patient_basic_details'); ?>
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
						<button type="submit" class="btn btn-primary btn-block"> Save & Register </button>
					</div> <!-- form-group// -->
				</div>
				</form>
			</article> <!-- card-body end .// -->
		</div> <!-- card.// -->
	</div> <!-- col.//-->
</div> <!-- row.//-->

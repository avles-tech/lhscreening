<div class="card">
	<article class="card-body">
		<?php
			
			$patient_gp_details = $this->patient_gp_model->get($patient_id);
			$patient_details = $this->patients_model->get_patients($patient_id);
			$read_only = empty($patient_details) ? '' : $patient_details['save_exit']=='1' ? 'disabled' : '';
            //echo empty($patient_gp_details) ? 'empty': $patient_gp_details['blood_results'];

            echo validation_errors();  
			//echo form_open('patients/update_gp');
			echo form_open('gp_form',array( 'id' => 'gp_form'));
            echo form_hidden('patient_id',$patient_id);
        ?>

		<div class="col form-group">
			<label>Blood results summary</label>
			<textarea <?php echo $read_only ?> class="form-control" name='blood_results'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['blood_results'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<div class="col form-group">
			<label>Ultrasound results summary</label>
			<textarea <?php echo $read_only ?> class="form-control" name='ultra_sound'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['ultra_sound'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<div class="col form-group">
			<label>MRI results summary</label>
			<textarea class="form-control" <?php echo $read_only ?> name='mri_results'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['mri_results'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<div class="col form-group">
			<label>Overall lifestyle summary</label>
			<textarea <?php echo $read_only ?> class="form-control" name='overall_lifestyle'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['overall_lifestyle'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<div class="col form-group">
			<label>Additional comments</label>
			<textarea <?php echo $read_only ?> class="form-control" name='additional_comments'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['additional_comments'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<?php if($read_only && $this->ion_auth->in_group('gp')) :?>
		<div class="col form-group">
			<label>Second Opinion</label>
			<textarea <?php echo $read_only ?> class="form-control" name='gp_second'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['gp_second'];?> </textarea>
		</div>
		<?php endif ?>
		<!-- form-group end.// -->
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group btn-group  mr-2">
				<button id='gp_save_button' <?php echo $read_only ?> type="submit" class="btn btn-primary "> Save </button>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<button id='save_complete' class="btn btn-primary " <?php echo $read_only ?>>Save & complete</button>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<button id='save_exit' class="btn btn-primary " <?php echo $read_only ?>>Save & Exit</button>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<a  href="<?php echo base_url().'patients'?>" class="btn btn-danger" role='button'>Cancel</a>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>
<script>
	$('form#gp_form').submit(function (e) {

		var form = $(this);

		e.preventDefault();

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('patients/update_gp'); ?>",
			data: form.serialize(), // <--- THIS IS THE CHANGE
			dataType: "html",
			success: function (data) {
				//$('#feed-container').prepend(data);
				alertify.set('notifier', 'position', 'top-right');
				alertify.notify('patient gp details updated', 'success', 5, function () {
					console.log('dismissed');
				});
			},
			error: function () {
				alert("Error posting feed.");
			}
		});

	});

</script>
<script type="text/javascript">
	$(document).ready(function () {

		function save_complete_pressed() {
			let that = this;
			alertify.confirm('', 'Are you sure ?', function () {
				var myForm = document.getElementById('gp_form');
				formData = new FormData(myForm);

				$.ajax({
					type: "POST",
					url: "<?php echo site_url('patients/save_complete'); ?>",
					data: {
						'patient_id': formData.get('patient_id')
					}, // <--- THIS IS THE CHANGE
					success: function (data) {
						//$('#feed-container').prepend(data);
						alertify.set('notifier', 'position', 'top-right');
						alertify.notify('patient save and completed', 'success', 5, function () {
							console.log('dismissed');
						});
						console.log('test');

						location.reload();

						//console.log('test');
					},
					error: function () {
						alert("Error posting feed.");
					}
				});
			}, function () {
				alertify.error('Cancel')
			});
		}

		$("button#save_complete").click(save_complete_pressed);
	});

</script>

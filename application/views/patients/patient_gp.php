<div class="card">
	<article class="card-body">
		<?php
			
            $patient_gp_details = $this->patient_gp_model->get($patient_id);

            //echo empty($patient_gp_details) ? 'empty': $patient_gp_details['blood_results'];

            echo validation_errors();  
			//echo form_open('patients/update_gp');
			echo form_open('gp_form',array( 'id' => 'gp_form'));
            echo form_hidden('patient_id',$patient_id);
        ?>

		<div class="col form-group">
			<label>Blood results summary</label>
			<textarea class="form-control" name='blood_results'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['blood_results'];?> </textarea>
		</div>
		<!-- form-group end.// -->
        <div class="col form-group">
			<label>Ultrasound results summary</label>
			<textarea class="form-control" name='ultra_sound'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['ultra_sound'];?> </textarea>
		</div>
		<!-- form-group end.// -->
        <div class="col form-group">
			<label>MRI results summary</label>
			<textarea class="form-control" name='mri_results'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['mri_results'];?> </textarea>
		</div>
		<!-- form-group end.// -->
        <div class="col form-group">
			<label>Overall lifestyle summary</label>
			<textarea class="form-control" name='overall_lifestyle'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['overall_lifestyle'];?> </textarea>
		</div>
		<!-- form-group end.// -->
        <div class="col form-group">
			<label>Additional comments</label>
			<textarea class="form-control" name='additional_comments'><?php echo empty($patient_gp_details) ? '': $patient_gp_details['additional_comments'];?> </textarea>
		</div>
		<!-- form-group end.// -->
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block"> Save </button>
				
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
				},
				error: function () {
					alert("Error posting feed.");
				}
			});

		});
	</script>

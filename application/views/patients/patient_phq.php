<div class="card">
	<article class="card-body">
		<?php 
			echo validation_errors();  
			echo form_open('phq_form',array( 'id' => 'phq_form'));
        ?>
		<div class="form-row">
			<?php 
            $patient_phq = $this->patient_phq_model->get_patient_phq($patient_id);
            echo form_hidden('patient_id',$patient_id);

            foreach ($patient_phq as $item): 
            ?>
			<div class="form-group col-md-6">
				<label>
					<?php echo $item['question'] ?>
				</label>
			</div> <!-- form-group end.// -->
			<div class="form-group col-md-6">
				<label class="form-check">
					<input type="radio" name="<?php echo $item['id'] ?>" value="0" <?php echo $item['value']=='0' ? 'checked' : '' ?>
					<?php echo $read_only ?>>
					<span class="form-check-label">Not at all</span>
				</label>
				<label class="form-check">
					<input type="radio" name="<?php echo $item['id'] ?>" value="1" <?php echo $item['value']=='1' ? 'checked' : '' ?>
					<?php echo $read_only ?>>
					<span class="form-check-label">Several days</span>
				</label>
				<label class="form-check">
					<input type="radio" name="<?php echo $item['id'] ?>" value="2" <?php echo $item['value']=='2' ? 'checked' : '' ?>
					<?php echo $read_only ?>>
					<span class="form-check-label">More than half the days</span>
				</label>
				<label class="form-check">
					<input type="radio" name="<?php echo $item['id'] ?>" value="3" <?php echo $item['value']=='3' ? 'checked' : '' ?>
					<?php echo $read_only ?>>
					<span class="form-check-label">Nearly every day</span>
				</label>
			</div> <!-- form-group end.// -->
			<?php endforeach; ?>
		</div> <!-- form-row.// -->
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group btn-group mr-2">
				<a href='#' role='button' id='phq_save' class="btn btn-primary btn-block" <?php echo $read_only ?>> Save </a>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<a href='#' role='button' id='phq_save_exit' class="btn btn-primary " <?php echo $read_only ?>>Save & Exit</a>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<a href="<?php echo base_url().'patients'?>" class="btn btn-danger" role='button'>Cancel</a>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>
<script>

	$('#phq_save_exit').click(function (e) {
		e.preventDefault();
		updatePHQ(true);
		
	});

	$('#phq_save').click(function (e) {
		e.preventDefault();
		updatePHQ(false);
		
	});

	function updatePHQ(save_exit){

		var phq_form_form = $('#phq_form');

		$.ajax({
		type: "POST",
		url: "<?php echo site_url('patients/update_phq'); ?>",
		data: phq_form_form.serialize(),
		success: function (data) {
			alertify.set('notifier', 'position', 'top-right');
			alertify.notify('Patient details updated', 'success', 5);
			if(save_exit)
				location.href = "<?php echo base_url().'patients'?>";
		},
		error: function () {
			alert("Error posting feed.");
		}
		});
	}

</script>

<div class="card">
	<?php 
	// $lab_test_categories = $this->patient_lab_test_model->get_lab_test_categories();

	// foreach ($lab_test_categories as $item):
	// 	echo $item['category'];
	// endforeach;
	?>
	<article class="card-body">
		<?php
			$patient_lab_test = $this->patient_lab_test_model->get_patient_lab_test($patient_id);
			$patient_details = $this->patients_model->get_patients($patient_id);
			$read_only = empty($patient_details) ? '' : $patient_details['save_exit']=='1' ? 'disabled' : '';
			
			$categories = array();
			foreach ($patient_lab_test as $c) {
				$categories[] = $c['category'];
			}
			$uniqueCategories = array_unique($categories);
			?>
		<?php	
            echo validation_errors();  
			//echo form_open('patients/update_patient_lab_test');
			echo form_open('patient_lab_test_form',array( 'id' => 'patient_lab_test_form'));
			echo form_hidden('patient_id',$patient_id);
			?>
		<?php
				foreach ($uniqueCategories as $cat):
					echo '<h3>'.$cat.'</h3>';
					foreach ($patient_lab_test as $item): 
						if($item['category']==$cat):	
				?>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">
				<?php echo $item['test_name'] ?></label>
			<div class="col-sm-4">
				<input class="form-control" name='<?php echo $item[' id'] ?>' value="
				<?php echo array_key_exists('test_name', $item) ? $item['value'] : '';?>"
				<?php echo $read_only ?>>
			</div>
			<div class="small-3 columns">
				<span class="postfix">
					<?php echo array_key_exists('unit', $item) ? $item['unit'] : '';?></span>
			</div>
		</div> <!-- form-group end.// -->
		<?php  endif; endforeach; endforeach; ?>
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group btn-group mr-2">
				<button type="submit" class="btn btn-primary btn-block" <?php echo $read_only ?>> Save </button>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
						<button id='save_exit' class="btn btn-primary " <?php echo $read_only ?>>Save & Exit</button>
					</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<a href="<?php echo base_url().'index.php/patients'?>" class="btn btn-danger" role='button'>Cancel</a>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>
<script>
	$('form#patient_lab_test_form').submit(function (e) {

		var form = $(this);

		e.preventDefault();

		$.ajax({
			type: "POST",
			url: "<?php echo site_url('patients/update_patient_lab_test'); ?>",
			data: form.serialize(), // <--- THIS IS THE CHANGE
			dataType: "html",
			success: function (data) {
				//$('#feed-container').prepend(data);
				alertify.set('notifier', 'position', 'top-right');
				alertify.notify('patient details updated', 'success', 5, function () {
					console.log('dismissed');
				});
			},
			error: function () {
				alert("Error posting feed.");
			}
		});

	});

</script>

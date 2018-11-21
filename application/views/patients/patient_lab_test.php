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
			
			$categories = array();
			foreach ($patient_lab_test as $c) {
				$categories[] = $c['category'];
			}
			$uniqueCategories = array_unique($categories);
			?>
		<?php	
            echo validation_errors();  
			echo form_open('patients/update_patient_lab_test');
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
				<?php echo array_key_exists('value', $item) ? $item['value'] : '';?>" >
			</div>
			<div class="small-3 columns">
				<span class="postfix"><?php echo array_key_exists('unit', $item) ? $item['unit'] : '';?></span>
			</div>
		</div> <!-- form-group end.// -->
		<?php  endif; endforeach; endforeach; ?>
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block"> Save </button>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>

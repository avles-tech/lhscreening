<br /><br />
<div class="form-group">
<h4>Blood Report</h4>
	<br /><br />
	<?php 
			$patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);
			echo form_open_multipart('upload/do_upload');
			//echo form_open_multipart('upload_blood_report_form',array( 'id' => 'upload_blood_report_form'));
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','blood'); 
		?>
	<input type="file" name="userfile" size="20" />

	<input type="submit" value="upload" />
	</form>
	<?php if (!empty($patient_reports['blood'])) : ?>
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['blood'] ?>" > download</a>
	<?php endif?>
</div> <!-- form-group end.// -->
<h4>MRI Report</h4>
<div class="form-group">
	<br /><br />
	<?php 
			echo form_open_multipart('upload/do_upload');
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','mri'); 
		?>
	<input type="file" name="userfile" size="20" />

	<input type="submit" value="upload" />
	</form>
	<?php if (!empty($patient_reports['mri'])) : ?>
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['mri'] ?>" > download</a>
	<?php endif?>
</div> <!-- form-group end.// -->
<h4>XRay</h4>
<div class="form-group">
	<br /><br />
	<?php 
			echo form_open_multipart('upload/do_upload');
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','xray'); 
		?>
	<input type="file" name="userfile" size="20" />

	<input type="submit" value="upload" />
	</form>
	<?php if (!empty($patient_reports['xray'])) : ?>
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['xray'] ?>" > download</a>
	<?php endif?>
</div> <!-- form-group end.// -->

<?php 
//$this->load->view('patients/patient_report',array( 'patient_id' => $patient_id)); 
?>

<script>
		$('form#upload_blood_report_form').submit(function (e) {

			var form = $(this);

			e.preventDefault();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('upload/do_upload'); ?>",
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

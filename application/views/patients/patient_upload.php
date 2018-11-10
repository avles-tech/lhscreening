<div class="form-group">
	<br /><br />
	<?php 
			$patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);
			echo form_open_multipart('upload/do_upload');
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','blood'); 
		?>
	<input type="file" name="userfile" size="20" />

	<input type="submit" value="upload" />
	</form>
	
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['blood'] ?>" > download</a>
</div> <!-- form-group end.// -->
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
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['mri'] ?>" > download</a>
</div> <!-- form-group end.// -->
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
	<a href = "<?php echo base_url().'index.php/upload/download/'.$patient_reports['xray'] ?>" > download</a>
</div> <!-- form-group end.// -->

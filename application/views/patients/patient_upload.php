<br /><br />
<div class="form-group">
	<h4>Blood Report</h4>
	<br />
	<?php 
			$patient_reports = $this->patient_reports_model->get_patient_reports($patient_id);
			//echo form_open_multipart('upload/do_upload_ex');
			echo form_open_multipart('upload_blood_report_form',array( 'id' => 'upload_blood_report_form'));
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','blood'); 
		?>
	<div class="input-group col-md-6 mb-3">
		<div class="custom-file">
			<input type="file" class="custom-file-input" name="userfile" id='userfile'>
			<label class="custom-file-label" for="userfile">Choose file</label>
		</div>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit" value="upload">upload</button>
		</div>
	</div>
	<div id='file_div' data-report='blood'>

		<?php $this->load->view('patients/upload_file_div',array( 'patient_id' => $patient_id , 'report'=>'blood'));  ?>
	</div>
	</form>
</div> <!-- form-group end.// -->
<h4>MRI Report</h4>
<div class="form-group">
	<br />
	<?php 
			//echo form_open_multipart('upload/do_upload');
			echo form_open_multipart('upload_mri_report_form',array( 'id' => 'upload_mri_report_form'));
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','mri'); 
		?>
	<div class="input-group col-md-6 mb-3">
		<div class="custom-file">
			<input type="file" class="custom-file-input" name="userfile" id='userfile'>
			<label class="custom-file-label" for="userfile">Choose file</label>
		</div>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit" value="upload">upload</button>
		</div>
	</div>
	<div id='file_div' data-report='mri'>

		<?php $this->load->view('patients/upload_file_div',array( 'patient_id' => $patient_id , 'report'=>'mri'));  ?>
	</div>
	</form>

</div> <!-- form-group end.// -->
<h4>XRay</h4>
<div class="form-group">
	<br />
	<?php 
			//echo form_open_multipart('upload/do_upload');
			echo form_open_multipart('upload_xray_report_form',array( 'id' => 'upload_xray_report_form'));
			echo form_hidden('patient_id',$patient_id); 
			echo form_hidden('report','xray'); 
		?>
	<div class="input-group col-md-6 mb-3">
		<div class="custom-file">
			<input type="file" class="custom-file-input" name="userfile" id='userfile'>
			<label class="custom-file-label" for="userfile">Choose file</label>
		</div>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit" value="upload">upload</button>
		</div>
	</div>
	<div id='file_div' data-report='xray'>

		<?php $this->load->view('patients/upload_file_div',array( 'patient_id' => $patient_id , 'report'=>'xray'));  ?>
	</div>
	</form>
</div> <!-- form-group end.// -->
<?php 
//$this->load->view('patients/patient_report',array( 'patient_id' => $patient_id)); 
?>
<div class="form-group btn-group mr-2">
	<a  href="<?php echo base_url().'index.php/patients'?>" class="btn btn-danger" role='button'>Cancel</a>
</div> <!-- form-group// -->
<script>
	function ChangeFileName(report, filename) {
		alertify.prompt('File Rename', 'New File Name', '', function (evt, value) {
			let extension = '.' + filename.split('.')[1];
			var file_div = $('div[data-report="' + report + '"]');
			alertify.success('You entered: ' + value);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('upload/rename_file'); ?>",
				data: {
					old_name: filename,
					new_name: value,
					patient_id: <?php echo $patient_id; ?>,
					'report': report
				},
				success: function (data) {
					//$('#feed-container').prepend(data);
					value = value + extension;
					let html = "";
					html +=
						"<a class='btn btn-primary btn-group mr-2'  role='button' href='<?php echo base_url() ?>index.php/upload/download/" +
						value + "'>" + value + "</a>";
					html +=
						"<a class='btn btn-warning btn-group mr-2' onclick='ChangeFileNameEx(this)' id='changedFilename' data-filename='" +
						value + "' data-report='" + report + "' role='button' href='#' > rename </a>";
					html +=
						"<a class='btn btn-danger btn-group mr-2' onclick='delReportEx(this)' role='button' href='#' data-report='" +
						report + "'> delete </a>";
					file_div.html(html);
				},
				error: function () {
					alert("Error posting feed.");
				}
			});
		}, function () {
			alertify.error('Cancel')
		});


	}

	function delReport(report) {
		alertify.confirm('', 'Are you sure ?', function () {
			alertify.success('Ok');
			var file_div = $('div[data-report="' + report + '"]');
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('upload/del_report'); ?>",
				data: {
					patient_id: <?php echo $patient_id; ?>,
					'report': report
				},
				success: function (data) {
					//$('#feed-container').prepend(data);
					file_div.html("");
				},
				error: function () {
					alert("Error posting feed.");
				}
			});
		}, function () {
			alertify.error('Cancel')
		});
	}

	$('form[id^=upload_]').submit(function (e) {

		e.preventDefault();

		var form = new FormData(this);
		report = form.get('report');
		patient_id = form.get('patient_id');
		filename = form.get('userfile').name.replace(' ', '_');
		console.log('');
		var file_div = $('div[data-report="' + report + '"]');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('upload/do_upload_ex'); ?>",
			data: form,
			processData: false,
			contentType: false,
			cache: false,
			success: function (data) {
				//$('#feed-container').prepend(data);
				alertify.success('file uploaded');
				//$('#mri_file_div').load('upload/load_upload_div?patient_id='+ <?php echo $patient_id ?>+ '&report=mr');
				let html = "";
				html +=
					"<a class='btn btn-primary btn-group mr-2'  role='button' href='<?php echo base_url() ?>index.php/upload/download/" +
					filename + "'>" + filename + "</a>";
				html +=
					"<a class='btn btn-warning btn-group mr-2' onclick='ChangeFileNameEx(this)' id='changedFilename' data-filename='" +
					filename + "' data-report='" + report + "' role='button' href='#' > rename </a>";
				html +=
					"<a class='btn btn-danger btn-group mr-2' onclick='delReportEx(this)' role='button' href='#' data-report='" +
					report + "'> delete </a>";
				file_div.html(html);
			},
			error: function () {
				alert("Error posting feed.");
			}
		});

	});

	// $("a[data-action='change_filename']").click(function () {
	// 	report = $(this).attr("data-report");
	// 	filename = $(this).attr("data-filename")
	// 	//alert(report);
	// 	//alert(filename);
	// 	ChangeFileName(report,filename);
	// 		});

	function ChangeFileNameEx(_this) {
		report = $(_this).attr("data-report");
		filename = $(_this).attr("data-filename")
		//alert(report);
		//alert(filename);
		console.log('$(_this)', $(_this));
		ChangeFileName(report, filename);

		console.log('test', _this);
	}

	function delReportEx(_this) {
		report = $(_this).attr("data-report");

		delReport(report, _this);
	}

	$("input[type='file']").change(function () {
		$(this)[0].nextElementSibling.innerHTML = $(this)[0].files[0].name;
	});

</script>

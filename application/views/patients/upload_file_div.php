<!-- <?php $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id); 
	if (!empty($patient_reports[$report])) :
        echo '<a class="btn btn-primary" role="button" href="'.base_url().'index.php/upload/download/'.$patient_reports[$report].'">'.$patient_reports[$report].'</a>';
        echo '<a class="btn btn-warning" role="button" href="#" onclick="ChangeFileName(\''.$report.'\',\''.$patient_reports[$report].'\')" > rename </a>';
        echo '<a class="btn btn-danger" role="button" href="#" onclick="delReport(\''.$report.'\')"> delete </a>';
 endif ?> -->

 <?php $patient_reports = $this->patient_reports_model->get_patient_reports($patient_id); 
	if (!empty($patient_reports[$report])) :
        echo "<a class='btn btn-primary btn-group mr-2'  role='button' href='".base_url()."index.php/upload/download/".$patient_reports[$report]."'>".$patient_reports[$report]."</a>";
        echo "<a class='btn btn-warning btn-group mr-2' onclick='ChangeFileNameEx(this)' data-filename='".$patient_reports[$report]."' data-report='".$report."' role='button' href='#' > rename </a>";
        echo "<a class='btn btn-danger btn-group mr-2'  role='button' href='#' onclick='delReportEx(this)' data-report='".$report."'> delete </a>";
 endif ?>

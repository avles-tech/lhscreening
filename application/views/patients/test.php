


<?php
$patient_details = $this->patients_model->get_patients($patient_id);

$date1=date_create($patient_details['dob']);
    $date2=new DateTime();

    $diff=date_diff($date1,$date2);

    $gender = $patient_details['gender'] == '1' ? 'Male' : 'Female';

?>	
<div id='report'>
<link href="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/css/bootstrap.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/jquery-3.3.1/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>

    <h5>REGISTRATION &amp; CONSENT FORM</h5>
    <p>First Name <?php echo array_key_exists('first_name', $patient_details) ? $patient_details['first_name'] : '';?></p>

    <table class="table">
    <tbody>
    <tr> <td>First Name </td> <td><b><?php echo $patient_details['first_name'] ?></b></td></tr>
    <tr> <td>Last Name </td> <td><b><?php echo $patient_details['last_name'] ?></b></td></tr>
    <tr> <td>Gender </td> <td><b><?php echo $gender ?></b></td></tr>
    <tr> <td>Age </td> <td><b><?php echo ($diff->format("%Y Years %m Months")) ?></b></td></tr>
    <tr> <td>Date of birth </td> <td><b><?php echo nice_date($patient_details['dob'],'d-M-Y') ?></b></td></tr>
    <tr> <td>Email </td> <td><b><?php echo $patient_details['email'] ?></b></td></tr>
    <tr> <td>Phone Mobile </td> <td><b><?php echo $patient_details['phone_mobile'] ?></b></td></tr>
    <tr> <td>Phone Home </td> <td><b><?php echo $patient_details['phone_home'] ?></b></td></tr>
    <tr> <td>Phone Work </td> <td><b><?php echo $patient_details['phone_work'] ?></b></td></tr>
    <tr> <td>Address </td> <td><b><?php echo $patient_details['address'] ?></b></td></tr>
    <tr> <td>Postal Code </td> <td><b><?php echo $patient_details['postal_code'] ?></b></td></tr>
    <tr> <td>Blood Group </td> <td><b><?php echo $patient_details['blood_group'] ?></b></td></tr>
    <tr> <td>Occupation </td> <td><b><?php echo $patient_details['occupation'] ?></b></td></tr>
    </tbody></table>
</div>
<script>

function getBase64Image(img) {

var canvas = document.createElement("canvas");

canvas.width = img.width;
canvas.height = img.height;
var ctx = canvas.getContext("2d");

ctx.drawImage(img, 0, 0);

var dataURL = canvas.toDataURL("image/png");

return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");

}
var img = new Image();

img.onload = function(){
var dataURI = getBase64Image(img);
return dataURI;

}

img.src = "<?php echo base_url(); ?>assets/lyca/images/logo.png";


$(document).ready(function () {
	var doc = new jsPDF('p','mm','a4');

	var elementHandler = {
	'#ignorePDF': function (element, renderer) {
		return true;
	}
	};

    var source = window.document.getElementById("report");
    
    doc.addImage(img.onload(), 'png', 0, 5);
    
	doc.addHTML(
		source,
		2,
		23,
		{
		'width': 180,'elementHandlers': elementHandler
		});
    window.open(doc.output('bloburl'),'test');
    });


</script>
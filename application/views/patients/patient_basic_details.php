<?php
$patient_details = array();

if($patient_id==0){
	$patient_details['patient_id'] = '0';
}
else{
	$patient_details = $this->patients_model->get_patients($patient_id);
}
?>
<div class="form-row">
	<div class="col form-group">
		<label>First name </label>
		<input type="text" class="form-control" placeholder="" name='first_name' value="<?php echo array_key_exists('first_name', $patient_details) ? $patient_details['first_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Last name</label>
		<input type="text" class="form-control" placeholder=" " name='last_name' value="<?php echo array_key_exists('last_name', $patient_details) ? $patient_details['last_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label>Email address</label>
	<input type="email" class="form-control" placeholder="" name='email' value="<?php echo array_key_exists('email', $patient_details) ? $patient_details['email'] : '';?>"
	 required>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Phone home</label>
		<input class='form-control' name='phone_home' value="<?php echo array_key_exists('phone_home', $patient_details) ? $patient_details['phone_home'] : '';?>"/>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		<label>Phone mobile</label>
		<input class='form-control' name='phone_mobile' value="<?php echo array_key_exists('phone_mobile', $patient_details) ? $patient_details['phone_mobile'] : '';?>"/>
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Phone work</label>
		<input class='form-control' name='phone_work' value="<?php echo array_key_exists('phone_work', $patient_details) ? $patient_details['phone_work'] : '';?>" />
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">

	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="1" <?php echo array_key_exists('gender',
		 $patient_details) ? $patient_details['gender']=='1' ? 'checked' : '' : '' ; ?>>
		<span class="form-check-label"> Male </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="0" <?php echo array_key_exists('gender',
		 $patient_details) ? $patient_details['gender']=='0' ? 'checked' : '' : '' ; ?>>
		<span class="form-check-label"> Female</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Date of Birth</label>
		<input type="date" class="form-control" name='dob' value="<?php echo array_key_exists('dob', $patient_details) ? nice_date($patient_details['dob'], 'Y-m-d') : '';?>"
		 required>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		<label>Age</label>
		<input class='form-control' name='age' />
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label>Address</label>
	<textarea class="form-control" name='address'><?php echo array_key_exists('address', $patient_details) ? $patient_details['address'] : '';?> </textarea>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Postal code</label>
		<input class='form-control' name='postal_code' value="<?php echo array_key_exists('postal_code', $patient_details) ? $patient_details['postal_code'] : '';?>"/>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">

	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->

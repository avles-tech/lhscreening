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
		<input type="text" class="form-control" name='first_name' value="<?php echo array_key_exists('first_name', $patient_details) ? $patient_details['first_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Last name</label>
		<input type="text" class="form-control" name='last_name' value="<?php echo array_key_exists('last_name', $patient_details) ? $patient_details['last_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label>Email address</label>
	<input type="email" class="form-control" name='email' value="<?php echo array_key_exists('email', $patient_details) ? $patient_details['email'] : '';?>"
	 required>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Phone home</label>
		<input class='form-control' name='phone_home' type='tel' pattern='/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/g'
		 value="<?php echo array_key_exists('phone_home', $patient_details) ? $patient_details['phone_home'] : '';?>" />
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		<label>Phone mobile</label>
		<input class='form-control' name='phone_mobile' type='tel' value="<?php echo array_key_exists('phone_mobile', $patient_details) ? $patient_details['phone_mobile'] : '';?>" />
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Phone work</label>
		<input class='form-control' name='phone_work' type='tel' value="<?php echo array_key_exists('phone_work', $patient_details) ? $patient_details['phone_work'] : '';?>" />
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">

	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="1" <?php echo array_key_exists('gender',
		 $patient_details) ? $patient_details['gender']=='1' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> Male </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="0" <?php echo array_key_exists('gender',
		 $patient_details) ? $patient_details['gender']=='0' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> Female</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Date of Birth</label>
		<input type="date" min="1900-01-01" max="2100-12-31" onBlur="getAge(this.value)" class="form-control" name='dob'
		 value="<?php echo array_key_exists('dob', $patient_details) ? nice_date($patient_details['dob'], 'Y-m-d') : '';?>"
		 required>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		<label>Age</label>
		<input class='form-control' name='age' value="<?php echo array_key_exists('age', $patient_details) ? $patient_details['age']:'';?>" />
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label>London Address (Permanent / Temporary)</label>
	<textarea class="form-control" name='address'><?php echo array_key_exists('address', $patient_details) ? $patient_details['address'] : '';?> </textarea>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Postal code</label>
		<input class='form-control' name='postal_code' value="<?php echo array_key_exists('postal_code', $patient_details) ? $patient_details['postal_code'] : '';?>" />
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">

	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-row">
	<div class="col form-group">
		<label>Blood group</label>
		<input type="text" class="form-control" name='blood_group' value="<?php echo array_key_exists('blood_group', $patient_details) ? $patient_details['blood_group'] : '';?>">
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Occupation</label>
		<input type="text" class="form-control" name='occupation' value="<?php echo array_key_exists('occupation', $patient_details) ? $patient_details['occupation'] : '';?>">
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<br>
<h4>Next of kin details</h4>
<div class="form-row">
	<div class="col form-group">
		<label>Name</label>
		<input type="text" class="form-control" name="next_of_kin_name" value="" />
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Phone Number</label>
		<input type="text" class="form-control" name="next_of_kin_phone" value="" />
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label >Relationship</label>
	<input class="form-control" type="text" name="next_of_kin_relationship" value="" />
</div> <!-- form-group end.// -->
<div class="form-group">
	<label > In case of emergency if you are uncontactable, do you provide consent for your next of kin to be contacted
and for relevant clinical information to be divulged? </label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="next_of_kin_contact" value="1" <?php echo array_key_exists('next_of_kin_contact',
		 $patient_details) ? $patient_details['next_of_kin_contact']=='1' ? 'checked' : '' : '' ; ?> >
		<span class="form-check-label"> yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="next_of_kin_contact" value="0" <?php echo array_key_exists('next_of_kin_contact',
		 $patient_details) ? $patient_details['next_of_kin_contact']=='0' ? 'checked' : '' : '' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->

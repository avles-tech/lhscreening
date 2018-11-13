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
	<label>Relationship</label>
	<input class="form-control" type="text" name="next_of_kin_relationship" value="" />
</div> <!-- form-group end.// -->
<div class="form-group">
	<label> In case of emergency if you are uncontactable, do you provide consent for your next of kin to be contacted
		and for relevant clinical information to be divulged? </label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="next_of_kin_contact" value="1" <?php echo
		 array_key_exists('next_of_kin_contact', $patient_details) ? $patient_details['next_of_kin_contact']=='1' ? 'checked'
		 : '' : '' ; ?> >
		<span class="form-check-label"> yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="next_of_kin_contact" value="0" <?php echo
		 array_key_exists('next_of_kin_contact', $patient_details) ? $patient_details['next_of_kin_contact']=='0' ? 'checked'
		 : '' : '' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<br>
<h4>NHS / Alternative GP</h4>
<div class="form-group">
	<label>Name of NHS / Alternative GP</label>
	<input type="text" class="form-control" name="alternative_gp" value="" placeholder="If applicable" />
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>I consent to my medical information being shared with my regular GP if I am not contactable.</label>
	<br>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gp_contact_agree" value="1" <?php echo
		 array_key_exists('gp_contact_agree', $patient_details) ? $patient_details['gp_contact_agree']=='1' ? 'checked' : ''
		 : '' ; ?> >
		<span class="form-check-label"> Agree </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gp_contact_agree" value="0" <?php echo
		 array_key_exists('gp_contact_agree', $patient_details) ? $patient_details['gp_contact_agree']=='0' ? 'checked' : ''
		 : '' ; ?> >
		<span class="form-check-label"> Disagree</span>
	</label>
</div> <!-- form-group end.// -->
<br>
<h4>Health</h4>
<div class="form-group">
	<label>How is your health at present? Is there anything in particular you would like to discuss with
		the Doctor
		today?</label>
	<textarea class="form-control" name="your_health" placeholder="Enter your details here" rows="6"></textarea>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Are you taking any medications at present Kindly list the medications as well as
		doses?</label>
	<textarea class="form-control" name="current_medication" placeholder="Enter your details here" rows="6"></textarea>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Are you aware of any allergies to the following?</label>
	<br>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="milk_allergy">
		<label>Milk</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="eggs_allergy">
		<label>Eggs</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" id="peanuts_allergy" value="1" name="peanuts_allergy">
		<label for="peanuts_allergy">Peanuts</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" id="shellfish_allergy" value="1" name="shellfish_allergy">
		<label for="shellfish_allergy">Shellfish</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" id="iodine_allergy" value="1" name="iodine_allergy">
		<label for="iodine_allergy">Iodine</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" id="penicillin_allergy" value="1" name="penicillin_allergy">
		<label for="penicillin_allergy">Penicillin</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" id="nuts_allergy" value="1" name="nuts_allergy">
		<label for="nuts_allergy">Tree nuts(walnuts/almonds/pecan)</label>
	</div>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Other Allergies</label>
	<div class="form-check form-check-inline">
		<input type="radio" id="other_allergy_yes" value="1" name="other_allergy">
		<label for="other_allergy_yes">Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="radio" id="other_allergy_no" value="0" name="other_allergy" checked>
		<label for="other_allergy_no">No</label>
	</div>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Do you suffer from Hayfever?</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="hay_fever" value="1" <?php echo array_key_exists('hay_fever',
		 $patient_details) ? $patient_details['hay_fever']=='1' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="hay_fever" value="0" <?php echo array_key_exists('hay_fever',
		 $patient_details) ? $patient_details['hay_fever']=='0' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Do you have Asthma?</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="asthma" value="1" <?php echo array_key_exists('asthma',
		 $patient_details) ? $patient_details['asthma']=='1' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="asthma" value="0" <?php echo array_key_exists('asthma',
		 $patient_details) ? $patient_details['asthma']=='0' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<h4>CHAPERONE</h4>
<div class="form-group">
	<label>Please advise us before any consultations whether you wish to have a chaperone.</label>
	<label>Do you require a chaperone before this consultation?</label>
	<br>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="if_chaperone" value="1" <?php echo array_key_exists('if_chaperone',
		 $patient_details) ? $patient_details['if_chaperone']=='1' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="if_chaperone" value="0" <?php echo array_key_exists('if_chaperone',
		 $patient_details) ? $patient_details['if_chaperone']=='0' ? 'checked' : '' : '' ; ?> required>
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->

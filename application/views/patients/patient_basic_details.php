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
		<!-- <label>Blood group</label>
		<input type="text" class="form-control" name='blood_group' value="<?php echo array_key_exists('blood_group', $patient_details) ? $patient_details['blood_group'] : '';?>"> -->
		<label>Blood group</label>
		<select class="form-control" name='blood_group' value="<?php echo array_key_exists('blood_group', $patient_details) ? $patient_details['blood_group'] : '';?>">
			<option value="A+">A+</option>
			<option value="A-">A-</option>
			<option value="B+">B+</option>
			<option value="B-">B-</option>
			<option value="O+">O+</option>
			<option value="O-">O-</option>
			<option value="AB+">AB+</option>
			<option value="AB-">AB-</option>
		</select>
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
		<input type="text" class="form-control" name="next_of_kin_name" value="<?php echo array_key_exists('next_of_kin_name', $patient_details) ? $patient_details['next_of_kin_name'] : '';?>" />
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Phone Number</label>
		<input type="text" class="form-control" name="next_of_kin_phone" value="<?php echo array_key_exists('next_of_kin_phone', $patient_details) ? $patient_details['next_of_kin_phone'] : '';?>" />
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label>Relationship</label>
	<input class="form-control" type="text" name="next_of_kin_relationship" value="<?php echo array_key_exists('next_of_kin_phone', $patient_details) ? $patient_details['next_of_kin_phone'] : '';?>" />
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
		 : '' : 'checked' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<br>
<h4>NHS / Alternative GP</h4>
<div class="form-group">
	<label>Name of NHS / Alternative GP</label>
	<input type="text" class="form-control" name="alternative_gp" value="<?php echo array_key_exists('alternative_gp', $patient_details) ? $patient_details['alternative_gp'] : '';?>" placeholder="If applicable" />
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
		 : 'checked' ; ?> >
		<span class="form-check-label"> Disagree</span>
	</label>
</div> <!-- form-group end.// -->
<br>
<h4>Health</h4>
<div class="form-group">
	<label>How is your health at present? Is there anything in particular you would like to discuss with
		the Doctor
		today?</label>
	<textarea class="form-control" name="health_at_present" placeholder="Enter your details here" rows="6"><?php echo
		 array_key_exists('health_at_present', $patient_details) ? $patient_details['health_at_present'] : '' ; 
	?></textarea>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Are you taking any medications at present Kindly list the medications as well as
		doses?</label>
	<textarea class="form-control" name="current_medication" placeholder="Enter your details here" rows="6"><?php echo
		 array_key_exists('current_medication', $patient_details) ? $patient_details['current_medication'] : '' ; 
	?></textarea>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Are you aware of any allergies to the following?</label>
	<br>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_milk" <?php echo array_key_exists('allergy_milk',
		 $patient_details) ? $patient_details['allergy_milk']=='1' ? 'checked' : '' : '' ; ?>>
		<label>Milk</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_eggs" <?php echo array_key_exists('allergy_eggs',
		 $patient_details) ? $patient_details['allergy_eggs']=='1' ? 'checked' : '' : '' ; ?>>
		<label>Eggs</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_peanuts" <?php echo array_key_exists('allergy_peanuts',
		 $patient_details) ? $patient_details['allergy_peanuts']=='1' ? 'checked' : '' : '' ; ?>>
		<label >Peanuts</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_shellfish" <?php echo array_key_exists('allergy_shellfish',
		 $patient_details) ? $patient_details['allergy_shellfish']=='1' ? 'checked' : '' : '' ; ?>>
		<label >Shellfish</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_iodine" <?php echo array_key_exists('allergy_iodine',
		 $patient_details) ? $patient_details['allergy_iodine']=='1' ? 'checked' : '' : '' ; ?>>
		<label >Iodine</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_pencillin" <?php echo array_key_exists('allergy_pencillin',
		 $patient_details) ? $patient_details['allergy_pencillin']=='1' ? 'checked' : '' : '' ; ?>>
		<label >Penicillin</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="checkbox" value="1" name="allergy_treenuts" <?php echo array_key_exists('allergy_treenuts',
		 $patient_details) ? $patient_details['allergy_treenuts']=='1' ? 'checked' : '' : '' ; ?>>
		<label>Tree nuts(walnuts/almonds/pecan)</label>
	</div>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Other Allergies</label>
	<div class="form-check form-check-inline">
		<input type="radio" value="1" id="allergy_others_yes" name="allergy_others" <?php echo array_key_exists('allergy_others',
		 $patient_details) ? $patient_details['allergy_others']=='1' ? 'checked' : '' : '' ; ?>>
		<label>Yes</label>
	</div>
	<div class="form-check form-check-inline">
		<input type="radio" value="0" id="allergy_others_no" name="allergy_others" <?php echo array_key_exists('allergy_others',
		 $patient_details) ? $patient_details['allergy_others']=='0' ? 'checked' : '' : 'checked' ; ?>>
		<label>No</label>
	</div>
</div> <!-- form-group end.// -->
<div class="form-group" style="display:none;" id="allergy_others_details_div">
	<label>Please Specify</label>
	<textarea name="allergy_others_details" placeholder="Enter your details here" rows="4" class="form-control"><?php echo
		 array_key_exists('allergy_others_details', $patient_details) ? $patient_details['allergy_others_details'] : '' ; 
	?></textarea>
</div>
<div class="form-group">
	<label>Do you suffer from Hayfever?</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="hay_fever" value="1" <?php echo array_key_exists('hay_fever',
		 $patient_details) ? $patient_details['hay_fever']=='1' ? 'checked' : '' : '' ; ?> >
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="hay_fever" value="0" <?php echo array_key_exists('hay_fever',
		 $patient_details) ? $patient_details['hay_fever']=='0' ? 'checked' : '' : 'checked' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label>Do you have Asthma?</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="asthma" value="1" <?php echo array_key_exists('asthma',
		 $patient_details) ? $patient_details['asthma']=='1' ? 'checked' : '' : '' ; ?> >
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="asthma" value="0" <?php echo array_key_exists('asthma',
		 $patient_details) ? $patient_details['asthma']=='0' ? 'checked' : '' : 'checked' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<h4>CHAPERONE</h4>
<div class="form-group">
	<label>Please advise us before any consultations whether you wish to have a chaperone.</label>
	<br>
	<label>Do you require a chaperone before this consultation?</label>
	<br>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="chaperone_required" value="1" <?php echo array_key_exists('chaperone_required',
		 $patient_details) ? $patient_details['chaperone_required']=='1' ? 'checked' : '' : '' ; ?> >
		<span class="form-check-label"> Yes </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="chaperone_required" value="0" <?php echo array_key_exists('chaperone_required',
		 $patient_details) ? $patient_details['chaperone_required']=='0' ? 'checked' : '' : 'checked' ; ?> >
		<span class="form-check-label"> No</span>
	</label>
</div> <!-- form-group end.// -->
<script>
	$('#allergy_others_yes').click(function(){
		this.checked?$('#allergy_others_details_div').show():$('#allergy_others_details_div').hide(); //time for show
	});
	$('#allergy_others_no').click(function(){
		this.checked?$('#allergy_others_details_div').hide():$('#allergy_others_details_div').show(); //time for show
	});

	//Age
	function getAge(birthDate) {
		var birth_date = new Date(birthDate);
		var currentDate = new Date();

		var years = (currentDate.getFullYear() - birth_date.getFullYear());

		if (currentDate.getMonth() < birth_date.getMonth() ||
				currentDate.getMonth() == birth_date.getMonth() && currentDate.getDate() < birth_date.getDate()) {
			years--;
		}
		$('input[name=age]').val(years);
	}
</script>

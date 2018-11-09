<div class="form-row">
	<div class="col form-group">
		<label>First name </label>
		<input type="text" class="form-control" placeholder="" name='first_name' value="<?php echo array_key_exists('first_name', $patient) ? $patient['first_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Last name</label>
		<input type="text" class="form-control" placeholder=" " name='last_name' value="<?php echo array_key_exists('last_name', $patient) ? $patient['last_name'] : '';?>"
		 required>
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label>Email address</label>
	<input type="email" class="form-control" placeholder="" name='email' value="<?php echo array_key_exists('email', $patient) ? $patient['email'] : '';?>"
	required>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="1" <?php echo array_key_exists('gender', $patient) ? $patient['gender'] == '1' ?  'checked' : '' : ''; ?>>
		<span class="form-check-label"> Male </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="0" <?php echo array_key_exists('gender', $patient) ? $patient['gender'] == '0' ?  'checked' : '' : ''; ?>>
		<span class="form-check-label"> Female</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Date of Birth</label>
		<input type="date" class="form-control" name='dob' value="<?php echo array_key_exists('dob', $patient) ? nice_date($patient['dob'], 'Y-m-d') : '';?>" required>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		<label>Age</label>
		<input class='form-control' name='age'/>
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label>Address</label>
	<textarea class="form-control" name='address'><?php echo array_key_exists('address', $patient) ? $patient['address'] : '';?> </textarea>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
	<label>Postal code</label>
	<input class='form-control' name='postal_code'/>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
		
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->

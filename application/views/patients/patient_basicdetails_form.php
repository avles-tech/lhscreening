<div class="form-row">
	<div class="col form-group">
		<label>First name </label>
		<input type="text" class="form-control" placeholder="" name='first_name' value="<?php echo $patient['first_name']?>" required>
	</div> <!-- form-group end.// -->
	<div class="col form-group">
		<label>Last name</label>
		<input type="text" class="form-control" placeholder=" " name='last_name' value="<?php echo $patient['last_name']?>" required>
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<label>Email address</label>
	<input type="email" class="form-control" placeholder="" name='email' value="<?php echo $patient['email']?>" required>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="1" <?php if($patient['gender']=='1') echo 'checked' ?>>
		<span class="form-check-label"> Male </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="0" <?php if($patient['gender']=='0') echo 'checked' ?>>
		<span class="form-check-label"> Female</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<label>Date of Birth</label>
		<input type="date" class="form-control" name='dob' value="<?php echo nice_date($patient['dob'], 'Y-m-d')?>" required>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<label>Address</label>
	<textarea class="form-control" name='address'> <?php echo $patient['address']?> </textarea>
</div> <!-- form-group end.// -->

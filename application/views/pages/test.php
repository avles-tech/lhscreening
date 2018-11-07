<div class="form-row">
	<div class="col form-group">
		<?php 
			echo form_label('First Name', 'first_name');
			$data = array(
				'id' => 'first_name',
				'class' => 'form-control',
				'placeholder' => 'First name',
				'required'=>'required'
			);
			if(array_key_exists('first_name', $patient)){
				$data['value'] = $patient['first_name'];
			}
			else{
				$data['value'] = '';
			}
			echo form_input($data);
		?>

	</div>
	<div class="col form-group">
		<?php 
				echo form_label('Last Name', 'last_name');
				$data = array(
					'id' => 'last_name',
					'class' => 'form-control',
					'placeholder' => 'Last name'
				);
				if(array_key_exists('last_name', $patient)){
					$data['value'] = $patient['last_name'];
				}
				else{
					$data['value'] = '';
				}
				echo form_input($data);
			?>
	</div> <!-- form-group end.// -->
</div> <!-- form-row end.// -->
<div class="form-group">
	<?php 
		echo form_label('Email', 'email');
		$data = array(
			'id' => 'email',
			'class' => 'form-control',
			'placeholder' => 'Email',
			'type'=>"email"
		);
		if(array_key_exists('email', $patient)){
			$data['value'] = $patient['email'];
		}
		else{
			$data['value'] = '';
		}
		echo form_input($data);
	?>
</div> <!-- form-group end.// -->
<div class="form-group">
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="1">
		<span class="form-check-label"> Male </span>
	</label>
	<label class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="gender" value="0">
		<span class="form-check-label"> Female</span>
	</label>
</div> <!-- form-group end.// -->
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo form_label('Date of Birth', 'dob');
			$data = array(
				'id' => 'dob',
				'class' => 'form-control',
				'placeholder' => 'Date of Birth',
				'type'=>"date"
			);
			if(array_key_exists('dob', $patient)){
				$data['value'] = nice_date($patient['dob'], 'Y-m-d');
			}
			else{
				$data['value'] = '';
			}
			echo form_input($data);
		?>
	</div> <!-- form-group end.// -->
	<div class="form-group col-md-6">
	</div> <!-- form-group end.// -->
</div> <!-- form-row.// -->
<div class="form-group">
	<?php 
		echo form_label('Address', 'address');
		$data = array(
			'id' => 'address',
			'class' => 'form-control',
			'placeholder' => 'Address',
			'type'=>"date"
		);
		if(array_key_exists('address', $patient)){
			$data['value'] = $patient['address'];
		}
		else{
			$data['value'] = '';
		}
		echo form_textarea($data);
	?>
</div> <!-- form-group end.// -->

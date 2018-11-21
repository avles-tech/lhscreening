<div class="card">
	<article class="card-body">
		<?php
			$patient_medical_history_details = $this->patient_medical_history_model->get($patient_id);
            echo validation_errors();  
			echo form_open('patients/update_medical_history');
			echo form_hidden('patient_id',$patient_id);
        ?>
		<h3>Medical history</h3>
		<div class="col form-group">
			<label>Present Symptoms</label>
			<textarea class="form-control" name='present_symptoms'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['present_symptoms'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Past Medical History</label>
			<textarea class="form-control" name='past_medical_history'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['past_medical_history'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Current Treatment (if applicable)</label>
			<textarea class="form-control" name='current_treatment'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['current_treatment'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Men's / Women's Health</label>
			<textarea class="form-control" name='health'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['health'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Family History</label>
			<textarea class="form-control" name='family_history'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['family_history'] : '';?> </textarea>
		</div>
		<!-- form-group end.// -->
		<h3>Vaccinations</h3>
		<div class="form-group">
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_mumps" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_mumps']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Mumps</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_rubella" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_rubella']=='1' ? 'checked' : '' : '' ; ?>>
				<label>German Measles (Rubella)</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_tb" <?php !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_tb']=='1' ? 'checked' : '' : '' ; ?>>
				<label> Chicken Pox</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_chicken_pox" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_chicken_pox']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Tuberculosis (TB)</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_tetanus" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_tetanus']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Tetanus</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_polio" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_polio']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Polio</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_hepatitis" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_hepatitis']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Hepatitis</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_diphtheria" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_diphtheria']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Diphtheria</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_scarlet_fever" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_scarlet_fever']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Scarlet Fever</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_yellow_fever" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_yellow_fever']=='1' ? 'checked' : '' : '' ; ?>>
				<label>Yellow Fever</label>
			</div>
		</div> <!-- form-group end.// -->
		<h3>Lifestyle</h3>
		<div class="form-group">
			<label>Smoking</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Non-smoker" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Non-smoker' ? 'checked' :
				 '' : '' ; ?> >
				<span class="form-check-label"> Non-smoker </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Social" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Social' ? 'checked' : ''
				 : '' ; ?> >
				<span class="form-check-label"> Social </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Frequent" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Frequent' ? 'checked' :
				 '' : '' ; ?> >
				<span class="form-check-label"> Frequent </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Moderate" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Moderate' ? 'checked' :
				 '' : '' ; ?> >
				<span class="form-check-label"> Moderate </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Chronic" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Chronic' ? 'checked' : ''
				 : '' ; ?> >
				<span class="form-check-label"> Chronic </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="form-group">
			<label>Sleep</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="4-5 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='4-5 Hours' ? 'checked' : ''
				 : '' ; ?> >
				<span class="form-check-label"> 4-5 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="6-8 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='6-8 Hours' ? 'checked' : ''
				 : '' ; ?> >
				<span class="form-check-label"> 6-8 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="8-10 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='8-10 Hours' ? 'checked' :
				 '' : '' ; ?> >
				<span class="form-check-label"> 8-10 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value=">10 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='>10 Hours' ? 'checked' : ''
				 : '' ; ?> >
				<span class="form-check-label"> >10 Hours </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Sleep comments</label>
			<textarea class="form-control" name='sleep_comments'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep_comments'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Alcohol Consumption</label>
			<textarea class="form-control" name='alcohol_consumption'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['alcohol_consumption'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Diet</label>
			<textarea class="form-control" name='diet'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['diet'] : '';?> </textarea>
		</div>
		<div class="form-group">
			<label>Exercise</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="None" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='None' ? 'checked' : '' :
				 '' ; ?> >
				<span class="form-check-label"> None </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="Low" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='Low' ? 'checked' : '' :
				 '' ; ?> >
				<span class="form-check-label"> Low </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="Moderate" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='Moderate' ? 'checked' :
				 '' : '' ; ?> >
				<span class="form-check-label"> Moderate </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="High" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='High' ? 'checked' : '' :
				 '' ; ?> >
				<span class="form-check-label"> >10 Hours </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Additional comments on exercise</label>
			<textarea class="form-control" placeholder="Additional comments on exercise." name='exercise_comments'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise_comments'] : '';?> </textarea>
		</div>
		<h3>Examinations</h3>
		<div class="col form-group">
			<label>Height</label>
			<input type="text" class="form-control" name='height' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['height'] : '';?>">
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Weight</label>
			<input type="text" class="form-control" name='weight' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['weight'] : '';?>">
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Body Mass Index</label>
			<input type="text" class="form-control" name='body_mass' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['body_mass'] : '';?>">
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Body Fat</label>
			<input type="text" class="form-control" name='body_fat' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['body_fat'] : '';?>">
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Extraordinary Physical Findings</label>
			<textarea class="form-control" name='extra_ordinary_physical'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['extra_ordinary_physical'] : '';?> </textarea>
		</div>
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block"> Save </button>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>

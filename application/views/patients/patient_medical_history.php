<div class="card">
	<article class="card-body">
		<?php
			$patient_medical_history_details = $this->patient_medical_history_model->get($patient_id);
			
            echo validation_errors();  
			//echo form_open('patients/update_medical_history');
			echo form_open('medical_history_form',array( 'id' => 'medical_history_form'));
			echo form_hidden('patient_id',$patient_id);
        ?>
		<h3>Medical history</h3>
		<div class="col form-group">
			<label>Present Symptoms</label>
			<textarea <?php echo $read_only ?> class="form-control" name='present_symptoms'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['present_symptoms'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Past Medical History</label>
			<textarea <?php echo $read_only ?> class="form-control" name='past_medical_history'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['past_medical_history'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Current Treatment (if applicable)</label>
			<textarea <?php echo $read_only ?> class="form-control" name='current_treatment'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['current_treatment'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Men's / Women's Health</label>
			<textarea <?php echo $read_only ?> <?php echo $read_only ?> class="form-control" name='health'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['health'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Family History</label>
			<textarea <?php echo $read_only ?> class="form-control" name='family_history'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['family_history'] : '';?> </textarea>
		</div>
		<!-- form-group end.// -->
		<h3>Travel & Vaccination History</h3>
		<div class="form-group">
			<div class="col-md-1 col-sm-1 col-xs-12">
				<a id="travel-add" class="btn btn-success" type="button">Add <span class="fa fa-plus"></span></a>
			</div>
			<br>
			<div class="col-md-6 col-sm-6 col-xs-12" id="travel-history-block">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Destination</th>
							<th>Date</th>
							<th>Duration in days</th>
						</tr>
					</thead>
					<tbody>
						<tr class="hidden">
							<td>
								<input type="text" name="travel[travel_destination]" class="form-control" placeholder="Destination" data-parsley-id="47">
							</td>
							<td>
								<input type="date" name="travel[travel_date]" class="form-control" placeholder="Date" data-parsley-id="49">
							</td>
							<td class="col-xs-3" style="padding-left:0">
								<input type="number" name="travel[travel_duration]" class="form-control" placeholder="Duration in days"
								 data-parsley-id="51">
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="travel[travel_destination]" class="form-control" placeholder="Destination" data-parsley-id="53">
							</td>
							<td>
								<input type="date" name="travel[travel_date]" class="form-control" placeholder="Date" data-parsley-id="55">
							</td>
							<td class="col-xs-3" style="padding-left:0">
								<input type="number" name="travel[travel_duration]" class="form-control" placeholder="Duration in days"
								 data-parsley-id="57">
							</td>
						</tr>
						<tr class="validate_this" style="display: table-row;">
							<td>
								<input type="text" name="travel[travel_destination]" class="form-control" placeholder="Destination" data-parsley-id="47">
							</td>
							<td>
								<input type="date" name="travel[travel_date]" class="form-control" placeholder="Date" data-parsley-id="49">
							</td>
							<td class="col-xs-3" style="padding-left:0">
								<input type="number" name="travel[travel_duration]" class="form-control" placeholder="Duration in days"
								 data-parsley-id="51">
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<blockquote>Travel date is important, if accurate date is unknown please select rough date.</blockquote>
			</div>
		</div>
		<h3>Family History</h3>
		<p>
		List any genetic or hereditary or other known major medical conditions </br>
		For example: Breast Cancer | Prostate Cancer| Diabetes | High Blood Pressure | Sickle Cell anaemia | Obesity| Down Syndrome | Arthritis | other?
		</p>
		<table class='table  table-responsive'>
			<thead>
				<tr>
					<td scope="col"></td>
					<td scope="col" class='text-center'>Maternal</td>
					<td scope="col" class='text-center'> Paternal</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Great grandparents</td>
					<td>
						<input class='form-control' name='great_grandparents_maternal' value="<?php echo !empty($patient_medical_history_details['great_grandparents_maternal']) ? $patient_medical_history_details['great_grandparents_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='great_grand_parents_paternal' value="<?php echo !empty($patient_medical_history_details['great_grand_parents_paternal']) ? $patient_medical_history_details['great_grand_parents_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Grandfather</td>
					<td>
						<input class='form-control' name='grandfather_maternal' value="<?php echo !empty($patient_medical_history_details['grandfather_maternal']) ? $patient_medical_history_details['grandfather_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='grandfather_paternal' value="<?php echo !empty($patient_medical_history_details['grandfather_paternal']) ? $patient_medical_history_details['grandfather_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Grandmother</td>
					<td>
						<input class='form-control' name='grandmother_maternal' value="<?php echo !empty($patient_medical_history_details['grandmother_maternal']) ? $patient_medical_history_details['grandmother_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='grandmother_paternal' value="<?php echo !empty($patient_medical_history_details['grandmother_paternal']) ? $patient_medical_history_details['grandmother_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Aunts &amp; Uncles</td>
					<td>
						<input class='form-control' name='aunt_uncle_maternal' value="<?php echo !empty($patient_medical_history_details['aunt_uncle_maternal']) ? $patient_medical_history_details['aunt_uncle_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='aunt_uncle_paternal' value="<?php echo !empty($patient_medical_history_details['aunt_uncle_paternal']) ? $patient_medical_history_details['aunt_uncle_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Cousins</td>
					<td>
						<input class='form-control' name='cousins_maternal' value="<?php echo !empty($patient_medical_history_details['cousins_maternal']) ? $patient_medical_history_details['cousins_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='cousins_paternal' value="<?php echo !empty($patient_medical_history_details['cousins_paternal']) ? $patient_medical_history_details['cousins_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Parents</td>
					<td>
						<input class='form-control' name='parents_maternal' value="<?php echo !empty($patient_medical_history_details['parents_maternal']) ? $patient_medical_history_details['parents_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='parents_paternal' value="<?php echo !empty($patient_medical_history_details['parents_paternal']) ? $patient_medical_history_details['parents_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Siblings</td>
					<td>
						<input class='form-control' name='siblings_maternal' value="<?php echo !empty($patient_medical_history_details['siblings_maternal']) ? $patient_medical_history_details['siblings_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='siblings_paternal' value="<?php echo !empty($patient_medical_history_details['siblings_paternal']) ? $patient_medical_history_details['siblings_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
				<tr>
					<td>Offspring</td>
					<td>
						<input class='form-control' name='offspring_maternal' value="<?php echo !empty($patient_medical_history_details['offspring_maternal']) ? $patient_medical_history_details['offspring_maternal']:'';?>" <?php echo $read_only ?>/>
					</td>
					<td>
						<input class='form-control' name='offspring_paternal' value="<?php echo !empty($patient_medical_history_details['offspring_paternal']) ? $patient_medical_history_details['offspring_paternal']:'';?>" <?php echo $read_only ?>/>
					</td>
				</tr>
			</tbody>
		</table>
		<h3>Vaccinations</h3>
		<div class="form-group">
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_mumps" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_mumps']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Mumps</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_rubella" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_rubella']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?> <?php echo $read_only ?>>
				<label>German Measles (Rubella)</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_tb" <?php !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_tb']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?> <?php echo $read_only ?>>
				<label> Chicken Pox</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_chicken_pox" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_chicken_pox']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?> <?php echo $read_only ?>>
				<label>Tuberculosis (TB)</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_tetanus" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_tetanus']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Tetanus</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_polio" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_polio']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Polio</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_hepatitis" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_hepatitis']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Hepatitis</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_diphtheria" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_diphtheria']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Diphtheria</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_scarlet_fever" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_scarlet_fever']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Scarlet Fever</label>
			</div>
			<div class="form-check form-check-inline">
				<input type="checkbox" value="1" name="vaccine_yellow_fever" <?php echo !empty($patient_medical_history_details) ?
				 $patient_medical_history_details['vaccine_yellow_fever']=='1' ? 'checked' : '' : '' ; ?> <?php echo $read_only ?>>
				<label>Yellow Fever</label>
			</div>
		</div> <!-- form-group end.// -->
		<h3>Lifestyle</h3>
		<div class="form-group">
			<label>Smoking</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Non-smoker" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Non-smoker' ? 'checked' :
				 '' : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Non-smoker </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Social" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Social' ? 'checked' : ''
				 : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Social </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Frequent" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Frequent' ? 'checked' :
				 '' : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Frequent </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Moderate" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Moderate' ? 'checked' :
				 '' : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Moderate </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="smoking" value="Chronic" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['smoking']=='Chronic' ? 'checked' : ''
				 : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Chronic </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="form-group">
			<label>Sleep</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="4-5 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='4-5 Hours' ? 'checked' : ''
				 : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> 4-5 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="6-8 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='6-8 Hours' ? 'checked' : ''
				 : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> 6-8 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value="8-10 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='8-10 Hours' ? 'checked' :
				 '' : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> 8-10 Hours </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="sleep" value=">10 Hours" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep']=='>10 Hours' ? 'checked' : ''
				 : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> >10 Hours </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Sleep comments</label>
			<textarea <?php echo $read_only ?> class="form-control" name='sleep_comments'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['sleep_comments'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Alcohol Consumption</label>
			<textarea <?php echo $read_only ?> class="form-control" name='alcohol_consumption'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['alcohol_consumption'] : '';?> </textarea>
		</div>
		<div class="col form-group">
			<label>Diet</label>
			<textarea <?php echo $read_only ?> class="form-control" name='diet'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['diet'] : '';?> </textarea>
		</div>
		<div class="form-group">
			<label>Exercise</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="None" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='None' ? 'checked' : '' :
				 '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> None </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="Low" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='Low' ? 'checked' : '' :
				 '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Low </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="Moderate" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='Moderate' ? 'checked' :
				 '' : '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> Moderate </span>
			</label>
			<label class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="exercise" value="High" <?php echo
				 !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise']=='High' ? 'checked' : '' :
				 '' ; ?> <?php echo $read_only ?>>
				<span class="form-check-label"> >10 Hours </span>
			</label>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Additional comments on exercise</label>
			<textarea <?php echo $read_only ?> class="form-control" placeholder="Additional comments on exercise." name='exercise_comments'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['exercise_comments'] : '';?> </textarea>
		</div>
		<h3>Examinations</h3>
		<div class="col form-group">
			<label>Height</label>
			<input type="text" class="form-control" name='height' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['height'] : '';?>" <?php echo $read_only ?>>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Weight</label>
			<input type="text" class="form-control" name='weight' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['weight'] : '';?>" <?php echo $read_only ?>>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Body Mass Index</label>
			<input type="text" class="form-control" name='body_mass' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['body_mass'] : '';?>" <?php echo $read_only ?>>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Body Fat</label>
			<input type="text" class="form-control" name='body_fat' value="<?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['body_fat'] : '';?>" <?php echo $read_only ?>>
		</div> <!-- form-group end.// -->
		<div class="col form-group">
			<label>Extraordinary Physical Findings</label>
			<textarea <?php echo $read_only ?> class="form-control" name='extra_ordinary_physical'><?php echo !empty($patient_medical_history_details) ? $patient_medical_history_details['extra_ordinary_physical'] : '';?> </textarea>
		</div>
		<div class="form-row">
			<!-- form-group end.// -->
			<div class="form-group btn-group mr-2">
				<button type="submit" class="btn btn-primary btn-block" <?php echo $read_only ?>> Save </button>
			</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
						<button id='save_exit' class="btn btn-primary " <?php echo $read_only ?>>Save & Exit</button>
					</div> <!-- form-group// -->
			<div class="form-group btn-group mr-2">
				<a href="<?php echo base_url().'patients'?>" class="btn btn-danger" role='button'>Cancel</a>
			</div> <!-- form-group// -->
		</div>
		</form>
	</article>
</div>
<script>
	$(function () {
		$('a#travel-add').click(function () {
			var p = $('#travel-history-block').find('tbody');
			var c = p.find('tr:first').clone();
			c.show('slow');
			//c.find('select[name="add_ons[add_on_id][]"]').chosenDestroy();
			c.removeClass('hidden');
			c.addClass('validate_this');
			p.append(c);
			excuteTravelValid();
		});
		excuteTravelValid();
	});

	function excuteTravelValid() {
		$('#travel-history-block').find('tbody .validate_this input').keyup(function () {
			// console.log($(this).val());
			$(this).parent().parent('tr').children('td').children('input').each(function () {
				console.log($(this).val());
			});
			if ($(this).val()) {
				$(this).parent().parent('tr').children('td').children('input').each(function () {
					$(this).attr('required', true);
				});
			} else {
				$(this).parent().parent('tr').children('td').children('input').each(function () {
					$(this).removeAttr('required');
				});
			}
		});
	}

</script>

<script>
		$('form#medical_history_form').submit(function (e) {

			var form = $(this);

			e.preventDefault();

			$.ajax({
				type: "POST",
				url: "<?php echo site_url('patients/update_medical_history'); ?>",
				data: form.serialize(), // <--- THIS IS THE CHANGE
				dataType: "html",
				success: function (data) {
					//$('#feed-container').prepend(data);
					alertify.set('notifier','position', 'top-right');
					alertify.notify('Patient details updated', 'success', 5, function(){  console.log('dismissed'); });
				},
				error: function () {
					alert("Error posting feed.");
				}
			});

		});
	</script>

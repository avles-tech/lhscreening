<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm);?>
      </p>

      <p>
            <label> Qualification : </label><br />
            <?php echo form_input($qualification);?>
      </p>

      <p>
            <label> Designation : </label><br />
            <?php echo form_input($designation);?>
      </p>


      <?php if ($this->ion_auth->is_admin()): ?>

          <h3><?php echo lang('edit_user_groups_heading');?></h3>
          <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
              </label>
          <?php endforeach?>

      <?php endif ?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>

<div id='sig'>

</div>

<p style="clear: both;">
	<button id="clear">Clear</button> 
	<button type='button' id="save_signature">Save Signature</button>
</p>

<script>
      $(function () {
      	var sig = $('#sig').signature();
            <?php 
                  $filename = './uploads/'.$user->id.'_signature.jpeg'; 
                  if (file_exists($filename)) :?>
                        sig.signature('draw', '<?php echo 'data:image/jpeg;base64,'.base64_encode(file_get_contents($filename)) ?>');
                  <?php endif ?>
      	$('#save_signature').click(function () {
      		//alert(sig.signature('toSVG'));
                  var sig_jpeg = $('#sig').signature('toDataURL', 'image/jpeg');
                  //alert(sig_jpeg.split(',')[1]);
			$.ajax({
				url: "<?php echo base_url(); ?>upload/upload_signature",
				method: "POST",
				data: {
					user_id: <?php echo $user->id?>
                              ,signature : sig_jpeg
				},
				success: function (data) {
					$('#result').html(data);
                              location.reload();
				}
			});

      	});
            $('#clear').click(function() {
		sig.signature('clear');
	});


      });
</script>
<style>
.kbw-signature { width: 400px; height: 200px; }
</style>


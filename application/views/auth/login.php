<br>
<div class="float-right">
<a href="<?php echo base_url().'patients/create' ?>" > Register Patient</a>
</div>
<br>
<br>


<div id="infoMessage"><?php echo $message;?></div>
<div class="wrapper">
<?php echo form_open("auth/login",array('class'=>'form-signin'));?>
<!-- <h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p> -->
<h2>Please login</h2>
  <p>
    <?php echo form_input($identity);?>
  </p>
  <p>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn') ,array('class'=>'btn btn-lg btn-primary btn-block'));?></p>
  <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
<?php echo form_close();?>



</div>
<style>
  .form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);  

  .form-signin-heading,
	.checkbox {
	  margin-bottom: 30px;
	}

  .wrapper {	
    margin-top: 80px;
    margin-bottom: 80px;
  }
</style>
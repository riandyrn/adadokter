<div class="container">

  <div class="main-container col-md-offset-1">
	<img src="<?=base_url();?>assets/img/logo.png" alt="" class="pull-left hidden-xs hidden-sm">
	
	<?php if(isset($alert)) { ?>
		<p style="color:red;"><?=$alert;?></p>
	<?php } ?>
	
	<img id="baloon" src="<?=base_url();?>assets/img/polygon.png" alt="" class="pull-left hidden-xs hidden-sm">
	<div id="main_form" class="pull-left col-md-5 col-xs-12">
		<form action="<?=base_url();?>index.php/doctor/login" method="POST">
			<h3>Doctor Login</h3>
			<div class="form-group">
				<label for="">Username:</label>
				<input type="text" name="username" class="form-control" placeholder="Enter your username here...">
			</div>
			<div class="form-group">
				<label for="">Password:</label>
				<input type="password" name="password" class="form-control" placeholder="Enter your password here...">
			</div>
			<input type="submit" value="Login" class="btn btn-primary btn-lg btn-block">
		</form>
		<p id="forgot_password_link" class="text-center">
			<a href="" data-toggle="modal" data-target="#ModalNotYetImplemented"><small>forgot your password?</small></a>
		</p>
	</div>
  </div>

</div><!-- /.container -->

<div id="ModalNotYetImplemented" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="myModalLabel">Feature isn't implemented yet, sorry...</h3>
			</div>
			<div class="modal-body text-center">
				<span class="super-large-text">:(</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Well, Ok!</button>
			</div>
		</div>
  </div>
</div>

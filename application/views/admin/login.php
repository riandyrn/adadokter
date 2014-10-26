<?php $base_path = base_url() . 'index.php/admin/'; ?>
<div class="container">

  <div class="main-container">
	<?php if(isset($success)) { ?>
		<p class="success text-center"><b>Success:</b> <?=$success;?></p>
		<?php $this->session->unset_userdata('success'); ?>
	<?php } ?>
	<?php if(isset($error)) { ?>
		<p class="error text-center"><b>Error:</b> <?=$error;?></p>
		<?php $this->session->unset_userdata('error'); ?>
	<?php } ?>
	<div id="main_form" class="col-md-4 col-md-offset-4">
		<form action="<?=$base_path;?>" method="POST">
			<h3 class="title-admin">Admin Login</h3>
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
	</div>
  </div>

</div><!-- /.container -->
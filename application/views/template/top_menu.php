<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $current_page = $this->session->userdata('current_page'); ?>

<div class="navbar navbar-adadokter navbar-static-top" role="navigation">
  <div class="container">
	<div class="navbar-header">
	  <?php if($current_page != 'login') { ?>
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
	  <?php } ?>
	  <a class="navbar-brand" href="<?=$base_path;?>dashboard">
		<img id="logo_header" src="<?=base_url();?>assets/img/logo_header.png" alt="" class="col-md-9 hidden-sm hidden-xs">
		<img src="<?=base_url();?>assets/img/logo_header.png" alt="" class="hidden-md hidden-lg"
			style=
			"
				position: absolute;
				height: 35px;
				display: block;
				margin-left: -10px;
				margin-top: -7px;
			"
		>
	  </a>
	</div>
	<div class="collapse navbar-collapse">
	  <ul class="nav navbar-nav pull-right hidden-sm hidden-xs">
		<?php if($current_page != 'login') { ?>
			<li><a href="<?=$base_path;?>dashboard"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Dashboard</a></li>
			<li><a href="<?=$base_path;?>calendar"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Calendar</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/recallList"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Recall List</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/patientList"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Patient List</a></li>
			<li><a data-toggle="modal" data-target="#modalChangePassword" href=""><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Change Password</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
		<?php } ?>
	  </ul>
	  <ul class="nav navbar-nav hidden-md hidden-lg">
		<?php if($current_page != 'login') { ?>
			<li><a href="<?=$base_path;?>dashboard"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Dashboard</a></li>
			<li><a href="<?=$base_path;?>calendar"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Calendar</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/recallList"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Recall List</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/patientList"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Patient List</a></li>
			<li><a data-toggle="modal" data-target="#modalChangePassword" href=""><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Change Password</a></li>
			<li><a href="<?=base_url();?>index.php/doctor/logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
		<?php } ?>
	  </ul>	  
	</div><!--/.nav-collapse -->
  </div>
</div>

<div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">Change Password</h4>
	  </div>
	  <form action="<?=$base_path;?>changePassword_P" method="POST">
		  <div class="modal-body">
			<div class="form-group">
				<input type="text" name="password" class="form-control" placeholder="Enter your new password here">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="submit" class="btn btn-primary" value="Save">
		  </div>
	  </form>
	</div>
  </div>
</div>
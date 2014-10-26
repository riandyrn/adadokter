<?php $base_path = base_url() . 'index.php/admin/' ?>
<div class="navbar navbar-adadokter navbar-static-top" role="navigation">
  <div class="container">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="#">
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
		<ul class="nav navbar-nav pull-right hidden-xs hidden-sm">

			<?php if($this->session->userdata('id_admin') != null) { ?>
				<li class="active"><a href="<?=$base_path;?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Doctor List</a></li>
				<li class="active"><a href="<?=$base_path;?>logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
			<?php } ?>

		</ul>
		<ul class="nav navbar-nav hidden-md hidden-lg">
			
			<?php if($this->session->userdata('id_admin') != null) { ?>
				<li class="active"><a href="<?=$base_path;?>"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Doctor List</a></li>
				<li class="active"><a href="<?=$base_path;?>logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
			<?php } ?>
			
		</ul>	  
	</div><!--/.nav-collapse -->
  </div>
</div>
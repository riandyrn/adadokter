<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="content-container">
		
		<div class="row">
			<div class="col-md-12">
				
				<br>
				
				<div class="hidden-sm hidden-xs">
					<button data-toggle="modal" data-target="#modal_setting_time" class="btn btn-primary btn-adadokter"><span class="glyphicon glyphicon-cog"></span>&nbsp; Schedule Hour Setting</button>
					<a class="pull-right btn btn-primary btn-adadokter" href="<?=$base_path;?>addAppointment"><span class="glyphicon glyphicon-plus"></span>&nbsp;New Appointment</a>
					<button style="margin-right:5px;" class="pull-right btn btn-primary btn-adadokter" data-toggle="modal" data-target="#ModalTambahPatient"><span class="glyphicon glyphicon-plus"></span>&nbsp;New Patient</button>
				</div>				
				
				<div class="hidden-md hidden-lg" style="margin-bottom: 10px;">
					<button data-toggle="modal" data-target="#modal_setting_time" class="btn btn-sm btn-primary btn-adadokter  responsive-btn"><span class="glyphicon glyphicon-cog"></span>&nbsp; Schedule Hour Setting</button>
					<a class="pull-right btn btn-sm btn-primary btn-adadokter responsive-btn" href="<?=$base_path;?>addAppointment"><span class="glyphicon glyphicon-plus"></span>&nbsp;New Appointment</a>
				</div>
				
				<?php if($success != null) { ?>
					<br>
					<p class="success"><b>Success:<br></b> <?=$success;?></p>
					<?php $this->session->unset_userdata('success'); ?>
				<?php } ?>
				
				<?php if($error != null) { ?>
					<br>
					<p class="error"><b>Error:<br></b> <?=$error;?></p>
					<?php $this->session->unset_userdata('error'); ?>
				<?php } ?>

				<div id="calendar" class="hidden-xs hidden-sm"></div>
				<div id="small_calendar" class="hidden-md hidden-lg"></div>
				
			</div>
		</div>
		<br>
		<br>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="modal_setting_time" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="myModalLabel">Set Available Hour</h3>
		  </div>
		  <form action="<?=$base_path;?>set_doctor_available_time" method="POST">
			  <div class="modal-body">
				<div class="form-group">
					<label for="">Start Hour:</label>
					<select name="start_hour" id="" class="form-control">
						<?php foreach($all_available_time as $time) { ?>
							<option value="<?=$time->id;?>"
								<?php if($doctor_available_time) { ?>
									<?php if($time->time == $doctor_available_time->start_hour) { ?>
										selected
									<?php } ?>
								<?php } ?>
							><?=$time->time;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Finish Hour:</label>
					<select name="finish_hour" id="" class="form-control">
						<?php foreach($all_available_time as $time) { ?>
							<option value="<?=$time->id;?>"
								<?php if($doctor_available_time) { ?>
									<?php if($time->time == $doctor_available_time->finish_hour) { ?>
										selected
									<?php } ?>
								<?php } ?>
							><?=$time->time;?></option>
						<?php } ?>
					</select>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-primary" value="Save Settings">
			  </div>
		  </form>
		</div>
	  </div>
	</div>
	
	<div id="ModalTambahPatient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel">Add Patient</h3>
				</div>
				<form action="<?=base_url();?>index.php/doctor/addPatient" method="POST">
					<div class="modal-body">
							<div class="form-group">
								<label for="">Name:</label>
								<input type="text" name="name" class="form-control" placeholder="Enter patient name here...">
							</div>
							<div class="form-group">
								<label for="">Telephone Number:</label>
								<input type="text" name="telephone_number" class="form-control" placeholder="Enter patient telephone number here...">
							</div>
							<input type="hidden" name="id_doctor" value="<?=$this->session->userdata('id_doctor');?>">
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn btn-primary" value="Add">
					</div>
				</form>
			</div>
	  </div>
	</div>
</div><!-- /.container -->
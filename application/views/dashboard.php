<?php $base_path = base_url() . 'index.php/doctor/'; ?>

<div class="container">
	
	<div class="row header-container">
		<div class="col-md-12 hidden-sm hidden-xs">
			<a href="<?=$base_path;?>addAppointment" class="btn btn-primary btn-adadokter pull-right" style="margin-top: 15px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Appointment</a>
			<a href="<?=$base_path;?>addImmediateAppointment" class="btn btn-primary btn-adadokter pull-right" style="margin-top: 15px; margin-right: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Patient</a>
			<h1>Hi, <?=$this->session->userdata('username');?>!</h1>
			<h4>
				<?php 
					$now = date('Y-m-d', strtotime('now'));
					if($now == $date)
					{
				?>
					Today's
				<?php } else { ?>
					This date
				<?php } ?>
				appointment: 
				<span id="n_appoinment" style="font-size:1.2em; color: #32AA98; margin-top: -10px;"><?=count($appointments);?></span></h4>
		</div>
		<div class="col-md-12 hidden-md hidden-lg">

			<div style="display: inline">
				<p style="font-size: 0.8em;">
					<b>Hi, <?=$this->session->userdata('username');?>!</b> <br>
					<?php 
						$now = date('Y-m-d', strtotime('now'));
						if($now == $date)
						{
					?>
						Today's
					<?php } else { ?>
						This date
					<?php } ?>
					appointment: 
					<span id="n_appoinment" style="font-size:1.2em; color: #32AA98; margin-top: -10px;"><?=count($appointments);?></span>
					<a data-toggle="modal" data-target="#modalAppointment" class="btn btn-primary btn-sm btn-adadokter pull-right" style="margin-top: -15px;"><span class="glyphicon glyphicon-cog"></span>&nbsp;Dashboard Menu</a>			
				</p>
			</div>
		</div>
	</div>
	
	<?php if($success != null) { ?>
		<p class="success"><b>Success: </b> <?=$success;?></p>
		<?php $this->session->unset_userdata('success'); ?>
	<?php } ?>
							
	<div class="row">
		<div class="col-md-12 text-center hidden-sm hidden-xs">
			<h1>Dashboard</h1>
		</div>
		<div class="col-md-12 text-center hidden-md hidden-lg">
			<h2>Dashboard</h2>
		</div>		
	</div>
	
	<div class="row">
		<div class="col-md-12" style="padding-right: 1.5%; padding-left: 1.5%; background: #FCFCFC; border: 2px solid #7ED4D5; -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; margin: 0 1%;">
			<h3 class="text-center">
				<a href="<?=$base_path;?>dashboard/<?=$prevDate;?>">&laquo;</a>
				<?=date('D, d-M-Y', strtotime($date));?>
				<a href="<?=$base_path;?>dashboard/<?=$nextDate;?>">&raquo;</a>
			</h3>
			
			<?php if(count($appointments) > 0) { ?>
				<table class="table table-hover responsive-table">
					<thead>
						<tr>
							<th>Time</th>
							<th>Name</th>
							<th>App Status</th>
							<th>Treatment</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($appointments as $appointment) { ?>
							<tr>
								<td>
									<a 
										href="" 
										data-toggle="modal" 
										data-target="#modalConfirm" 
										class="edit-appointment" 
										style="color: #333;"
										data-id_appointment="<?=$appointment->id;?>"
										data-date="<?=$appointment->schedule_date;?>"
									>
										<span style="font-weight: bolder;">
											<?=$appointment->converted_time;?>
										</span>
									</a>
								</td>
								<td><a href="<?=$base_path;?>after_treatment/<?=$appointment->id_patient;?>" style="font-weight: bolder;"><?=$appointment->patient_name;?></a></td>
								<td>
									<select data-id="<?=$appointment->id;?>" name="" id="" class="appointment-status">
										<option 
											value="0"
											<?php if($appointment->status == 0) { echo 'selected'; }?>
										>
											unconfirmed
										</option>
										<option 
											value="1"
											<?php if($appointment->status == 1) { echo 'selected'; }?>
										>
											confirmed
										</option>
										<option 
											value="2"
											<?php if($appointment->status == 2) { echo 'selected'; }?>
											>
											canceled
										</option>
									</select>
								</td>
								<td>
									<?php if($appointment->treatment_status) { ?>
										<span style="color: green; font-weight: bolder;"><span class="glyphicon glyphicon-ok"></span></span>
									<?php } else { ?>
										<a class="edit-btn" data-name="<?=$appointment->patient_name;?>" data-id_patient="<?=$appointment->id_patient;?>" data-toggle="modal" data-target="#myModal" href="#">edit</a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<br>
				<h4 class="text-center">No appointments on this date</h4>
				<br>
			<?php } ?>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="myModalLabel">Treatment for <span id="name"></span></h3>
		  </div>
		<form action="<?=$base_path;?>addTreatment_P" method="POST">
		  <div class="modal-body">
			<div class="form-group">
				<label for="">Diagnosis: </label>
				<textarea placeholder="Enter diagnosis description here..." name="diagnosis" id="diagnosis" cols="30" rows="5" class="form-control"></textarea>
			</div>	
		    <div class="form-group">
				<label for="">Treatment: </label>
				<textarea placeholder="Enter treatment description here..." name="treatment" id="treatment" cols="30" rows="5" class="form-control"></textarea>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<input type="hidden" name="id_patient" id="id_patient" value="">
			<input type="hidden" name="date" id="date" value="<?=$date;?>">
			<input class="btn btn-primary" type="submit" value="Save">
		  </div>
		</form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="modalAppointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel">Dashboard Menu</h4>
		  </div>
		  <div class="modal-body">
			<a href="<?=$base_path;?>addImmediateAppointment" class="btn btn-block btn-primary">Add Patient</a>
			<a href="<?=$base_path;?>addAppointment" class="btn btn-block btn-success">Add Appointment</a>
		  </div>
		</form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel">Edit or Remove Appointment</h4>
		  </div>
		  <div class="modal-body">
			Please select one option below
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<a id="btn_edit" href="" class="btn btn-primary">Edit</a>
			<a id="btn_remove" href="" class="btn btn-danger">Remove</a>
		  </div>
		</div>
	  </div>
	</div>
	
</div><!-- /.container -->
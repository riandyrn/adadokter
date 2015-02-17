<?php $base_path = base_url() . 'index.php/doctor/'; ?>

<div class="container">
	
	<div class="row header-container">
		<div class="col-md-12 hidden-sm hidden-xs">
			
			<a href="<?=$base_path;?>addAppointment" class="btn btn-primary btn-adadokter pull-right" style="margin-top: 15px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Appointment</a>

			<!--
				<a data-toggle="modal" data-target="#ModalTambahPatient" href="" class="btn btn-primary btn-adadokter pull-right" style="margin-top: 15px; margin-right: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Register Patient</a>
			-->
			
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
	
	<?php if($success) { ?>
		<p class="success"><b>Success: </b> <?=$success;?></p>
		<?php $this->session->unset_userdata('success'); ?>
	<?php } ?>
	
	<?php if($error) { ?>
		<p class="error"><b>Error: </b> <?=$error;?></p>
		<?php $this->session->unset_userdata('error'); ?>
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
										data-start_time="<?=$appointment->start_time;?>"
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
										<a 
											class="edit-btn" 
											data-name="<?=$appointment->patient_name;?>" 
											data-id_patient="<?=$appointment->id_patient;?>" 
											data-toggle="modal" 
											data-target="#myModal" href="#"
											data-patient_name="<?=$appointment->patient_name;?>"
											data-telephone_number="<?=$appointment->telephone_number;?>"
										>
											edit
										</a>
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
		<form id="form_treatment" action="<?=$base_path;?>addTreatmentWithRecall_P/1" method="POST">
		  <div class="modal-body">
			<div class="form-group">
				<label for="">Diagnosis: </label>
				<textarea placeholder="Enter diagnosis description here..." name="diagnosis" id="diagnosis" cols="30" rows="5" class="form-control"></textarea>
			</div>	
		    <div class="form-group">
				<label for="">Treatment: </label>
				<textarea placeholder="Enter treatment description here..." name="treatment" id="treatment" cols="30" rows="5" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<input type="checkbox" value="1" id="btn_recall_time"> Set Recall Time
			</div>
			<div class="row" id="recall_time">
				<div class="col-md-4">
					<?php

						function weeks_in_month($year, $month, $start_day_of_week)
						{
							// Total number of days in the given month.
							$num_of_days = date("t", mktime(0,0,0,$month,1,$year));

							// Count the number of times it hits $start_day_of_week.
							$num_of_weeks = 0;
							for($i=1; $i<=$num_of_days; $i++)
							{
							  $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
							  if($day_of_week==$start_day_of_week)
								$num_of_weeks++;
							}

							return $num_of_weeks;
						}
						
						function getWeeks($date, $rollover)
						{
							$cut = substr($date, 0, 8);
							$daylen = 86400;

							$timestamp = strtotime($date);
							$first = strtotime($cut . "00");
							$elapsed = ($timestamp - $first) / $daylen;

							$i = 1;
							$weeks = 1;

							for($i; $i<=$elapsed; $i++)
							{
								$dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
								$daytimestamp = strtotime($dayfind);

								$day = strtolower(date("l", $daytimestamp));

								if($day == strtolower($rollover))  $weeks ++;
							}

							return $weeks;
						}
						
						$now = strtotime('now');
						$year = intval(date('Y', $now));
						$month = intval(date('m', $now));
						
						$numWeeks = weeks_in_month($year, $month, 1);
						$currentWeek = getWeeks(date('Y-m-d', strtotime('now')), "sunday");
					
					?>
					<label for="">Week:</label>
					<select name="week" id="" class="form-control">
						<?php for($i=1; $i<=$numWeeks; $i++) { ?>
							<option 
								value="<?=$i;?>"
								<?php 
									if(($i) == $currentWeek - 1) echo 'selected';
								?>
							>
								<?=$i;?>
							</option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-4">
					<label for="">Month:</label>
					<select name="month" id="" class="form-control">
						<?php for($i=1; $i<=12; $i++) { ?>
							<option 
								value="<?=$i;?>"
								<?php
									$currentMonth = intval(date('m', strtotime('now')));
									if($currentMonth == $i) echo 'selected';
								?>
							>
								<?=date('F', mktime(0, 0, 0, $i, 10)); // nama bulan ?>
							</option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-4">
					<label for="">Year:</label>
					<select name="year" id="" class="form-control">
						<?php for($i=0; $i<=2; $i++) { 
							$currentYear = intval(date('Y', strtotime('now')));
							$label = $currentYear + $i;
						?>
							<option value="<?=$label;?>">
								<?=$label;?>
							</option>
						<?php } ?>
					</select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<input type="hidden" name="id_patient" id="id_patient" value="">
			<input type="hidden" name="date" id="date" value="<?=$date;?>">
			
			<!-- ini ditambahkan pada tambahan modul recall list -->
			<input type="hidden" name="patient_name" id="patient_name" value="<?=$date;?>">
			<input type="hidden" name="telephone_number" id="telephone_number" value="<?=$date;?>">
			
			<input id="btn_save" class="btn btn-primary" type="submit" value="Save & Add Appointment">
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
			<h3 class="modal-title" id="myModalLabel">Dashboard Menu</h3>
		  </div>
		  <div class="modal-body">
			<a href="<?=$base_path;?>addImmediateAppointment" class="btn btn-block btn-primary">
				<span class="glyphicon glyphicon-user"></span>
				Add Patient
			</a>
			
			<!--
			<a data-toggle="modal" data-target="#ModalTambahPatient" href="" class="btn btn-block btn-success">
				<span class="glyphicon glyphicon-book"></span>
				Register Patient
			</a>
			-->
			
			<a href="<?=$base_path;?>addAppointment" class="btn btn-block btn-info">
				<span class="glyphicon glyphicon-ok"></span>
				Add Appointment
			</a>
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
	
	<div id="ModalTambahPatient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel">Register Patient</h3>
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
						<input type="submit" class="btn btn-primary" value="Register">
					</div>
				</form>
			</div>
	  </div>
	</div>	
	
</div><!-- /.container -->
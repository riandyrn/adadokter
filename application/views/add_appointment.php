<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left h1-responsive">
				<?php if($type == 'add') { ?>
					New Appointment&nbsp;<br>
				<?php } else { ?>
					Edit Appointment&nbsp;<br>
				<?php } ?>
				<!--<a class="btn btn-primary btn-adadokter btn-xs" href="<?=$base_path;?>patientList"><span class="glyphicon glyphicon-user"></span>&nbsp;See Patient List</a>-->
				<!--
				<button class="btn btn-primary btn-adadokter btn-xs" data-toggle="modal" data-target="#ModalTambahPatient"><span class="glyphicon glyphicon-plus"></span>&nbsp;New Patient</button>
				-->
			</h1>
		</div>			
	</div>

	<div class="content-container">
		
		<div class="row">
			<div class="col-md-12">
				
					<div class="row">
						<div class="col-md-4">
							
							<?php if($success != null) { ?>
								<p class="success"><b>Success:<br></b> <?=$success;?></p>
								<?php $this->session->unset_userdata('success'); ?>
							<?php } ?>
							
							<?php if($error != null) { ?>
								<p class="error"><b>Error:<br></b> <?=$error;?></p>
								<?php $this->session->unset_userdata('error'); ?>
							<?php } ?>
							
							<?php if($patient_not_exist != null) { ?>
								<p class="error">
									<b>Error:<br></b>Patient <span style="font-weight: bolder;"><?php if($patient_name) { echo $patient_name; $this->session->unset_userdata('patient_name'); } ?></span> hasn't been registered
									<!--<button class="btn btn-primary btn-adadokter btn-xs" data-toggle="modal" data-target="#ModalTambahPatient">
										Register
									</button>
									?-->
								</p>
								<?php $this->session->unset_userdata('patient_not_exist'); ?>
							<?php } ?>
							
							<?php if($type == 'add') { ?>
							<form action="<?=$base_path;?>addAppointment_P" method="POST">
							<?php } else { ?>
							<form action="<?=$base_path;?>addAppointment_P/edit/<?=$id_appointment;?>/<?=$base_date;?>" method="POST">
							<?php } ?>
								<div class="form-group">
									<label for="">Patient Name:</label>
									<input 
										value="<?php if($patient_name) { echo $patient_name; $this->session->unset_userdata('patient_name'); } ?>" 
										name="patient_name" 
										id="patient_name" 
										placeholder="Type patient name here..." 
										type="text" 
										class="form-control" 
										data-provide="typeahead" 
										autocomplete="off"
										
										<?php if($type == 'edit') { ?>
											readonly
										<?php } ?>
									>
								</div>
								<div class="form-group">
									<label for="">Telephone Number:</label>
									<input value="<?=$telephone_number;?>" name="" id="telephone_number" placeholder="Telephone number" type="text" class="form-control" readonly>
								</div>								
								<div class="form-group">
									<label for="">Schedule Date:</label>
									<input value="<?=$schedule_date;?>" name="schedule_date" id="schedule_date" placeholder="Scheduled date" type="text" class="form-control" readonly>
								</div>
								<div class="row">
									<div class="form-group col-xs-6 col-sm-6 col-md-6 custom-padding-right">
										<label for="">Start Time:</label>
										<input value="<?=$start_time;?>" name="start_time" id="start_time" placeholder="Select time" type="text" class="form-control" readonly>
									</div>
									<div class="form-group col-xs-6 col-sm-6 col-md-6 custom-padding-left">
										<label for="">End Time:</label>
										<input value="<?=$end_time;?>" name="end_time" id="end_time" placeholder="Select time" type="text" class="form-control" readonly>
									</div>
									<input name="id_doctor" type="hidden" value="<?=$this->session->userdata('id_doctor');?>">
								</div>
								
								<div class="row">
									<div class="hidden-sm hidden-xs">
										<div class="col-md-6 custom-padding-right">
											<a href="" class="btn btn-info btn-block btn-lg btn-square">Reset</a>
										</div>
										<div class="col-md-6 custom-padding-left">
											<input id="btn_submit" type="submit" class="btn_submit btn btn-disabled btn-primary btn-block btn-lg btn-square" value="Save" disabled>
										</div>
									</div>
									<div class="hidden-md hidden-lg">
										<div class="col-xs-6 col-sm-6 custom-padding-right">
											<a href="" class="btn btn-sm btn-info btn-block btn-lg btn-square">Reset</a>
										</div>
										<div class="col-xs-6 col-sm-6 custom-padding-left">
											<input id="btn_submit" type="submit" class="btn_submit btn btn-sm btn-disabled btn-primary btn-block btn-lg btn-square" value="Save" disabled>
										</div>									
									</div>
								</div>
							</form>
						</div>
						
						<br>
						
						<div id="schedule_table" class="col-md-8">
							<h2 class="text-center title responsive">
								<a 
									<?php if($type == 'add') { ?>
										href="<?=$base_path;?>addAppointment/<?=$prevMonday?>">
									<?php } else { ?>
										href="<?=$base_path;?>editAppointment/<?=$id_appointment;?>/<?=$prevMonday?>">
									<?php } ?>
									&laquo;
								</a> 
								Doctor Schedule 
								<a 
									<?php if($type == 'add') { ?>
										href="<?=$base_path;?>addAppointment/<?=$nextMonday?>">
									<?php } else { ?>
										href="<?=$base_path;?>editAppointment/<?=$id_appointment;?>/<?=$nextMonday?>">
									<?php } ?>
									&raquo;
								</a>
								<!--<small>28 Jul-2 Aug</small>--> 
							</h2>
							<a 
								style="margin-top: -38px;"
								
								<?php if($type == 'add') { ?>
									href="<?=$base_path;?>addAppointment"
								<?php } else { ?>
									href="<?=$base_path;?>editAppointment/<?=$id_appointment;?>"
								<?php } ?>
								class="pull-left btn btn-primary btn-adadokter btn-sm hidden-sm hidden-xs"
							>
								Goto This Week
							</a>
							
							<a style="margin-top: -38px;" href="<?=$base_path;?>calendar" class="pull-right btn btn-primary btn-adadokter btn-sm hidden-sm hidden-xs">See Calendar</a>
							<table class="table table-bordered responsive-table table-schedule">
								<thead>
									<tr class="title">
										<?php foreach($columnTitles as $title) { ?>
											<th
												<?php
													$current_date = date('Y-m-d', strtotime($title));
													$now = date('Y-m-d', strtotime('now'));
													if(strtotime($now) > strtotime($current_date))
													{
														echo 'style="background-color: #ccc;"';
													}
												?>
											><?=$title;?></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php $available_time = null; ?>
									<?php for($i=0; $i<$freetime_day_max_count; $i++) { ?>
										<tr>
											<?php for($j=0; $j < 6; $j++) { ?>
												<td 
													<?php
														$current_date = date('Y-m-d', strtotime($columnTitles[$j]));
														$now = date('Y-m-d', strtotime('now'));
														if(strtotime($now) > strtotime($current_date))
														{
															echo 'style="background-color: #ccc;"';
														}
													?>
												>
													<?php if(count($freetime_week) > 0) { ?>
														<button
															<?php 
																$char = array(' ', '-');
																$id_name = str_replace($char, "_", $columnTitles[$j] . '_' . $i);
																$id_name = str_replace(',', '', $id_name);
															?>
															id="<?=$id_name;?>"
															class="schedule-time btn btn-link btn-schedule-time" 
															data-time="<?php
																			$temp_arr = $freetime_week[$j];
																			if(array_key_exists($i, $temp_arr)) { 
																				$available_time = $freetime_week[$j][$i]; 
																				echo $available_time; 
																			} else {
																				$available_time = null;
																			}			
																		?>" 
															data-date="<?=$columnTitles[$j];?>"
															
															<?php
																
																if(strtotime($now) > strtotime($current_date))
																{
																	echo 'disabled';
																}
															?>
															>
															<?php
																if($available_time != null)
																{
																	echo $available_time;
																}
																else
																{
																	echo '';
																}
															?>
														</button>
													<?php } ?>
												</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
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
				<form action="<?=base_url();?>index.php/doctor/addPatient/1" method="POST">
					<div class="modal-body">
							<p class="responsive-text">
								Patient name you entered hasn't been listed at your patient list. Please fill form below to register this patient. 
							</p>
							<div class="form-group">
								<label for="">Name:</label>
								<input value="<?php if($patient_name) { echo $patient_name; } ?>" type="text" name="name" class="form-control" placeholder="Enter patient name here...">
							</div>
							<div class="form-group">
								<label for="">Telephone Number:</label>
								<input type="text" name="telephone_number" class="form-control" placeholder="Enter patient telephone number here...">
							</div>
							<input type="hidden" name="id_doctor" value="<?=$this->session->userdata('id_doctor');?>">
							<input type="hidden" name="schedule_date" value="<?=$schedule_date;?>">
							<input type="hidden" name="start_time" value="<?=$start_time;?>">
							<input type="hidden" name="end_time" value="<?=$end_time;?>">
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default responsive-btn" data-dismiss="modal">Cancel</button>
						<input type="submit" class="btn btn-primary responsive-btn" value="Register & Add Schedule">
					</div>
				</form>
			</div>
	  </div>
	</div>

	
</div><!-- /.container -->

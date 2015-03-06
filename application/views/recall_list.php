<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left">
				Recall List&nbsp;
			</h1>
		</div>
		<div class="col-md-6">
			<button id="btn_add_patient" data-toggle="modal" data-target="#modal_tambah" class="btn btn-primary btn-adadokter pull-right" style="margin-top:23px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Recall</button>
		</div>
	</div>
	<p><small>Recall list being displayed has range 2 weeks (2 weeks ago - 2 weeks later) from <?=date('d-M-Y', strtotime('now'));?></small></p>
	<br>
	<div class="row content-container">
				
		<div class="col-md-12">
			<?php if($success != null) { ?>
				<p class="success"><b>Success:<br></b> <?=$success;?></p>
				<?php $this->session->unset_userdata('success'); ?>
			<?php } ?>
			<?php if($error != null) { ?>
				<p class="error"><b>Error:<br></b> <?=$error;?></p>
				<?php $this->session->unset_userdata('error'); ?>
			<?php } ?>		
						
			<table class="table table-adadokter table-hover responsive-table">
				<thead>
					<tr>
						<th>Name</th>
						<th>
							Telephone 
							<span class="hidden-sm hidden-xs">
							Number
							</span>
						</th>
						<th>
							<span class="hidden-sm hidden-xs">
							Recall 
							</span>
							Time
						</th>
						<th>
							<span class="hidden-sm hidden-xs">
							Recall
							</span>
							Status
						</th>
						<th class="hidden-xs hidden-sm">
							Add Appointment
						</th>				
					</tr>
				</thead>
				<tbody>
					
					<?php if(isset($list_recall)) { ?>
						<?php if(count($list_recall) > 0) { ?>
							
							<?php $i=1; ?>
							<?php foreach($list_recall as $recall) { ?>
								<tr>
									<td>
										<a 
											data-id="<?=$recall->id;?>"
											data-week="<?=$recall->week;?>"
											data-month="<?=$recall->month;?>"
											data-year="<?=$recall->year;?>"
											
											class="recall-entry" 
											href="#" 
											style="font-weight: bolder;"
											data-toggle="modal"
											data-target="#modalConfirm"
										>
											<?=$recall->name;?>
										</a>
									</td>
									<td><?=$recall->telephone_number;?></td>
									
									
									<td>
										<?php										
											$now = strtotime('now');
											$week = getWeeks(date('Y-m-d', strtotime('now')), "sunday")-1;
											$month = intval(date('m', $now));
											$year = intval(date('Y', $now));
											
											$baseline_current = getUnixTimeWeek(date('Y-m-d', strtotime('now')));

											$delta = $baseline_current - $recall->baseline;
											if($delta == DELTA_UNIXTIME_IN_ONE_DAY)
											{
												echo "<span style='color: green; font-weight: bold;'>this week</span>";
											}
											elseif($delta > DELTA_UNIXTIME_IN_ONE_DAY)
											{
												echo "<span style='color: red; font-weight: bold;'>has passed</span>";
											}
											else
											{
												displayRecallTime($recall->week, $recall->month, $recall->year);
											}
										?>
									</td>
									<td>
										<select data-id="<?=$recall->id;?>" name="" id="" class="recall-status">
										<option 
											value="0"
											<?php if($recall->status == 0) { echo 'selected'; }?>
										>
											unconfirmed
										</option>
										<option 
											value="1"
											<?php if($recall->status == 1) { echo 'selected'; }?>
										>
											confirmed
										</option>
										<option 
											value="2"
											<?php if($recall->status == 2) { echo 'selected'; }?>
											>
											canceled
										</option>
									</select>
									</td>
									<td class="hidden-xs hidden-sm">
										<form action="<?=$base_path;?>addAppointmentRecall" method="POST">
											<input type="hidden" name="id_recall" value="<?=$recall->id;?>">
											<input type="hidden" name="patient_name" value="<?=$recall->name;?>">
											<input type="hidden" name="telephone_number" value="<?=$recall->telephone_number;?>">
											<input type="submit" class="btn btn-info btn-sm" value="Add Appointment">
										</form>
									</td>
								</tr>
								
								<?php $i++; ?>
							<?php } ?> <!-- end foreach -->
						<?php } else { ?> <!--end inner if count-->
							<!--<h3 class="text-center">Recall list is empty</h3>-->
						<?php } ?>
					<?php } ?> <!-- end if -->
				</tbody>
			</table>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel">Select Action</h4>
		  </div>
		  <div class="modal-body">
			<a id="btn_edit" href="#" data-toggle="modal" data-target="#modalEdit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-pencil"></span> Edit Recall</a>
			<a id="btn_remove" href="" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-remove"></span> Remove Recall</a>
			<a id="" href="" class="btn btn-info btn-block hidden-md hidden-lg"><span class="glyphicon glyphicon-plus"></span> Appointment</a>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="myModalLabel">Create Recall <span id="name"></span></h3>
		  </div>
		<form id="form_treatment" action="<?=$base_path;?>addRecallNormal_P" method="POST">
		  <div class="modal-body">
			<div class="form-group">
				<label for="">Patient Name:</label>
				<input type="text" name="" id="patient_name" class="form-control" placeholder="Enter patient name here..." autocomplete="off">
				<input type="hidden" name="id_patient" id="id_patient" value="">
			</div>
			<div class="form-group">
				<label for="">Telephone Number:</label>
				<input id="telephone_number" class="form-control" type="text" placeholder="Telephone Number" readonly>
			</div>
			<div class="row" id="recall_time">
				<div class="col-md-4">
					<?php
												
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
			<input id="btn_save" class="btn btn-primary" type="submit" value="Add Recall">
		  </div>
		</form>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" id="myModalLabel">Edit Recall Time</h3>
		  </div>
		  <form action="<?=$base_path;?>updateRecallTime_P" method="POST">
			  <div class="modal-body">
				
				<div class="row" id="recall_time">
					<div class="col-md-4">
						<?php
							
							$now = strtotime('now');
							$year = intval(date('Y', $now));
							$month = intval(date('m', $now));
							
							$numWeeks = weeks_in_month($year, $month, 1);
						
						?>
						<label for="">Week:</label>
						<select name="week" id="week_edit" class="form-control">
							<?php for($i=1; $i<=$numWeeks; $i++) { ?>
								<option value="<?=$i;?>"><?=$i;?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="">Month:</label>
						<select name="month" id="month_edit" class="form-control">
							<?php for($i=1; $i<=12; $i++) { ?>
								<option value="<?=$i;?>">
									<?=date('F', mktime(0, 0, 0, $i, 10)); // nama bulan ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="">Year:</label>
						<select name="year" id="year_edit" class="form-control">
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input id="id_edit" type="hidden" name="id">
				<input type="submit" class="btn btn-primary" value="Save changes">
			  </div>
		  </form>
		</div>
	  </div>
	</div>	
	
</div><!-- /.container -->

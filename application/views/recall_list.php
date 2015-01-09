<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left">
				Recall List&nbsp;
			</h1>
		</div>
	</div>
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
						<!--<th>
							Appointment
						</th>-->				
					</tr>
				</thead>
				<tbody>
					
					<?php if(isset($list_recall)) { ?>
						<?php if(count($list_recall) > 0) { ?>
							<?php
							
								function displayRecallTime($week, $month, $year)
								{
									echo 'Week ' . $week . ', ' . date('F', mktime(0, 0, 0, $month, 10)) . ' ' . $year;
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
								
							?>
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
											$week = getWeeks(date('Y-m-d', strtotime('now')), "sunday");
											$month = intval(date('m', $now));
											$year = intval(date('Y', $now));
											
											if(($recall->month == $month) && ($recall->year == $year))
											{
												$delta = $recall->week - $week;
												if($delta == 0)
												{
													echo "<span style='color: red; font-weight: bold;'>this week</span>";
												}
												elseif($delta == 1)
												{
													echo 'next week';
												}
												elseif($delta == -1)
												{
													echo 'last week';
												}
												else
												{
													displayRecallTime($recall->week, $recall->month, $recall->year);
												}
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
									<!--
									<td><button id="btn_add_patient" data-toggle="modal" data-target="#ModalTambahPatient" class="btn btn-primary btn-adadokter btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>
									-->
								</tr>
								
								<?php $i++; ?>
							<?php } ?> <!-- end foreach -->
						<?php } else { ?> <!--end inner if count-->
							<h3 class="text-center">Recall list is empty</h3>
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
			<h4 class="modal-title" id="myModalLabel">Edit or Remove</h4>
		  </div>
		  <div class="modal-body">
			Please select one option below
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<a id="btn_edit" href="#" data-toggle="modal" data-target="#modalEdit" class="btn btn-primary">Edit</a>
			<a id="btn_remove" href="" class="btn btn-danger">Remove</a>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- Modal -->
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

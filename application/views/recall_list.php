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
					
					<?php if(isset($list_patient)) { ?>
						<?php if(count($list_patient) > 0) { ?>
							<?php $i=1; ?>
							<?php foreach($list_patient as $patient) { ?>
								<tr>
									<td><a href="<?=$base_path;?>after_treatment/<?=$patient->id;?>" style="font-weight: bolder;"><?=$patient->name;?></a></td>
									<td><?=$patient->telephone_number;?></td>
									
									
									<td>Week 1, January 2015</td>
									<td>
										<select name="" id="">
											<option value="0">unconfirmed</option>
											<option value="1">confirmed</option>
											<option value="2">canceled</option>
										</select>
									</td>
									<!--
									<td><button id="btn_add_patient" data-toggle="modal" data-target="#ModalTambahPatient" class="btn btn-primary btn-adadokter btn-sm"><span class="glyphicon glyphicon-plus"></span></button></td>
									-->
								</tr>
								
								<?php $i++; ?>
							<?php } ?> <!-- end foreach -->
						<?php } else { ?> <!--end inner if count-->
							<h3 class="text-center">You don't have patient yet</h3>
						<?php } ?>
					<?php } ?> <!-- end if -->
				</tbody>
			</table>
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
</div><!-- /.container -->

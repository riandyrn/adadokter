<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left">
				Patient List&nbsp;
				<button id="btn_add_patient" data-toggle="modal" data-target="#ModalTambahPatient" class="btn btn-sm btn-primary btn-adadokter pull-right hidden-md hidden-lg" style="margin-top: 5px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Register Patient</button>
				<!--<a href="<?=$base_path;?>addAppointment" class="btn btn-primary btn-adadokter btn-sm"><span class="glyphicon glyphicon-plus"></span>&nbsp;New Appointment</a>-->
			</h1>
		</div>
		
		<div id="search_container" class="col-md-6">
			<span class="pull-right">
				<form action="<?=base_url();?>index.php/doctor/searchPatient" method="POST" class="col-md-7 pull-right">
					<div class="input-group">
						<input style="min-width: 200px;" id="keyword" name="keyword" type="text" class="form-control" placeholder="Enter patient name here...">
						<span class="input-group-btn">
							<input type="submit" value="Find!" class="btn btn-info"/>
						</span>
					</div>
				</form>
				<button id="btn_add_patient" data-toggle="modal" data-target="#ModalTambahPatient" class="btn btn-primary btn-adadokter btn-sm pull-right hidden-sm hidden-xs"><span class="glyphicon glyphicon-plus"></span>&nbsp;Register Patient</button>
			</span>
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
			
			<?php if(isset($keyword)) { ?>
				<?php if(strlen($keyword) > 0) { ?>
					<h4 style="color: green; margin-left: 15px;">Keyword search: <?=$keyword;?></h4>
				<?php } else { ?>
					<h4 style="color: green; margin-left: 15px;">No keyword. Display all patient</h4>
				<?php } ?>
			<?php } ?>		
		
			<table class="table table-adadokter table-hover responsive-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>
							Telephone 
							<span class="hidden-sm hidden-xs">
							Number
							</span>
						</th>
						<th>
							Edit 
							<span class="hidden-sm hidden-xs">
							Patient
							</span>
						</th>
						<th>
							Delete 
							<span class="hidden-sm hidden-xs">
							Patient
							</span>
						</th>
					</tr>
				</thead>
				<tbody>
					
					<?php if(isset($list_patient)) { ?>
						<?php if(count($list_patient) > 0) { ?>
							<?php $i=1; ?>
							<?php foreach($list_patient as $patient) { ?>
								<tr>
									<td><?=$i;?></td>
									<td><a href="<?=$base_path;?>after_treatment/<?=$patient->id;?>" style="font-weight: bolder;"><?=$patient->name;?></a></td>
									<td><?=$patient->telephone_number;?></td>
									<!--<td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ModalEditPatient_<?=$patient->id;?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit&nbsp;</button></td>
									<td><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalKonfirmasiHapusPatient_<?=$patient->id;?>"><span class="glyphicon glyphicon-remove"></span>&nbsp;Remove</button></td>-->									
									
									<td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalEditPatient_<?=$patient->id;?>"><span class="glyphicon glyphicon-pencil"></span></button></td>
									<td><button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalKonfirmasiHapusPatient_<?=$patient->id;?>"><span class="glyphicon glyphicon-remove"></span></button></td>
								</tr>
								
								<div id="ModalEditPatient_<?=$patient->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h3 class="modal-title" id="myModalLabel">Edit Patient</h3>
											</div>
											<form action="<?=base_url();?>index.php/doctor/editPatient" method="POST">
												<div class="modal-body">
														<div class="form-group">
															<label for="">Name:</label>
															<input type="text" name="name" class="form-control" value="<?=$patient->name;?>">
														</div>
														<div class="form-group">
															<label for="">Telephone Number:</label>
															<input type="text" name="telephone_number" class="form-control" value="<?=$patient->telephone_number;?>">
														</div>
														<input type="hidden" name="id_patient" value="<?=$patient->id;?>">
												</div>
												
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<input type="submit" class="btn btn-primary" value="Save changes" />
												</div>
											</form>
										</div>
								  </div>
								</div>
								
								<div id="ModalKonfirmasiHapusPatient_<?=$patient->id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h3 class="modal-title" id="myModalLabel">Remove Patient</h3>
											</div>
											<div class="modal-body">
												Remove <?=$patient->name;?>?
											</div>
											<form action="<?=base_url();?>index.php/doctor/removePatient" method="POST">
												<input type="hidden" name="id_patient" value="<?=$patient->id;?>">
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<input type="submit" value="Remove" class="btn btn-danger">
												</div>
											</form>
										</div>
								  </div>
								</div>
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

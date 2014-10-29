<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left h1-responsive">
				Add Patient&nbsp;
			</h1>
		</div>			
	</div>
	
	<?php if($error) { ?>
		<!--<p class="error"><b>Error: </b> <?=$error;?></p>-->
		<?php $this->session->unset_userdata('error'); ?>
	<?php } ?>		

	<div class="content-container">
		
		<div class="row">
			<div class="col-md-12">								
				<form action="<?=$base_path;?>addImmediateAppointment_P" method="POST">
					<div class="form-group">
						<label for="">Patient Name:</label>
						<input 
							value="<?php if(isset($prev_data)) { echo $prev_data['patient_name']; } ?>" 
							name="patient_name" 
							id="patient_name" 
							placeholder="Type patient name here..." 
							type="text" 
							class="form-control" 
							data-provide="typeahead" 
							autocomplete="off"
						>
					</div>
					<div class="form-group">
						<label for="">Telephone Number:</label>
						<input value="" name="" id="telephone_number" placeholder="Telephone number" type="text" class="form-control" readonly>
					</div>								
					<div class="form-group">
						<label for="">Schedule Date:</label>
						<input value="<?= date('D, d-M-y', strtotime('now'))?>" name="date" id="schedule_date" placeholder="Scheduled date" type="text" class="form-control" readonly>
					</div>
					<div class="form-group">
						<label for="">Diagnosis:</label>
						<textarea placeholder="Enter diagnosis here..." name="diagnosis" id="" cols="30" rows="3" class="form-control"><?php if(isset($prev_data)) { echo $prev_data['diagnosis']; } ?></textarea>
					</div>					
					<div class="form-group">
						<label for="">Treatment:</label>
						<textarea placeholder="Enter treatment description here..." name="treatment" id="" cols="30" rows="3" class="form-control"><?php if(isset($prev_data)) { echo $prev_data['treatment']; } ?></textarea>
					</div>
					<input type="submit" class="btn btn-primary btn-block btn-lg" value="Add Patient">
				</form>
			</div>
		</div>
		<br>
	</div>
	
	<?php if(isset($prev_data)) { ?>
		<div id="ModalTambahPatient" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h3 class="modal-title" id="myModalLabel">Register Patient</h3>
					</div>
					<form action="<?=base_url();?>index.php/doctor/addImmediateAppointmentNewPatient_P" method="POST">
						<div class="modal-body">
								<p class="error">
									<small>
										Patient is not registered, please register the patient first
									</small>
								</p>
								<div class="form-group">
									<label for="">Name:</label>
									<input type="text" name="name" class="form-control" placeholder="Enter patient name here..." value="<?=$prev_data['patient_name'];?>" readonly>
								</div>
								<div class="form-group">
									<label for="">Telephone Number:</label>
									<input type="text" name="telephone_number" class="form-control" placeholder="Enter patient telephone number here...">
								</div>
								<input type="hidden" name="id_doctor" value="<?=$this->session->userdata('id_doctor');?>">
								
								<!-- data prev schedule-->					
								<input type="hidden" name="patient_name" value="<?=$prev_data['patient_name'];?>">
								<input type="hidden" name="date" value="<?=$prev_data['date'];?>">
								<input type="hidden" name="diagnosis" value="<?=$prev_data['diagnosis'];?>">
								<input type="hidden" name="treatment" value="<?=$prev_data['treatment'];?>">
								
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<input type="submit" class="btn btn-primary" value="Register & Add Schedule">
						</div>
					</form>
				</div>
		  </div>
	  <?php } ?>
	</div>	
	
</div><!-- /.container -->

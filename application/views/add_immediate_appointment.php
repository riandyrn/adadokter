<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<div class="container">
	
	<div class="row header-container">
		<div class="col-md-6">
			<h1 class="pull-left h1-responsive">
				Add Patient&nbsp;
			</h1>
		</div>			
	</div>

	<div class="content-container">
		
		<div class="row">
			<div class="col-md-12">								
				<form action="<?=$base_path;?>addImmediateAppointment_P" method="POST">
					<div class="form-group">
						<label for="">Patient Name:</label>
						<input 
							value="" 
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
						<textarea placeholder="Enter diagnosis here..." name="diagnosis" id="" cols="30" rows="3" class="form-control"></textarea>
					</div>					
					<div class="form-group">
						<label for="">Treatment:</label>
						<textarea placeholder="Enter treatment description here..." name="treatment" id="" cols="30" rows="3" class="form-control"></textarea>
					</div>
					<input type="submit" class="btn btn-primary btn-block btn-lg" value="Add Appointment">
				</form>
			</div>
		</div>
		<br>
	</div>
	
</div><!-- /.container -->

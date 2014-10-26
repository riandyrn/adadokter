<?php $base_path = base_url() . 'index.php/doctor/'; ?>
    <div class="container">
		<div class="row header-container text-center">
			<h1 class="h1-responsive">Treatment History: <small><?=$patient->name;?></small></h1>
			<?php if($patient->telephone_number) { ?>
				<h4>(<?=$patient->telephone_number;?>)</h4>
			<?php } ?>
		</div>
		
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<table class="table table-adadokter responsive-table">
					<thead>
						<tr>
							<th class="col-md-2">Date</th>
							<th class="col-md-5">Diagnosis</th>
							<th class="col-md-5">Treatment</th>
							<!--<th class="col-md-1">Remove</th>-->
						</tr>
					</thead>
					<tbody>
						<?php foreach($treatments as $treatment) { ?>
							<tr>
								<td>
									<a 
										class="confirm-trigger"
										
										data-id_treatment="<?=$treatment->id;?>"
										data-id_patient="<?=$treatment->id_patient;?>"
										data-date="<?=date('Y-m-d', strtotime($treatment->date));?>"
										data-treatment="<?=$treatment->treatment;?>"
										data-diagnosis="<?=$treatment->diagnosis?>"
										
										data-toggle="modal" 
										data-target="#modalConfirm" 
										href=""
									>
										<?=date('d-M-Y', strtotime($treatment->date));?>
									</a>
								</td>
								<td style="text-align: justify;">
									<?=$treatment->diagnosis;?>
								</td>
								<td style="text-align: justify;">
									<?=$treatment->treatment;?>
								</td>
								<!--<td><a href=""><span class="glyphicon glyphicon-pencil"></span></a></td>-->
								<!--<td><a href="" style="color: red;"><span class="glyphicon glyphicon-remove"></span></a></td>-->
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		
		<!-- Modal Container -->

		<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit or Remove Record</h4>
			  </div>
			  <div class="modal-body">
				Please select one option below
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button data-toggle="modal" data-target="#modalTreatment" type="button" class="btn btn-primary">Edit</button>
				<a id="btn_remove" href="" class="btn btn-danger">Remove</a>
			  </div>
			</div>
		  </div>
		</div>

		<div class="modal fade" id="modalTreatment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Treatment Record<span id="name"></span></h4>
			  </div>
			<form action="<?=$base_path;?>editTreatment_P" method="POST">
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
				
				<input type="hidden" name="id" id="id_treatment" value="">
				<input type="hidden" name="id_patient" id="id_patient" value="">
				<input type="hidden" name="date" id="date" value="">
				<input class="btn btn-primary" type="submit" value="Save">
				
			  </div>
			</form>
			</div>
		  </div>
		</div>	
		<!-- End of Modal Container -->
		
    </div><!-- /.container -->
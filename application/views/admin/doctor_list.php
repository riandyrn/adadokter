<?php $base_path = base_url() . 'index.php/admin/'; ?>
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h1 class="title"><span class="glyphicon glyphicon-user"></span>&nbsp;Doctor List <button data-toggle="modal" data-target="#ModalNewDoctor" class="btn btn-primary btn-adadokter btn-xs">New doctor</button></h1>
			
			<?php if($success != null) { ?>
				<p class="success"><b>Success:</b> <?=$success;?></p>
				<?php $this->session->unset_userdata('success'); ?>
			<?php } ?>
			<?php if($error != null) { ?>
				<p class="error"><b>Error:</b> <?=$error;?></p>
				<?php $this->session->unset_userdata('error'); ?>
			<?php } ?>
			
			<div class="modal fade" id="ModalNewDoctor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel">New Doctor</h3>
				  </div>
				  <form action="<?=$base_path;?>addDoctor" method="POST">
					  <div class="modal-body">
						
						<div class="form-group">
							<label for="">Username: </label>
							<input name="username" type="text" class="form-control" placeholder="ex. dr_henry">
						</div>
						<div class="form-group">
							<label for="">Password: </label>
							<input name="password" type="text" class="form-control" placeholder="doctor's password">
						</div>
						
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" value="Add Doctor" />
					  </div>
				  </form>
				</div>
			  </div>
			</div>
			
			<table class="table">
				<thead>
					<tr class="title">
						<th>Username</th>
						<th>Password</th>
						<th>Patient Count</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($list_doctor as $doctor) { ?>
						<tr>
							<td><?=$doctor->username;?></td>
							<td><?=$doctor->password;?></td>
							<td><?=$doctor->count_patient;?></td>
							<td><a href="" data-toggle="modal"  data-target="#ModalEdit_<?=$doctor->id;?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
							<td><a href="" data-toggle="modal"  data-target="#ModalDelete_<?=$doctor->id;?>" style="color: red;"><span class="glyphicon glyphicon-remove"></span></a></td>
						</tr>
						
						<div class="modal fade" id="ModalEdit_<?=$doctor->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h3 class="modal-title" id="myModalLabel">Edit Doctor</h3>
							  </div>
							  <form action="<?=$base_path;?>editDoctor/<?=$doctor->id;?>" method="POST">
								  <div class="modal-body">
									
									<div class="form-group">
										<label for="">Username: </label>
										<input name="username" type="text" class="form-control" value="<?=$doctor->username;?>" placeholder="ex. dr_henry">
									</div>
									<div class="form-group">
										<label for="">Password: </label>
										<input name="password" type="text" class="form-control" value="<?=$doctor->password;?>" placeholder="doctor's password">
									</div>
									
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<input type="submit" class="btn btn-primary" value="Save changes">
								  </div>
							  </form>
							</div>
						  </div>
						</div>
						
						<div class="modal fade" id="ModalDelete_<?=$doctor->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="modal-title" id="myModalLabel">Delete Doctor</h4>
							  </div>
							  <div class="modal-body">
								Delete <?=$doctor->username;?>?
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<a href="<?=$base_path;?>deleteDoctor/<?=$doctor->id;?>" class="btn btn-danger">Delete</a>
							  </div>
							</div>
						  </div>
						</div>
					<?php } ?>
					
				</tbody>
			</table>
		</div>
	</div>

</div><!-- /.container -->


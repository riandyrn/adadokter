<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>
<script>
	$( '.edit-btn' ).click(function(){
		$( '#id_patient' ).val($(this).data('id_patient'));
		$( '#name' ).html($(this).data('name'));
		$( '#treatment' ).val('');
	});
	
	$( '.appointment-status' ).change(function(){
		$.post(
			'<?=$base_path;?>changeAppointmentStatus_P', 
			{ id: $(this).data('id'), status: $(this).val() },
			function()
			{
				alert('succesfully change appointment status');
			}
		);
	});
	
	$( '.edit-appointment' ).click(function(){
		id_appointment = $(this).data('id_appointment');
		schedule_date = $(this).data('date');
		$( '#btn_edit' ).attr('href', '<?=$base_path?>editAppointment/' + id_appointment);
		$( '#btn_remove' ).attr('href', '<?=$base_path?>deleteAppointment/' + id_appointment + '/' + schedule_date);
	});
</script>
<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<style>
	.hide-btn {
		display: none;
	}
</style>

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
		start_time = $(this).data('start_time');
		
		if(start_time == 99) {
			$( '#btn_edit' ).addClass('hide-btn');			
		} else {
			$( '#btn_edit' ).removeClass('hide-btn');
		}
		
		$( '#btn_edit' ).attr('href', '<?=$base_path?>editAppointment/' + id_appointment);
		$( '#btn_remove' ).attr('href', '<?=$base_path?>deleteAppointment/' + id_appointment + '/' + schedule_date);
	});
	
	/*** Ini buat fungsi tambahan recall time ***/
	$( '#recall_time' ).hide();
	$( '#btn_save_addappointment' ).hide();
	$( '#btn_recall_time' ).click(function(){
		if($(this).is(':checked'))
		{
			$( '#recall_time' ).show();
			//$( '#btn_save_addappointment' ).show();
			$( '#btn_save' ).attr('onclick', 'changeActionToIncludeRecall(0)');
		}
		else
		{
			$( '#recall_time' ).hide();
			$( '#form_treatment' ).attr('action', '<?=$base_path;?>addTreatment_P'); // ini harus tetep ada biar pas di uncheck, valuenya balik lagi
			$( '#btn_save_addappointment' ).hide();
			$( '#btn_save' ).removeAttr('onclick');
		}
	});
	
	function changeActionToIncludeRecall(mode)
	{
		$( '#form_treatment' ).attr('action', '<?=$base_path;?>addTreatmentWithRecall_P/' + mode);
	}
	
</script>
<?php $base_path = base_url() . 'index.php/doctor/'; ?>

<script>
	
$( '.confirm-trigger' ).click(function(){
	id = $(this).data('id_treatment');
	id_patient = $(this).data('id_patient');
	date = $(this).data('date');
	treatment = $(this).data('treatment');
	diagnosis = $(this).data('diagnosis');
	
	// set link utk remove
	$( '#btn_remove' ).attr('href', '<?=$base_path;?>removeTreatment_P/' + id);
	
	// set properties edit
	$( '#id_treatment' ).val(id);
	$( '#id_patient' ).val(id_patient);
	$( '#date' ).val(date);
	$( '#treatment' ).val(treatment);
	$( '#diagnosis' ).val(diagnosis);
});
	
</script>
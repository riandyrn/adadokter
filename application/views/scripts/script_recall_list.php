<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $assets = base_url() . 'assets/' ?> 

<script>
	/*** Ini script untuk ngerubah status aja ***/
	$( '.recall-status' ).change(function(){
		$.post(
			'<?=$base_path;?>changeRecallStatus_P', 
			{ id: $(this).data('id'), status: $(this).val() },
			function()
			{
				alert('succesfully change recall status');
			}
		);
	});
	
	/*** Ini script untuk satuan data entry ***/
	$( '.recall-entry' ).click(function(){
		id = $(this).data('id');
		
		//untuk set value href hapus
		$( '#btn_remove' ).attr('href', '<?=$base_path;?>deleteRecallEntry_P/' + id);
		
		//untuk set value edit recall-entry
		week = $(this).data('week');
		month = $(this).data('month');
		year = $(this).data('year');
		
		$( '#id_edit' ).val(id);
		$( '#week_edit' ).val(week);
		$( '#month_edit' ).val(month);
		$( '#year_edit' ).val(year);
		
	});
	
	
</script>
<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $assets = base_url() . 'assets/' ?> 

<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<script>

	var names = [
		<?php foreach($patients as $patient) { ?>
			'<?=$patient->name;?>', 
		<?php } ?>
		];
		
	var patient_data =
		[
			<?php foreach($patients as $patient) { ?>
				{
					id: '<?=$patient->id;?>',
					name: '<?=$patient->name;?>',
					phone: '<?=$patient->telephone_number;?>'
				},
			<?php } ?>
		];
	
	function searchPhoneNumberAndId(name)
	{
		found = false;
		i = 0;
		ret = null;
		
		while(!found && (i < patient_data.length))
		{
			if(patient_data[i].name == name)
			{
				found = true;
			}
			else
			{
				i++;
			}
		}
		
		if(found)
		{
			ret = patient_data[i];
		}
		
		return ret;
	}
	
	$('#patient_name').typeahead({
		source: names,
		updater: function(name)
		{
			var tmp = searchPhoneNumberAndId(name);
			var id = tmp.id;
			var telephone_number = tmp.phone;
			
			console.log(telephone_number);
			$( '#telephone_number' ).val(telephone_number);
			$( '#id_patient' ).val(id);
			
			return name;
		}
	});
	
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
		patient_name = $(this).data('patient_name');
		telephone_number = $(this).data('telephone_number');
		
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

		$( '#id_recall' ).val(id);
		$( '#patient_name' ).val(patient_name);
		$( '#telephone_number' ).val(telephone_number);
		
	});
	
	/*var arr_patient =
	[
		<?php foreach($patients as $patient) { ?>
			['<?=$patient->id;?>','<?=$patient->telephone_number;?>'],
		<?php } ?>
	];
	
	function getTelephoneNumber(array_of_patient, patient_name)
	{
		/*
			Asumsi elemen pasti ditemukan
		*
		
		var i = 0;
		var found = false;
		
		while(!found)
		{
			if(array_of_patient[i][0] == patient_name)
			{
				found = true;
			}
			else
			{
				i++;
			}
		}
		
		return array_of_patient[i][1];
	}
	
	function fillTelephoneNumber()
	{
		var patient_name = $('#patient_name').val();
		$('#telephone_number').val(getTelephoneNumber(arr_patient, patient_name));
	}
	
	$( '#patient_name' ).change(function(){
		fillTelephoneNumber();
	});
	
	fillTelephoneNumber();*/
</script>
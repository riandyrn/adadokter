<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<?php if($error) { ?>
	<script>
		$('#ModalTambahPatient').modal('show');
	</script>
<?php } ?>

<script>
	var names = [
		<?php foreach($list_patient as $patient) { ?>
			'<?=$patient->name;?>', 
		<?php } ?>
		];
		
	var patient_data =
		[
			<?php foreach($list_patient as $patient) { ?>
				{
					name: '<?=$patient->name;?>',
					phone: '<?=$patient->telephone_number;?>'
				},
			<?php } ?>
		];
	
	function searchPhoneNumber(name)
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
			ret = patient_data[i].phone;
		}
		
		return ret;
	}
	
	$('#patient_name').typeahead({
		source: names,
		updater: function(name)
		{
			$( '#telephone_number' ).val(searchPhoneNumber(name));
			return name;
		}
	});	
</script>
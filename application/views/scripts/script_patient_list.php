<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<script>
	var names = [
	<?php foreach($list_patient as $patient) { ?>
		'<?=$patient->name;?>',
	<?php } ?>
	];
	
	$('#keyword').typeahead({
		source: names
	});
</script>
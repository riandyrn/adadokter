<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<?php if($patient_not_exist) { ?>
	<script>
		$('#ModalTambahPatient').modal('show');
	</script>
<?php } ?>

<script>
	function checkFormHasValid()
	{
		var patient_name = $( '#patient_name' ).val();
		var schedule_date = $( '#schedule_date' ).val();
		var start_time = $( '#start_time' ).val();
		var end_time = $( '#end_time' ).val();
		
		if
		(
			(patient_name != '') && 
			(schedule_date != '') && 
			(start_time != '') && 
			(end_time != '')
		)
		{
			$( '.btn_submit' ).prop('disabled', false);
		}
		else
		{
			$( '.btn_submit' ).prop('disabled', true);
		}
		
		//console.log(patient_name + ' ' + schedule_date + ' ' + start_time + ' ' + end_time); 
	}
</script>

<?php foreach($list_patient as $patient) { ?>
	<input type="hidden" id="<?=$patient->name;?>" value="<?=$patient->telephone_number;?>">
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
	
	var last_clicked_time;
	var second_last_clicked_time;
	var count_click = 0;
	var edit = false;
	var first_id;
	var second_id;
	var first_date;
	var is_edit = false;
		
	<?php if($type == 'edit') { ?>
		edit = true;
	<?php } ?>	
	
	$(document).ready(function(){
		/* 
			dicek, kalo misalkan start sm end 
			schedule-nya keisi, dipaint block-nya
		*/
		var start_time = $('#start_time').val();
		var end_time = $('#end_time').val();
		var date = $('#schedule_date').val();
		
		if(start_time && end_time)
		{
			is_edit = true;		
			var first__id = searchElementId(start_time, date);
			var second__id = searchElementId(end_time, date);
			
			paintBlocks(first__id, second__id);
			first_id = first__id;
			second_id = second__id;
		}
	});
	
	function searchElementId(val_time, date)
	{
		// pokoknya nyari element based
		// on data value
		return $('td').find("[data-time='" + val_time + "']").filter("[data-date='" + date + "']").attr('id');
	}
	
	//console.log($('td').find("[data-date='Sat, 11-Oct-14']").filter("[data-time='11:30']").attr('id'));
	
	$( '#patient_name' ).change(function() {
		checkFormHasValid();
	});
	
	$( '.schedule-time' ).click(function(){
		var selected_date = $(this).data('date');
		var selected_time = $(this).data('time');

		
		if((selected_date != $( '#schedule_date' ).val()) || (edit == true)) 
		{
			count_click = 0;
			//alert('hello world!' +  selected_date + selected_time);
			$( '#schedule_date' ).val(selected_date);
			$( '#start_time' ).val(selected_time);
			$( '#end_time' ).val('');
			
			if(first_id)
			{
				unpaintBlocks(first_id, first_id);
			}
			
			if(first_id && second_id)
			{
				unpaintBlocks(first_id, second_id);
				first_id = null;
				second_id = null;
			}
			
			first_id = $(this).attr('id');
			//console.log(first_id);
			
			$( '.schedule-time' ).prop('disabled', false);
			
			
			count_click++;
			last_clicked_time = this;
			
			<?php if($type == 'edit') { ?>
				edit = false;
			<?php } ?>
			
			first_date = $(this).data('date');
		}
		else
		{
			count_click++;
			$( '#end_time' ).val(selected_time);
			
			if(count_click > 2)
			{
				$(last_clicked_time).prop('disabled', false);
				//$(last_clicked_time).parent().css('background-color', 'white');
				$(last_clicked_time).parent().removeClass('paint-block');
			}
			
			last_clicked_time = this;
			second_id = $(this).attr('id');
			//console.log('second_id: ' + second_id);
		}

		console.log(first_id);
		console.log(second_id);
		
		/*
			blok ini untuk menanggulangi kalau si
			user klik di second-nya di waktu yang
			lebih kecil dr first_date
		*/
		
		if(checkFirstIdLessThanSecondId(first_id, second_id))
		{
			/*
				ini blok kalo normal
			*/
			$(this).prop('disabled', true);
			//$(this).parent().css('background-color', 'blue');
			$(this).parent().addClass('paint-block');
			
			if(first_id && second_id)
			{
				paintBlocks(first_id, second_id);
			}
		}
		else
		{
			/*
				ini blok kalau terjadi anomali
			*/
			paintBlocks(second_id, second_id);
			unpaintBlocks(first_id, first_id);
			$('#' + first_id).prop('disabled', false);
			
			$( '#start_time' ).val($( '#' + second_id ).data('time'));
			$( '#end_time' ).val('');
			
			first_id = second_id;
			second_id = null;
		}
		
		checkFormHasValid();
	});
	
	function checkFirstIdLessThanSecondId(start_id, end_id)
	{
		var ret = false;
		
		var start = String(start_id).substr(String(start_id).length-1, 1);
		var end = String(end_id).substr(String(end_id).length-1, 1);
		
		if(start < end)
		{
			ret = true;
		}
		
		return ret;
	}
	
	function unpaintBlocks(start_id, end_id)
	{
		/* 
			Fungsi ini bakalan ngewarnain block
			pake warna putih (nge-unpaint)
		*/
		
		template_id = String(start_id).substr(0, String(start_id).length-1);
		start = String(start_id).substr(String(start_id).length-1, 1);
		end = String(end_id).substr(String(end_id).length-1, 1);
		
		for(i = start; i <= end; i++)
		{
			//$('#' + template_id + i).parent().css('background-color', 'white');
			$('#' + template_id + i).parent().removeClass('paint-block');
			$('#' + template_id + i).prop('disabled', false);
		}
		
		/* 
			modul tambahan utk keperluan antisipasi user click
			time yg lbh rendah setelah click yg kedua
		*/
		/*for(i = 0; i <=start; i++)
		{
			$('#' + template_id + i).prop('disabled', false);
		}*/
	}
	
	function paintBlocks(start_id, end_id)
	{
		/* 
			Fungsi ini bakalan ngewarnain block
			pake warna biru
		*/
		
		template_id = String(start_id).substr(0, String(start_id).length-1);
		start = String(start_id).substr(String(start_id).length-1, 1);
		end = String(end_id).substr(String(end_id).length-1, 1);
		
		for(i = start; i <= end; i++)
		{
			//$('#' + template_id + i).parent().css('background-color', '#45C1C3');
			$('#' + template_id + i).parent().addClass('paint-block');
			
			if(!is_edit)
			{
				$('#' + template_id + i).prop('disabled', true);
			}

		}
		
		if(is_edit)
		{
			is_edit = false;
		}
		
		/* 
			modul tambahan utk keperluan antisipasi user click
			time yg lbh rendah setelah click yg kedua
		*/
		/*for(i = 0; i <=start; i++)
		{
			$('#' + template_id + i).prop('disabled', true);
		}*/	
	}
</script>
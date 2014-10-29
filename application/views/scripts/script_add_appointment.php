<?php $assets = base_url() . 'assets/' ?> 
<script src="<?=$assets;?>js/bootstrap3-typeahead.min.js"></script>

<?php if($patient_not_exist) { ?>
	<script>
		$('#ModalTambahPatient').modal('show');
	</script>
<?php } ?>

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
	
	$( '#patient_name' ).change(function() {
		checkFormHasValid();
	});
</script>

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
		
	}

	var sch_temp = null;
	
	$( '.schedule-time' ).click(function(){

		/*
			ada 3 kondisi yg bisa kudu di observe:
			- case normal
			- case pindah tanggal
			- case row lebih rendah
		*/
		
		if(!(sch_temp)) {
			
			/*
				normal case, kalo first time click
				(sch_temp == null)
			*/
			
			moveBlock(this);
			
		} else {
			
			/*
				ini second click (sch_temp != null) 
				cek dulu dia masih ada di tanggal 
				yang sama atau udah ganti tanggal
			*/
			
			tanggal_temp = $('#' + sch_temp).data('date');
			tanggal_current = $(this).data('date');
			
			if(tanggal_temp == tanggal_current) {
				
				row_temp = $('#' + sch_temp).data('row');
				row_current = $(this).data('row');
				
				if(row_temp < row_current) {
				
					/*
						ini kondisi kalo normal (user 
						milih di tanggal yang sama dan
						row current > temp)
					*/
					
					id_temp = $('#' + sch_temp).attr('id');
					id_current = $(this).attr('id');
					
					paintBlocks(id_temp, id_current);
					$('#end_time').val($(this).data('time')); //isi datanya ke form
					disableAllScheduleButton(true);
					
				} else {
					
					/*
						ini kondisi kalau ternyata user pilih
						row yang lebih kecil dari row yang kita
						pilih
					*/
					
					moveBlock(this);				
				}
				
			} else {
				
				/*
					ini kondisi kalau ternyata di klik kedua
					user ganti tanggal, artinya ganti start time,
					unpaintBlock yang sebelumnya, paintBlock yang
					baru.
				*/
				
				moveBlock(this);
			}
			
		}
		
		checkFormHasValid();
	});
	
	function moveBlock(obj)
	{
		unpaintBlock(sch_temp); // unpaint blok sebelumnya
		$('#start_time').val($(this).data('time')); // isi datanya ke form
		$('#schedule_date').val($(this).data('date')); //isi data tanggal ke form
		sch_temp = $(obj).attr('id'); // simpan id elemen ini ke sch_temp
		paintBlock(sch_temp); // paint blok itu
	}			
	
	
	function disableAllScheduleButton(x)
	{
		/*
			x: boolean
		*/
		
		$('.btn-schedule-time').prop('disabled', x);
	}
	
	function paintBlock(id)
	{
		paintBlocks(id, id);
	}
	
	function unpaintBlock(id)
	{
		unpaintBlocks(id, id);
	}
	
	function unpaintBlocks(start_id, end_id)
	{
		/* 
			Fungsi ini bakalan ngewarnain block
			pake warna putih (nge-unpaint)
		*/
		
		template_id = $('#' + start_id).data('template');
		start = $('#' + start_id).data('row');
		end = $('#' + end_id).data('row');
		
		for(i = start; i <= end; i++)
		{
			$('#' + template_id + i).parent().removeClass('paint-block');
		}
		
	}
	
	function paintBlocks(start_id, end_id)
	{
		/* 
			Fungsi ini bakalan ngewarnain block
			pake warna biru
		*/
		
		template_id = $('#' + start_id).data('template');
		start = $('#' + start_id).data('row');
		end = $('#' + end_id).data('row');
		
		console.log(template_id);
		
		for(i = start; i <= end; i++)
		{
			$('#' + template_id + i).parent().addClass('paint-block');
		}
	
	}
</script>
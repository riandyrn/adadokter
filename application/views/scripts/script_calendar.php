<?php $base_path = base_url() . 'index.php/doctor/'; ?>
<?php $js = base_url() . 'assets/js/'; ?>
<script src="<?=$js;?>bootbox.js"></script>

<script src='<?=$js;?>fullcalendar/lib/moment.min.js'></script>
<script src='<?=$js;?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src='<?=$js;?>fullcalendar/fullcalendar.min.js'></script>
<script src='<?=$js;?>fullcalendar/lang-all.js'></script>

<script>
	$(document).ready(function() {
		var currentLangCode = 'en';

		function renderCalendar() {
			$('#calendar').fullCalendar({
				
				<?php if($doctor_available_time) { ?>
					minTime: "<?=$doctor_available_time->start_hour;?>:00",
					maxTime: "<?=$doctor_available_time->finish_hour + 1;?>:00",
				<?php } ?>
				
				theme: true,
				hiddenDays: [ 0 ],
				header: {
					//left: 'prev,next today',
					left: '',
					center: 'prev  title  next',
					right: ''
					//right: 'month,agendaWeek,agendaDay'
				},
				allDaySlot: false,
				axisFormat: 'HH:mm',
				timeFormat: 'HH:mm',
				columnFormat: {
					week: 'ddd, D-MMM'
				},
				titleFormat: "[<?=$this->session->userdata('username');?>'s Calendar]",
				//defaultDate: '2014-06-12',
				defaultView: 'agendaWeek',
				lang: currentLangCode,
				buttonIcons: false, // show the prev/next text
				weekNumbers: false,
				editable: false,
				events: [
					<?php foreach($list_appointment as $appointment) { ?>
						{
							id: <?=$appointment->id;?>,
							title: '<?=$appointment->patient_name;?>',
							start: '<?=$appointment->schedule_date;?>T<?=$appointment->start_time;?>:00',
							end: '<?=$appointment->schedule_date;?>T<?=$appointment->end_time;?>:00',
							date: '<?=$appointment->schedule_date;?>'
						},
					<?php } ?>
				],
				eventClick: function(event) {
					bootbox.dialog({
						title: 'Edit Appointment',
						message: 'Edit or delete this appointment?',
						buttons: {
							cancel: {
								label: 'Cancel',
								className: 'btn-default'
							},
							edit: {
								label: 'Edit',
								className: 'btn-info',
								callback: function() {
									//alert(event.id);
									window.location.href = '<?=$base_path;?>editAppointment/' + event.id + '/';
								}
							},
							del: {
								label: 'Delete',
								className: 'btn-danger',
								callback: function() {
									//alert(event.id);
									window.location.href = '<?=$base_path;?>deleteAppointment/' + event.id;
								}
							}
						}
					});
				}
			});
		}

		renderCalendar();
	});

	$(document).ready(function() {
		var currentLangCode = 'en';

		function renderCalendar() {
			$('#small_calendar').fullCalendar({
				
				<?php if($doctor_available_time) { ?>
					minTime: "<?=$doctor_available_time->start_hour;?>:00",
					maxTime: "<?=$doctor_available_time->finish_hour + 1;?>:00",
				<?php } ?>
				
				theme: true,
				hiddenDays: [ 0 ],
				header: {
					//left: 'prev,next today',
					left: '',
					center: 'prev  title  next',
					right: ''
					//right: 'month,agendaWeek,agendaDay'
				},
				allDaySlot: false,
				axisFormat: 'HH:mm',
				timeFormat: 'HH:mm',
				columnFormat: {
					week: 'ddd, D-MMM'
				},
				titleFormat: "[<?=$this->session->userdata('username');?>'s Calendar]",
				//defaultDate: '2014-06-12',
				defaultView: 'agendaDay',
				lang: currentLangCode,
				buttonIcons: false, // show the prev/next text
				weekNumbers: false,
				editable: false,
				events: [
					<?php foreach($list_appointment as $appointment) { ?>
						{
							id: <?=$appointment->id;?>,
							title: '<?=$appointment->patient_name;?>',
							start: '<?=$appointment->schedule_date;?>T<?=$appointment->start_time;?>:00',
							end: '<?=$appointment->schedule_date;?>T<?=$appointment->end_time;?>:00',
							date: '<?=$appointment->schedule_date;?>'
						},
					<?php } ?>
				],
				eventClick: function(event) {
					bootbox.dialog({
						title: 'Edit Appointment',
						message: 'Edit or delete this appointment?',
						buttons: {
							cancel: {
								label: 'Cancel',
								className: 'btn-default'
							},
							edit: {
								label: 'Edit',
								className: 'btn-info',
								callback: function() {
									//alert(event.id);
									window.location.href = '<?=$base_path;?>editAppointment/' + event.id + '/';
								}
							},
							del: {
								label: 'Delete',
								className: 'btn-danger',
								callback: function() {
									//alert(event.id);
									window.location.href = '<?=$base_path;?>deleteAppointment/' + event.id;
								}
							}
						}
					});
				}
			});
		}

		renderCalendar();
	});
	
</script>
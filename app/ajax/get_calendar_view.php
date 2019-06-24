<?php
$company = $broker->get_session('company');


$company_events_all = new company_events();
$company_events_all->set_condition('checker','!=','');
$company_events_all->add_condition('recordStatus','=','O');
$company_events_all->add_condition('ts_location','=',$company->location->id);
$company_events_all->set_order_by('event_date','ASC');
$company_events_all->add_order_by('event_time_from','ASC');
$list = $broker->get_all_data_condition($company_events_all);


for($i=0;$i<sizeof($list);$i++){
	$list[$i]->current_time_from = $list[$i]->event_horus_from.':'.$list[$i]->event_minutes_from;
	$list[$i]->current_time_to = $list[$i]->event_hours_to.':'.$list[$i]->event_minutes_to;
	$list[$i]->current_time = $list[$i]->current_time_from.' - '.$list[$i]->current_time_to;
}
?>

<script type="text/javascript">

	function get_calendar(){
		$('#calendar').fullCalendar('destroy');
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var calendar = $('#calendar').fullCalendar({
		    header: { 
		    	left: 'title',
		    	center: 'agendaDay,agendaWeek,month',
		    	right: 'prev,next today'
		    },
		    locale : 'fr',
		    monthNames: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'],
  			monthNamesShort : ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec'],
  			dayNames : ['Nedelja', 'Ponedeljak', 'Utorak', 'Sreda', 'Četvrtak', 'Petak', 'Subota'],
  			dayNamesShort : ['Ned', 'Pon', 'Uto', 'Sre', 'Čet', 'Pet', 'Sub'],
		    events: [
				
				<?php for ($i=0; $i < sizeof($list); $i++) { ?> 
				{
					title: '<?php echo $list[$i]->event_name; ?>',
					start: new Date(
						<?php echo date('Y',strtotime($list[$i]->event_date)); ?>,
						<?php echo date('m',strtotime($list[$i]->event_date))-1; ?>,
						<?php echo date('d',strtotime($list[$i]->event_date)); ?>, 
						<?php echo $list[$i]->event_horus_from; ?>, 
						<?php echo $list[$i]->event_minutes_from; ?>
					),
					end: new Date(
						<?php echo date('Y',strtotime($list[$i]->event_date)); ?>,
						<?php echo date('m',strtotime($list[$i]->event_date))-1; ?>,
						<?php echo date('d',strtotime($list[$i]->event_date)); ?>,
						<?php echo $list[$i]->event_hours_to; ?>, 
						<?php echo $list[$i]->event_minutes_to; ?>
					),
					allDay:false
				},
				<?php } ?>
	        ],
	        firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
	        eventClick: function(calEvent, jsEvent, view) {
	        	get_calendar_day_list(calEvent.start._d,calEvent.end._d,false);
			    /*alert('Event: ' + calEvent.title);
			    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			    alert('View: ' + view.name);

			    // change the border color just for f*un
			    $(this).css('border-color', 'red');*/

			},
			selectable:true,
			select: function(start, end, allDay) {
				//console.log(allDay);
				get_calendar_day_list(start._d,end._d,false);
				//console.log(start);
				//console.log(end);
				//console.log(allDay);
			},
		});

	}

	get_calendar();

	
	//$('#calendar').fullCalendar('changeView', 'agendaDay');

	/* initialize the calendar
	-----------------------------------------------------------------*/
	/*
	var calendar =  $('#calendar').fullCalendar({
		header: {
			left: 'title',
			center: 'agendaDay,agendaWeek,month',
			right: 'prev,next today'
		},
		editable: false,
		firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
		selectable: true,
		defaultView: 'month',
		
		axisFormat: 'h:mm',
		columnFormat: {
            month: 'ddd',    // Mon
            week: 'ddd d', // Mon 7
            day: 'dddd M/d',  // Monday 9/7
            agendaDay: 'dddd d'
        },
		allDaySlot: false,
		selectHelper: true,
		select: function(start, end, allDay) {
			get_calendar_day_list(start,end,allDay);
			alert(123456);
			var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}
			calendar.fullCalendar('unselect');
		},
		droppable: false, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) { // this function is called when something is dropped
		
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
				// if so, remove the element from the "Draggable Events" list
				$(this).remove();
			}
			
		},
		
		events: [
			
			{
                    title: 'All Day Event',
                    start: new Date(y, m, 5)
                }
			<?php /*for ($i=0; $i < sizeof($list); $i++) { ?> 
			{
				title: '<?php echo $list[$i]->current_time; ?>',
				start: new Date(
					<?php echo date('Y',strtotime($list[$i]->event_date)); ?>,
					<?php echo date('m',strtotime($list[$i]->event_date))-1; ?>,
					<?php echo date('d',strtotime($list[$i]->event_date)); ?>
					, 
					10, 
					0),
				end: new Date(<?php echo date('Y',strtotime($list[$i]->event_date)); ?>,
					<?php echo date('m',strtotime($list[$i]->event_date))-1; ?>,
					<?php echo date('d',strtotime($list[$i]->event_date)); ?>
					, 22, 30),
				allDay:false
			},
			<?php } */?>
		],			
	});*/
		
</script>
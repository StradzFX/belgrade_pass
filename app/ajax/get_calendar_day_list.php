<?php


if(!$_SESSION['company']){
	header('Location:'.$base_url.'company_panel/');
	die();
}

$company = $broker->get_session('company');

$data = $_POST['data'];
$data['start'] = date('Y-m-d',strtotime($data['start']));

$company_events_all = new company_events();
$company_events_all->set_condition('checker','!=','');
$company_events_all->add_condition('recordStatus','=','O');
$company_events_all->add_condition('ts_location','=',$company->location->id);
$company_events_all->add_condition('event_date','=',$data['start']);
$company_events_all->set_order_by('event_time_from','ASC');
$list = $broker->get_all_data_condition($company_events_all);

for($i=0;$i<sizeof($list);$i++){
	$list[$i]->current_time_from = $list[$i]->event_horus_from.':'.$list[$i]->event_minutes_from;
	$list[$i]->current_time_to = $list[$i]->event_hours_to.':'.$list[$i]->event_minutes_to;
	$list[$i]->current_time = $list[$i]->current_time_from.' - '.$list[$i]->current_time_to;
}

?>
<input type="hidden" name="event_date" value="<?php echo $data['start']; ?>">
<div class="list_items list_item_all">
		<div class="hello">
		Lista događaja za dan: <?php echo date('d.m.Y.',strtotime($data['start'])); ?>
 	</div>

 	<div style="margin-bottom: 10px;">
		<a href="javascript:void(0)" class="btn btn-success" onclick="get_event_data(0)">Dodaj novi događaj</a>

		<a href="javascript:void(0)" onclick="go_back_to_calndar()" class="btn btn-success">Vrati se na kalendar</a>
	</div>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Vreme</th>
          <th scope="col">Naziv</th>
          <th scope="col">Tip</th>
          <th scope="col">Akcije</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i < sizeof($list); $i++) { ?>
            <tr>
              <th scope="row"><?php echo $i+1; ?></th>
              <td><?php echo $list[$i]->current_time; ?></td>
              <td><?php echo $list[$i]->event_name; ?></td>
              <td><?php echo $list[$i]->event_type; ?></td>
              <td>
              	<a href="javascript:void(0)" onclick="get_event_data(<?php echo $list[$i]->id; ?>)">
              		<i class="fas fa-pen-square"></i>
              	</a>

              	<a href="javascript:void(0)" onclick="delete_event(<?php echo $list[$i]->id; ?>)">
              		<i class="fas fa-times-circle"></i>
              	</a>

              	
              </td>
            </tr>
        <?php } ?>
        
      </tbody>
    </table>
</div>
<div class="list_items list_item_manage" style="display: none;">
	
</div>

<script type="text/javascript">
	function get_event_data(id){
		var call_url = "get_event_data";  

		var data = {};
			data.id = id;
			data.selected_date = $('[name="event_date"]').val();

	    var call_data = { 
	        data:data 
	    }  

	    var callback = function(response){
	      	$('.list_item_manage').html(response);

	      	$('.list_items').hide();
	      	$('.list_item_manage').show();

	    }  

	    ajax_call(call_url, call_data, callback); 
	}

	function delete_event(id){
		var res = confirm('Da li ste sigurni?');
		if(res){
			var call_url = "delete_event";  

			var data = {};
				data.id = id;

		    var call_data = { 
		        data:data 
		    }  

		    var callback = function(response){
		      	get_calendar_day_list_start($('[name="event_date"]').val());
		      	get_calendar();
		    }  

		    ajax_json_call(call_url, call_data, callback); 
		}
	}

	function go_back_to_list(){
		$('.list_items').hide();
	    $('.list_item_all').show();
	}
</script>
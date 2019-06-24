<?php

$data = $post_data['data'];

$days = array();
$days[1] = 'Monday';
$days[2] = 'Tuesday';
$days[3] = 'Wednesday';
$days[4] = 'Thursday';
$days[5] = 'Friday';
$days[6] = 'Saturday';
$days[7] = 'Sunday';

$item = SchoolModule::get_admin_data($data['school_id']);

$list_days = array();
for ($i=1; $i <= 7; $i++) { 
  
  $list_day = array(
    'day_number' => $i,
    'day_name' => $days[$i],
    'item' => SchoolProgrammDayModule::get_by_program_and_day($data['id'],$i)
  );
  $list_days[] = $list_day;
}

?>
<style type="text/css">
  
  .days_checkbox label{
    padding-right: 8px;
  }

  .none{
    display: none!important;
  }

  .clear{
    clear: both;
  }

  .period_holder table{
      width: 100%;
  }

  .period_holder table td{
      padding-bottom: 5px;
      padding-right: 5px;
  }

</style>
<input type="hidden" name="days_programm_id" value="<?php echo $data['id']; ?>" />
<div class="checkbox days_checkbox">
  <?php for ($i=0; $i < sizeof($list_days); $i++) { ?>
  <label>
    <input type="checkbox" name="days" <?php if($list_days[$i]['item']){ ?>checked="checkbox"<?php } ?> value="<?php echo $list_days[$i]['day_number']; ?>" onchange="change_days(this)"> <?php echo $list_days[$i]['day_name']; ?>
  </label>
  <?php } ?>
</div>


<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <?php for ($i=0; $i < sizeof($list_days); $i++) { ?>
    <li class="days_navigation day_<?php echo $list_days[$i]['day_number']; ?> <?php if(!$list_days[$i]['item']){ ?>none<?php } ?>"><a href="#day_<?php echo $list_days[$i]['day_number']; ?>" data-toggle="tab"><?php echo $list_days[$i]['day_name']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="tab-content">
    <?php for ($i=0; $i < sizeof($list_days); $i++) { ?>
      <div class="days_content tab-pane" id="day_<?php echo $list_days[$i]['day_number']; ?>">
        Coach:<br/>
        <select name="day_coach" class="form-control">
          <option value="0">No coach is responsible for whole day</option>
          <?php for ($j=0; $j < sizeof($item->coaches); $j++) { ?>
            <option value="<?php echo $item->coaches[$j]->id; ?>"><?php echo $item->coaches[$j]->full_name; ?></option>
          <?php } ?>
        </select>
        <br/>
        <div>
          <div>Periods:</div>
          <a class="btn btn-success pull-right" href="javascript:void(0)" onclick="add_period(<?php echo $list_days[$i]['day_number']; ?>)">Add period</a>
          <div class="clear"></div>
        </div>
        
        <div class="period_holder period_holder_<?php echo $list_days[$i]['day_number']; ?>">
          <?php if(sizeof($list_days[$i]['item']->periods) > 0){ ?>
          <table>
            <tr>
              <td>From</td>
              <td>To</td>
              <td>Price</td>
              <td>CCY</td>
              <td>Coach</td>
              <td>&nbsp;</td>
            </tr>

            <?php for ($j=0; $j < sizeof($list_days[$i]['item']->periods); $j++) { 
              $period = $list_days[$i]['item']->periods[$j];
              ?>
               <tr class="period_row period_row_ext_<?php echo $period->id; ?>">
                <td width="90">
                  <select class="form-control" name="from">
                  <?php for($si=0;$si<=23;$si++){ for($sj=0;$sj<60;$sj=$sj+10){ $di = $si < 10 ? '0'.$si : $si; $dj = $sj < 10 ? '0'.$sj : $sj;?>
                  <option <?php if($period->display_time_from == $di.':'.$dj){ ?>selected="selected"<?php } ?> value="<?php echo $di.':'.$dj; ?>"><?php echo $di.':'.$dj; ?></option>
                  <?php }} ?>
                  </select>
                </td>
                <td width="90">
                  <select class="form-control" name="to">
                  <?php for($si=0;$si<=23;$si++){ for($sj=0;$sj<60;$sj=$sj+10){ $di = $si < 10 ? '0'.$si : $si; $dj = $sj < 10 ? '0'.$sj : $sj;?>
                  <option <?php if($period->display_time_to == $di.':'.$dj){ ?>selected="selected"<?php } ?> value="<?php echo $di.':'.$dj; ?>"><?php echo $di.':'.$dj; ?></option>
                  <?php }} ?>
                  </select>
                </td>
                <td>
                  <input name="price" class="form-control" value="<?php echo $period->price; ?>" type="text"/>
                </td>
                <td>
                  <input name="ccy" class="form-control" value="<?php echo $period->ccy; ?>" type="text"/>
                </td>
                <td width="150">
                <select class="form-control" name="period_coach">\
                  <option value="0">Select coach</option>
                  <?php for ($cj=0; $cj < sizeof($item->coaches); $cj++) { ?>
                    <option <?php if($period->trainer == $item->coaches[$cj]->id){ ?>selected="selected"<?php } ?> value="<?php echo $item->coaches[$cj]->id; ?>"><?php echo $item->coaches[$cj]->full_name; ?></option>
                  <?php } ?>
                  </select>
                  </td>
                <td>
                  <a href="javascript:void(0)" onclick="remove_period('ext_<?php echo $period->id; ?>')"><i class="fa fa-times"></i></a>
                </td>
                </tr>
            <?php } ?>
            </table>
            
          <?php }else{ ?>
              No periods for this day
          <?php } ?>
        </div>
      </div>
      <!-- /.tab-pane -->
    <?php } ?>
  </div>
  <!-- /.tab-content -->
</div>

<script type="text/javascript">
  $(function(){
    $('.days_navigation:not(.none)').first().find('a').click();
  });

  function change_days(checkbox_item){
    var tab_id = checkbox_item.value;
    var tab_checked = checkbox_item.checked;

    if(tab_checked){
      $('.day_'+tab_id).removeClass('none');
      $('.days_navigation').removeClass('active');
      $('.day_'+tab_id).addClass('active');
      $('.days_content').removeClass('active');
      $('#day_'+tab_id).addClass('active');
    }else{
      $('.day_'+tab_id).addClass('none');
      $('.day_'+tab_id).removeClass('active');
      if($('#day_'+tab_id).hasClass('active')){
        $('#day_'+tab_id).removeClass('active');
          $('.days_navigation:not(.none)').first().find('a').click();
      }
    }
  }

  var unique_row = 999999;

  function add_period(id){

    unique_row += 1;

    var template_row = '<tr class="period_row period_row_'+unique_row+'">\
    <td width="90">\
      <select class="form-control" name="from">\
      <?php for($i=0;$i<=23;$i++){ for($j=0;$j<60;$j=$j+10){ $di = $i < 10 ? '0'.$i : $i; $dj = $j < 10 ? '0'.$j : $j;?>\
      <option><?php echo $di.':'.$dj; ?></option>\
      <?php }} ?>\
      </select>\
    </td>\
    <td width="90">\
      <select class="form-control" name="to">\
      <?php for($i=0;$i<=23;$i++){ for($j=0;$j<60;$j=$j+10){ $di = $i < 10 ? '0'.$i : $i; $dj = $j < 10 ? '0'.$j : $j;?>\
      <option><?php echo $di.':'.$dj; ?></option>\
      <?php }} ?>\
      </select>\
    </td>\
    <td>\
      <input name="price" class="form-control" type="text"/>\
    </td>\
    <td>\
      <input name="ccy" class="form-control" type="text"/>\
    </td>\
    <td width="150">\
    <select class="form-control" name="period_coach">\
      <option value="0">Select coach</option>\
      <?php for ($j=0; $j < sizeof($item->coaches); $j++) { ?>\
        <option value="<?php echo $item->coaches[$j]->id; ?>"><?php echo $item->coaches[$j]->full_name; ?></option>\
      <?php } ?>\
      </select>\
      </td>\
    <td>\
      <a href="javascript:void(0)" onclick="remove_period('+unique_row+')"><i class="fa fa-times"></i></a>\
    </td>\
    </tr>';

    if($('.period_holder_'+id).find('table').length == 0){

      var table_template = '<table>\
      <tr><td>From</td><td>To</td><td>Price</td><td>CCY</td><td>Coach</td><td>&nbsp;</td></tr>\
      {row}</table>';

      table_template = table_template.replace('{row}',template_row);
      $('.period_holder_'+id).html(table_template);
    }else{
      $('.period_holder_'+id).find('table').append(template_row);
    }




  }
</script>
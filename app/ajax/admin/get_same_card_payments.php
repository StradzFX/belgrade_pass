<?php

$data=$post_data=['data'];

?>

<table class="table table-hover">
    <tbody>
      <tr>
        <th>ID</th>
        <th>Kompanija</th>
        <th>Datum</th>
        <th>iznos</th>
        <th>Status</th>
        <th>Akcije</th>
        <th>Detaljno</th>
      </tr>
      <?php for($i=0;$i<10;$i++){ ?>
      <tr>
        <td>1</td>
        <td>Top Trade</td>
        <td>11.07.2014.</td>
        <td>750 din</td>
        <td><span class="label label-success">Approved</span></td>
        <td><a href="javascript:void(0)" class="label label-warning" name="recall" onclick="recall_transaction()">Recall</a></td></td>
        <td><a href="admin_payment_detailed" class="btn btn-primary btn-xs"><i class="fas fa-info-circle"></i></a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

<script type="text/javascript">
  function recall_transaction(){
    var data = {};
      data.id = $('[name="id"]').val();

    var call_url = 'recall_transaction'
    var call_data = {data:data}
    var call_back = function(response){
      if(response.success){
        alert(response.message);
      }
    }
    ajax_json_call(call_url, call_data, call_back)
  }
  

</script>


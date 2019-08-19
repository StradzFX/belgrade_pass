<?php
$data=$post_data['data'];
?>

<table class="table table-hover">
    <tbody>
      <tr>
        <th>ID</th>
        <th>Ime i prezime</th>
        <th>Datum</th>
        <th>Poziv na broj</th>
        <th>iznos</th>
        <th>Status</th>
        <th>Akcije</th>
        <th>Detaljno</th>
      </tr>
      <tr>
        <td>1</td>
        <td>Marko Markovic</td>
        <td>11.07.2014.</td>
        <td>25/2019</td>
        <td>750 din</td>
        <td><span class="label label-success">Approved</span></td>
        <td><span class="label label-warning" name="recall">Recall</span></td>
        <td><a href="post_office_payment_detailed" class="btn btn-primary btn-xs"><i class="fas fa-info-circle"></i></a></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Marko Markovic</td>
        <td>11.07.2014.</td>
        <td>17/2019</td>
        <td>1250 din</td>
        <td><span class="label label-success">Approved</span></td>
        <td>
          <a href="javascript:void(0)" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-approve">Approve</a>
          <a href="javascript:void(0)" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-delete-post-office-payment">Delete</a>
        </td>
        <td><a href="post_office_payment_detailed" class="btn btn-primary btn-xs"><i class="fas fa-info-circle"></i></a></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Marko Markovic</td>
        <td>11.07.2014.</td>
        <td>38/2019</td>
        <td>500 din</td>
        <td><span class="label label-success">Approved</span></td>
        <td><span class="label label-warning" name="recall">Recall</span></td>
        <td><a href="post_office_payment_detailed" class="btn btn-primary btn-xs"><i class="fas fa-info-circle"></i></a></td>
      </tr>
      <tr>
        <td>4</td>
        <td>Marko Markovic</td>
        <td>11.07.2014.</td>
        <td>52/2019</td>    
        <td>945 din</td>
        <td><span class="label label-success">Approved</span></td>
        <td><span class="label label-warning" name="recall">Recall</span></td>
        <td><a href="post_office_payment_detailed" class="btn btn-primary btn-xs"><i class="fas fa-info-circle"></i></a></td>
      </tr>
    </tbody>
  </table>




<?php
$data = $post_data['data'];
?>

<div class="row">
  <div class="col-12 col-xs-12">
    <table class="table table-hover">
      <tr>
          <th>ID</th>
          <th>Broj Kartice</th>
          <th>Ime i prezime</th>
          <th>Email</th>
          <th>Kredit</th>
          <th>Akcije</th>
        </tr>
      <?php for($i=0;$i<10;$i++){ ?>
        <tr>
          <td>1</td>
          <td>000022</td>
          <td>Pavle Jovanović</td>
          <td>pavle_car@gmail.com</td>
          <td>2255 din</td>
          <td>
            <a href="card_info" class="btn btn-primary btn-xs">Pogledaj Karticu</a>
            <!--<a href="" class="btn btn-primary btn-xs">Potrošnja</a>
            <a href="" class="btn btn-primary btn-xs">Uplate</a>
          -->
          </td>
        </tr>
      <?php } ?>
      
    </table>
  </div>
</div>
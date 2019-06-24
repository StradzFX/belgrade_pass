<div class="page_content payment-transaction">
  <div class="container">
    <div class="row">
      <div class="payment-information">

        <?php if($payment_data['transaction']['status_code'] == '00'){ ?>
        <div class="status success">Plaćanje je uspešno</div>
        <?php }else{ ?>
        <div class="status error">
            Plaćanje nije uspešno, vaš račun nije zadužen. Najčešći uzrok je pogrešno unet broj kartice, datum isteka ili sigurnosni kod. Pokušajte ponovo, a u slučaju uzastopnih grešaka pozovite vašu banku 
        </div>
        <?php } ?>

        

        <table cellpadding="0" cellspacing="0">
          <tr>
            <th colspan="2">Informacije o korisniku</th>
          </tr>
          <tr>
            <td><b>Ime</b></td>
            <td><?php echo $payment_data['user']['name']; ?></td>
          </tr>
          <tr>
            <td><b>Email</b></td>
            <td><?php echo $payment_data['user']['email']; ?></td>
          </tr>
          <tr>
            <th colspan="2">Informacije o porudžbini</th>
          </tr>
          <tr>
            <td><b>Naziv</b></td>
            <td><?php echo $payment_data['order']['name']; ?></td>
          </tr>
          <tr>
            <td><b>Količina</b></td>
            <td><?php echo $payment_data['order']['quantity']; ?></td>
          </tr>
          <tr>
            <td><b>Cena</b></td>
            <td><?php echo $payment_data['order']['price']; ?> RSD</td>
          </tr>
          <tr>
            <td><b>PDV</b></td>
            <td><?php echo $payment_data['order']['tax']; ?> RSD</td>
          </tr>
          <tr>
            <td><b>Ukupna cena</b></td>
            <td><?php echo $payment_data['order']['total_price']; ?> RSD</td>
          </tr>
          <tr>
            <td><b>ID transakcije</b></td>
            <td><?php echo $payment_data['order']['id']; ?></td>
          </tr>
          <tr>
            <th colspan="2">Informacije o prodavcu</th>
          </tr>
          <tr>
            <td><b>Naziv</b></td>
            <td>KIDCARD doo</td>
          </tr>
          <tr>
            <td><b>Adresa</b></td>
            <td>Veljka Dugoševića 54</td>
          </tr>
          <tr>
            <td><b>PIB</b></td>
            <td>111202038</td>
          </tr>
          <tr>
            <td colspan="2" class="notice">*KIDCARD doo nije obveznik PDV-a</td>
          </tr>
          <tr>
            <th colspan="2">Informacije o transackiji</th>
          </tr>
          <tr>
            <td><b>ID</b></td>
            <td><?php echo $payment_data['transaction']['id']; ?></td>
          </tr>
          <?php if(isset($payment_data['transaction']['authorisation_code'])){ ?>
          <tr>
            <td><b>Autorizacioni kod</b></td>
            <td><?php echo $payment_data['transaction']['authorisation_code']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><b>Status</b></td>
            <td><?php echo $payment_data['transaction']['status']; ?></td>
          </tr>
          <tr>
            <td><b>Statusni Kod</b></td>
            <td><?php echo $payment_data['transaction']['status_code']; ?></td>
          </tr>
          <tr>
            <td><b>Datum kupovine</b></td>
            <td><?php echo $payment_data['transaction']['purchase_date']; ?></td>
          </tr>
          <tr>
            <td><b>Cena</b></td>
            <td><?php echo $payment_data['transaction']['price']; ?> RSD</td>
          </tr>
          <tr>
            <td><b>Referentni ID</b></td>
            <td><?php echo $payment_data['transaction']['reffer_id']; ?></td>
          </tr>
        </table>
      </div>
      <!-- /.information -->
    </div>
    
  </div>
</div>
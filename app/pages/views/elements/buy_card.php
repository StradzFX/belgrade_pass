<div class="paying_option_box payment_option_pay_card">
    <?php for ($i=0; $i < sizeof($card_package_all); $i++) { ?> 
    <div  class="specification specification_<?php echo $card_package_all[$i]->id; ?>">
      <table>
        <tbody>
            <tr>
              <td>Cena za plaćanje</td>
              <td><?php echo $card_package_all[$i]->price; ?>,00 RSD</td>
            </tr>
            <tr >
              <td>PDV</td>
              <td>0,00 RSD</td>
            </tr>
            <tr >
              <td class="total">Ukupna cena za plaćanje</td>
              <td class="total"><?php echo $card_package_all[$i]->price; ?>,00 RSD</td>
            </tr>
            <tr >
              <td class="notice" colspan="2"> *KIDPASS doo nije obveznik PDV-a</td>
            </tr>
       </tbody>
      </table>
    </div>
    <?php } ?>
    <div class="payment_option_header">
        <div class="title">Pravila kupovine kredita i plaćanje usluga na sajtu</div>
    </div>
    <div class="rules_box">
        <?php include_once 'php/terms_text.php'; ?>
    </div>
    <div class="agree_holder">
        <input type="checkbox" id="aggree_terms" name="aggree_terms" /><label for="aggree_terms">Prihvatam pravila i uslove korišćenja</label> 
    </div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <button onclick="validacija_kartice();" class="btn btn-success">Platite platnom karticom</button>
        </div>

        
    </div>

    <p id="greska_uplatnica" class="warning_msg" style="display:none">Morate popuniti sva polja.</p>
</div><!--paying_option_box-->

<script type="text/javascript">
function validacija_uplatnice(){

    var po_name = $("input[name='uplatnica_ime']").val();
    var po_city = $("input[name='uplatnica_grad']").val();
    var po_address = $("input[name='uplatnica_adresa']").val();
    var po_postal = $("input[name='uplatnica_zip']").val();
    if(po_name == "" || po_city == ""  || po_address == "" || po_postal == "" ){
        var valid_selector = 'error';
        show_user_message(valid_selector,"Popunite sva polja za uplatnicu.");
    }else{
        ajax_kupi_uplatnica(po_name,po_city,po_address,po_postal);
    }
}


function validacija_kartice(){
    if($('[name="aggree_terms"]').is(':checked')){
        var card_data = {};
            card_data.package = $('[name="selected_package"]').val();
            card_data.user_card = $('[name="selected_user_card"]').val();

        var call_url = "create_card_payment";  

        var call_data = { 
            card_data:card_data 
        }  

        var callback = function(response){  
          if(response.success){
            document.location = response.payment_url;
          }else{
            var valid_selector = 'error';
            show_user_message(valid_selector,response.message);
          }

        }  
        ajax_json_call(call_url, call_data, callback); 
    }else{
        var valid_selector = 'error';
        show_user_message(valid_selector,"Morate se složiti sa privilima i uslovima korišćenja.");
    }
}

function ajax_kupi_uplatnica(po_name,po_city,po_address,po_postal){
    var post_office_data = {};
        post_office_data.package = $('[name="selected_package"]').val();
        post_office_data.user_card = $('[name="selected_user_card"]').val();
        post_office_data.po_name = po_name;
        post_office_data.po_city = po_city;
        post_office_data.po_address = po_address;
        post_office_data.po_postal = po_postal;

    var call_url = "create_post_office_payment";  

    var call_data = { 
        post_office_data:post_office_data 
    }  

    var callback = function(response){  
      if(response.success){
        document.location = master_data.base_url+'uplatnica/'+response.id;
      }else{
        var valid_selector = 'error';
        show_user_message(valid_selector,response.message);
      }

    }  
    ajax_json_call(call_url, call_data, callback);  
}
</script>
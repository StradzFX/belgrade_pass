<div class="paying_option_box payment_option_post_office" style="display: none;">

    <div class="payment_option_header">
        <div class="title">Podaci o uplatiocu na uplatnici (e-banking nalogu)</div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="option_title">
                Ime i prezime
            </div>
            <div>
                <input name="uplatnica_ime" class="form-control" type="text" value="<?php echo stripslashes($ulogovan_korisnik->ime); ?>" />
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="option_title">
                Grad
            </div>
            <div>
                <input name="uplatnica_grad" class="form-control" type="text" value="<?php echo stripslashes($ulogovan_korisnik->grad); ?>" />
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="option_title">
                Ulica i kućni broj
            </div>
            <div>
                <input name="uplatnica_adresa" class="form-control" type="text" value="<?php echo stripslashes($ulogovan_korisnik->adresa); ?>" />
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="option_title">
                Poštanski broj
            </div>
            <div>
                <input name="uplatnica_zip" class="form-control" type="text" value="<?php echo stripslashes($ulogovan_korisnik->zip_code); ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12">
            <button onclick="validacija_uplatnice();" class="btn btn-success">Kreiraj uplatnicu</button>
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
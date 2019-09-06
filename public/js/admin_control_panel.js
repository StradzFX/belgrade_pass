function admin_company_login(){ 

    var data = {};
        data.admin_company_login_id = $('[name="admin_company_login_id"]').val();

    start_global_call_loader(); 
    var call_url = "admin_company_login";  
    var call_data = { 
        data:data 
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){  
            window.location = master_data.base_url+'company_panel/';
        }else{  
            valid_selector = "error";  
        }  
        show_user_message(valid_selector,odgovor.message)  
    }  
    ajax_json_call(call_url, call_data, callback);      
} 


function admin_company_logout(){ 

    start_global_call_loader(); 
    var call_url = "admin_company_logout";  
    var call_data = { 
        data:'data' 
    }  
    var callback = function(odgovor){  
        finish_global_call_loader(); 
        if(odgovor.success){  
            window.location = master_data.base_url;
        }else{  
            valid_selector = "error";  
        }  
        show_user_message(valid_selector,odgovor.message)  
    }  
    ajax_json_call(call_url, call_data, callback);      
} 

function get_test_card_data(){
    var test_card = $('[name="test_card"]').val();
    test_card = test_card.split(',');
    var html = '\
    <b>ID</b>: '+test_card[0]+'<br/>\
    <b>PASSWORD</b>: '+test_card[1]+'<br/>\
    <b>CREDITS</b>: '+test_card[2]+'<br/>\
    ';
    $('.test_card_data').html(html);
    $('.admin_payment_btn').attr('href','admin/admin_payments_create/?preselected_card='+test_card[3]);


    $('[name="purchase_value"]').val(100);
    $('[name="purchase_card_number"]').val(test_card[3]);
    $('[name="purchase_card_password"]').val(test_card[1]);
}


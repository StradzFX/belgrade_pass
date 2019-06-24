<?php
function woocommerce_gift_coupon_generate_body_mail( $data ) {
    
    $woocommerce_gift_coupon_show_logo = get_option( 'woocommerce_gift_coupon_show_logo' );
    $woocommerce_gift_coupon_logo = get_option( 'woocommerce_gift_coupon_logo' );
    $woocommerce_gift_coupon_send = get_option( 'woocommerce_gift_coupon_send' );
    $woocommerce_gift_coupon_info_paragraph = get_option( 'woocommerce_gift_coupon_info_paragraph' );
    $woocommerce_gift_coupon_info_footer = get_option( 'woocommerce_gift_coupon_info_footer' );
    $woocommerce_gift_coupon_title_h = get_option( 'woocommerce_gift_coupon_title_h' );
    $woocommerce_gift_coupon_subject = get_option( 'woocommerce_gift_coupon_subject' );
    $woocommerce_gift_coupon_bg_color_header = get_option( 'woocommerce_gift_coupon_bg_color_header' );
    $woocommerce_gift_coupon_bg_color_footer = get_option( 'woocommerce_gift_coupon_bg_color_footer' );       
    $woocommerce_gift_coupon_bg_color_title = get_option( 'woocommerce_gift_coupon_bg_color_title' );
    
    $email ='
        <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>' . $woocommerce_gift_coupon_subject . '</title>
            <style type="text/css">
                html { background-color:#F5F5F5; margin:0; padding:0; }
                body{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, sans-serif;}
                table{border-collapse:collapse;}
                table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
                img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
                a{text-decoration:none !important;border-bottom:1px solid #ff5a34;}
                a:hover{text-decoration:none !important;border-bottom:1px solid #1A242E;}
                h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica, Arial, sans-serif; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}
            </style>
            </head>
            <body bgcolor="#F5F5F5" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
                <center style="background-color:#F5F5F5;">
                    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; margin:40px 0;" bgcolor="#F5F5F5">
                        <tr>
                            <td align="center" valign="top">
                                <table bgcolor="#F5F5F5" border="0" cellpadding="0" cellspacing="0" width="650" style="border:1px solid #dce2e3;">
                                    <tr>
                                        <td align="center" valign="top">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fff">
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="650">
                                                            <tr>
                                                                <td align="center" valign="top" width="650">
                                                                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top" bgcolor="'.$woocommerce_gift_coupon_bg_color_header.'" class="textContent">';
                                                                                if ($woocommerce_gift_coupon_show_logo > 0){
                                                                                    $email .= '<img src="'.$woocommerce_gift_coupon_logo.'" width="191" />';
                                                                                }
                                                                            $email .= '
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top" class="textContent" bgcolor="'.$woocommerce_gift_coupon_bg_color_title.'">
                                                                                <h1 style="text-transform:uppercase; color:#fff; text-align:center; font-size: 56px; font-family:Helvetica, Arial, sans-serif; font-weight:bold;display: block;margin: 0;">'.$woocommerce_gift_coupon_title_h.'</h1>
                                                                                <h2 style="text-transform:uppercase; color:#fff; text-align:center; font-size: 86px; font-family:Helvetica, Arial, sans-serif; font-weight:bold;display: block;margin: 0;"><strong>'.$data['price'].' '.$data['symbol'].'</strong></h2>
                                                                            </td>
                                                                        </tr>           
                                                                        <tr>
                                                                            <td align="center" valign="top" class="textContent">
                                                                                <h3 style="color:#252525;line-height:100%;font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:normal;text-align:center; border-bottom:1px solid #dce2e3;padding-bottom: 15px;padding-top: 15px;"><strong>' . esc_html__( 'Code', 'woocommerce-gift-coupon' ) . ': </strong> '.$data['code'].'</h3>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" valign="middle" style="padding-top:0;padding-bottom:15px;padding-right:15px;padding-left:15px;">
                                                                                '.$woocommerce_gift_coupon_info_paragraph.'
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <table bgcolor="'.$woocommerce_gift_coupon_bg_color_footer.'" border="0" cellpadding="0" cellspacing="0" width="650">                        
                                    <tr>
                                        <td align="center" valign="top">      
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="650">
                                                            <tr>
                                                                <td align="center" valign="top" width="650">
                                                                    <table border="0" cellpadding="00" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top" class="textContent">
                                                                                '.$woocommerce_gift_coupon_info_footer.'
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>   
                                                </tr>                             
                                            </table>
                                        </td>
                                    </tr>
                                </table>                                           
                                </table>
                            </td>
                        </tr>
                    </table>
                </center>
            </body>
        </html>';

    return $email;

}

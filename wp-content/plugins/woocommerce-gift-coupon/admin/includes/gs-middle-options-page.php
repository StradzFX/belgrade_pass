<?php 
if( ! empty( $_POST['Submit'] ) && $_POST['Submit'] == 'Save options' ) :

    $woocommerce_gift_coupon_send = isset( $_POST['woocommerce_gift_coupon_send'] ) ? $_POST['woocommerce_gift_coupon_send'] : null;
    $woocommerce_gift_coupon_show_logo = isset( $_POST['woocommerce_gift_coupon_show_logo'] ) ? $_POST['woocommerce_gift_coupon_show_logo'] : null;
    $woocommerce_gift_coupon_logo = isset( $_FILES['woocommerce_gift_coupon_logo'] ) ? $_FILES['woocommerce_gift_coupon_logo'] : null;
    $woocommerce_gift_coupon_info_paragraph = isset( $_POST['woocommerce_gift_coupon_info_paragraph'] ) ?  stripslashes( wp_filter_post_kses( addslashes( $_POST['woocommerce_gift_coupon_info_paragraph'] ) ) ) : null ;
    $woocommerce_gift_coupon_info_footer =  isset( $_POST['woocommerce_gift_coupon_info_footer'] ) ?  stripslashes( wp_filter_post_kses( addslashes( $_POST['woocommerce_gift_coupon_info_footer'] ) ) ) : null ;
    $woocommerce_gift_coupon_title_h = isset( $_POST['woocommerce_gift_coupon_title_h'] ) ?  stripslashes( wp_filter_post_kses( addslashes( $_POST['woocommerce_gift_coupon_title_h'] ) ) ) : null ;
    $woocommerce_gift_coupon_subject = sanitize_text_field ( isset( $_POST['woocommerce_gift_coupon_subject'] ) ? esc_html( trim( $_POST['woocommerce_gift_coupon_subject'] ) ) : null );
    $woocommerce_gift_coupon_bg_color_header = sanitize_text_field ( isset( $_POST['woocommerce_gift_coupon_bg_color_header'] ) ? esc_html( trim( $_POST['woocommerce_gift_coupon_bg_color_header'] ) ) : null );
    $woocommerce_gift_coupon_bg_color_footer = sanitize_text_field ( isset( $_POST['woocommerce_gift_coupon_bg_color_footer'] ) ? esc_html( trim( $_POST['woocommerce_gift_coupon_bg_color_footer'] ) ) : null );
    $woocommerce_gift_coupon_bg_color_title = sanitize_text_field ( isset( $_POST['woocommerce_gift_coupon_bg_color_title'] ) ? esc_html( trim( $_POST['woocommerce_gift_coupon_bg_color_title'] ) ) : null );

    if ( $woocommerce_gift_coupon_logo["error"] < 1 ) :	
	$file = wp_upload_bits( $_FILES['woocommerce_gift_coupon_logo']['name'], null, @file_get_contents( $_FILES['woocommerce_gift_coupon_logo']['tmp_name'] ) );
        update_option( 'woocommerce_gift_coupon_logo', $file['url'] );
    endif;
    
    update_option( 'woocommerce_gift_coupon_show_logo', $woocommerce_gift_coupon_show_logo );
    update_option( 'woocommerce_gift_coupon_send', $woocommerce_gift_coupon_send );
    update_option( 'woocommerce_gift_coupon_info_paragraph', $woocommerce_gift_coupon_info_paragraph );
    update_option( 'woocommerce_gift_coupon_info_footer', $woocommerce_gift_coupon_info_footer );
    update_option( 'woocommerce_gift_coupon_title_h', $woocommerce_gift_coupon_title_h );
    update_option( 'woocommerce_gift_coupon_subject', $woocommerce_gift_coupon_subject );
    update_option( 'woocommerce_gift_coupon_bg_color_header', $woocommerce_gift_coupon_bg_color_header );
    update_option( 'woocommerce_gift_coupon_bg_color_footer', $woocommerce_gift_coupon_bg_color_footer );
    update_option( 'woocommerce_gift_coupon_bg_color_title', $woocommerce_gift_coupon_bg_color_title );

    print '<div class="updated">';
         _e( 'Options saved.' );
    print '</div>';

endif;

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

if ( $woocommerce_gift_coupon_send > 0 ) :
        
    $checked_send = "checked";
        
else :
        
    $checked_send = false;
        
endif;

if ( $woocommerce_gift_coupon_show_logo > 0 ) :
        
    $checked_show_logo = "checked";
        
else :
        
    $checked_show_logo = false;
        
endif;

$settings_tinymce = array(
    '_content_editor_dfw' => 1,
	'drag_drop_upload' => true,
	'tabfocus_elements' => 'content-html,save-post',
	'editor_height' => 150,
	'tinymce' => array(
		'resize' => false,
		'wp_autoresize_on' => 1,
		'add_unload_trigger' => false,
	),
    "media_buttons" => false,
);
?>

<div class="container">
    <form name="woocommerce_gift_coupon_form" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>">
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Basic email configuration:</h4>', 'woocommerce-gift-coupon' ); ?>
            </div>
            <div class="wgc-box-body">
                <table>
                    <tr>
                        <td><?php _e( 'Send email automatically on complete orders', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="checkbox" name="woocommerce_gift_coupon_send" value="1" <?php echo $checked_send; ?> /></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Subject email:', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="text" name="woocommerce_gift_coupon_subject" value="<?php echo $woocommerce_gift_coupon_subject; ?>" /></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Email configuration:</h4>', 'woocommerce-gift-coupon' ); ?>
            </div>
            <div class="wgc-box-body">
                <table>
                    <tr>
                        <td><?php _e( 'Show logo?:', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="checkbox" name="woocommerce_gift_coupon_show_logo" value="1" <?php echo $checked_show_logo; ?> /></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Logo', 'woocommerce-gift-coupon' ); ?></td>
                        <td>
                            <input type="file" name="woocommerce_gift_coupon_logo" id="woocommerce_gift_coupon_logo"  multiple="false" />
                            <?php if( !empty( $woocommerce_gift_coupon_logo ) ): ?>
                                <p><img src="<?php echo $woocommerce_gift_coupon_logo; ?>" width="100" /></p>
                            <?php endif; ?>
                            <?php wp_nonce_field( plugin_basename( __FILE__ ), 'woocommerce_gift_coupon_logo' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Title', 'woocommerce-gift-coupon' ); ?></td>
                        <td><?php wp_editor( $woocommerce_gift_coupon_title_h , 'woocommerce_gift_coupon_title_h', $settings_tinymce);?></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Paragraph information:', 'woocommerce-gift-coupon' ); ?></td>
                        <td><?php wp_editor( $woocommerce_gift_coupon_info_paragraph , 'woocommerce_gift_coupon_info_paragraph', $settings_tinymce);?></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Footer:', 'woocommerce-gift-coupon' ); ?></td>
                        <td><?php wp_editor( $woocommerce_gift_coupon_info_footer , 'woocommerce_gift_coupon_info_footer', $settings_tinymce);?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Styles template Email:</h4>', 'woocommerce-gift-coupon' ); ?>
            </div>
            <div class="wgc-box-body">
                <table>
                    <tr>
                        <td><?php _e( 'Background header color (Logo area):', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="text" class="woocommerce-gift-coupon-color" name="woocommerce_gift_coupon_bg_color_header" id="woocommerce_gift_coupon_bg_color_header" value="<?php echo $woocommerce_gift_coupon_bg_color_header; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Background title color (Title area):', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="text" class="woocommerce-gift-coupon-color" name="woocommerce_gift_coupon_bg_color_title" id="woocommerce_gift_coupon_bg_color_title" value="<?php echo $woocommerce_gift_coupon_bg_color_title; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Background footer color:', 'woocommerce-gift-coupon' ); ?></td>
                        <td><input type="text" class="woocommerce-gift-coupon-color" name="woocommerce_gift_coupon_bg_color_footer" id="woocommerce_gift_coupon_bg_color_footer" value="<?php echo $woocommerce_gift_coupon_bg_color_footer; ?>"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block">
            <p class="submit">
                <input type="submit" class="button button-primary" name="Submit" id="Submit" value="<?php _e( 'Save options', 'woocommerce-gift-coupon' ); ?>" />
            </p>
        </div>
    </form>
</div> <!-- container -->


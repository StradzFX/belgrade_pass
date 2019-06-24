<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

delete_option( 'woocommerce_gift_coupon_show_logo' );
delete_option( 'woocommerce_gift_coupon_logo' );
delete_option( 'woocommerce_gift_coupon_send' );
delete_option( 'woocommerce_gift_coupon_bg_color_header' );
delete_option( 'woocommerce_gift_coupon_bg_color_footer' );
delete_option( 'woocommerce_gift_coupon_bg_color_title' );
delete_option( 'woocommerce_gift_coupon_info_paragraph' );
delete_option( 'woocommerce_gift_coupon_info_footer' );
delete_option( 'woocommerce_gift_coupon_title_h' );
delete_option( 'woocommerce_gift_coupon_subject' );

$table = $wpdb->prefix . "woocommerce_gift_coupon";
$sql = 'DROP TABLE '.$table;
$wpdb->query( $sql );

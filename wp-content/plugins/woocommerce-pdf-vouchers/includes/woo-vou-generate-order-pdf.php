<?php

global  $pdf_template_id, $pdf_voucodes;

//voucer codes
$pdf_voucodes	= str_replace( ' ', '', $voucodes );

//get product item quantity
$quantity		= !empty( $voucodes ) ? count( explode( ',', $voucodes ) ) : 0;

// Get voucher template id
$voucher_template_id = get_option( 'vou_pdf_template' );

// Getting voucher character support
$voucher_char_support = get_option( 'vou_char_support' );

//set voucher template id priority
$voucher_template_id = !empty( $pdf_template_meta ) ? $pdf_template_meta : $voucher_template_id;

//make pdf as global variable
$pdf_template_id = $voucher_template_id;

//get template data for check its exist
$voucher_template_data = get_post( $voucher_template_id );

//get voucher template html data
$voucher_template_html = $voucher_template_css = '';

// Taking some defaults
$orderid			= isset( $orderid ) 		? $orderid 			: '';
$orderdate 			= isset( $orderdate ) 		? $orderdate 		: '';
$productname  		= isset( $productname ) 	? $productname 		: '';
$variationname  	= isset( $variationname ) 	? $variationname 	: '';
$productprice  		= isset( $productprice ) 	? $productprice 	: '';
$regularprice  		= isset( $regularprice ) 	? $regularprice 	: '';
$discountprice  	= isset( $discountprice ) 	? $discountprice 	: '';
$pdf_vou_key		= isset( $pdf_vou_key ) 	? $pdf_vou_key 		: '';
$sku		        = isset( $sku ) 			? $sku 				: '';
$productshortdesc   = isset( $productshortdesc )? $productshortdesc : '';
$productfulldesc    = isset( $productfulldesc )  ? $productfulldesc : '';

if( !empty( $voucher_template_id ) && !empty( $voucher_template_data ) ) { // Check Template id and its exist or not

	$locations_html = '';
	
	$pdf_args['vou_template_id'] = $voucher_template_id;
	
	//locations for voucher use
	if( !empty( $locations ) ) {
		
		foreach ( $locations as $key => $value ) {
			
			/*if( !empty( $key ) ) {
				$locations_html .= '<br/>';
			}
			$key = $key + 1;
			$locations_html .= '(' . $key . ') ' . $value[$prefix.'locations'];
			
			if( !empty( $value[$prefix.'map_link'] ) ) { 
				$locations_html .= ' - ' . $value[$prefix.'map_link'];
			}*/
			if( isset( $value[$prefix.'locations'] ) && !empty( $value[$prefix.'locations'] ) ) {
			
				if( isset( $value[$prefix.'map_link'] ) && !empty( $value[$prefix.'map_link'] ) ) {
					$locations_html .= '<a style="text-decoration: none;" href="' . $value[$prefix.'map_link'] . '">' . $value[$prefix.'locations'] . '</a> ';
				} else {
					$locations_html .= $value[$prefix.'locations'] . ' ';
				}
			}
		}
	}			
	
	$woo_vou_details['productname'] = $productname;
	$woo_vou_details['quantity'] = $quantity;
	$woo_vou_details['sku'] = $sku;
	$woo_vou_details['productprice'] = $productprice;
	$woo_vou_details['regularprice'] = $regularprice;
	$woo_vou_details['discounted_amount'] = $discountprice;		
	$woo_vou_details['variationname'] = $variationname;			
	$woo_vou_details['productshortdesc'] = $productshortdesc;
	$woo_vou_details['productfulldesc'] = $productfulldesc;
	
	$woo_vou_details['redeem'] = $howtouse;
	$woo_vou_details['orderdate'] = $orderdate;
	$woo_vou_details['startdate'] = $start_date;
	$woo_vou_details['startdatetime'] = $start_date_time;
	$woo_vou_details['expiredate'] = $expiry_date;
	$woo_vou_details['expiredatetime'] = $expiry_date_time;
	
	$woo_vou_details['vendorlogo'] = $voulogohtml;
	$woo_vou_details['sitelogo'] = $vousitelogohtml;
	$woo_vou_details['siteurl'] = $website;
	$woo_vou_details['vendoraddress'] = $addressphone;
	$woo_vou_details['location'] = $locations_html;
	
	$woo_vou_details['codes'] = $voucodes;	
	
	$voucher_template_html = '<html>
								<head>
									<style>
										.woo_vou_textblock {
											text-align: justify;
										}
										.woo_vou_messagebox {
											text-align: justify;
										}
									</style>
								</head>
								<body>';
	
	$content_post	= get_post( $voucher_template_id );
	$content		= isset( $content_post->post_content ) ? $content_post->post_content : '';
	$content		= apply_filters( 'woo_vou_voucher_template_content', $content, $voucher_template_id );
	$voucher_template_inner_html = do_shortcode( $content );		
	
	// add filter to modify generated preview pdf voucher HTML OR to replace shortcodes with values
	$voucher_template_inner_html	= apply_filters( 'woo_vou_pdf_template_inner_html', $voucher_template_inner_html, $orderid, $item_key, $items, $voucodes, $productid, $woo_vou_details );	
	$voucher_template_html .= $voucher_template_inner_html;
	$voucher_template_html .= '</body>
							</html>';
	
} else { // Default Template
	
	$voucher_template_html = '';
	
	$voucher_template_html .= '<table class="woo_vou_pdf_table">';
	
	//site logo
	if( !empty( $vousitelogohtml ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="2">' . $vousitelogohtml . '</td>
									<td colspan="2">&nbsp;</td>
								</tr>';
	}

	//voucher logo
	if( !empty( $voulogohtml ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="2">' . $voulogohtml . '</td>
									<td colspan="2">&nbsp;</td>
								</tr>';
	}

	//voucher website
	if( !empty( $website ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="2">' . $website . '</td>
									<td colspan="2">&nbsp;</td>
								</tr>';
	}
	
	//vendor's address & phone
	if( !empty( $addressphone ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="2">' . nl2br( $addressphone ) . '</td>
									<td colspan="2">&nbsp;</td>
								</tr>';
	}
	
	//voucher codes
	//$multiple_pdf = get_option( 'multiple_pdf' );
	
	//Get mutiple pdf option from order meta
	$multiple_pdf = empty( $orderid ) ? '' : get_post_meta( $orderid, $prefix . 'multiple_pdf', true );
	
	if( $multiple_pdf == 'yes' && !empty( $orderdvoucodes ) ) {
		
		$key = $pdf_vou_key;
		
		$voucodes = $orderdvoucodes[$key];
		
		$voucher_template_html .= '<tr>
									<td colspan="4" style="text-align: center;">
										<table border="1">';
		$voucher_template_html .= '			<tr>
												<td><h3>' . __( 'Voucher Code(s)', 'woovoucher' ) . '</h3></td>
											</tr>';					
		$voucher_template_html .= '			<tr>
												<td><h4>' . $voucodes . '</h4></td>
											</tr>';				
		$voucher_template_html .= '		</table>
									</td>
								</tr>';
		
		
	} elseif( !empty( $voucodes ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="4" style="text-align: center;">
										<table border="1">';
		$voucher_template_html .= '			<tr>
												<td><h3>' . __( 'Voucher Code(s)', 'woovoucher' ) . '</h3></td>
											</tr>';
		$codes = explode( ', ', trim( $voucodes ) );
		foreach ( $codes as $code ) {
			
		$voucher_template_html .= '			<tr>
												<td><h4>' . $code . '</h4></td>
											</tr>';
		}
		$voucher_template_html .= '		</table>
									</td>
								</tr>';
	}
	
	//voucher use instruction
	if( !empty( $howtouse ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="4"><h4>' . __( 'How to redeem this Voucher', 'woovoucher' ) . '</h4></td>
								</tr>';
		$voucher_template_html .= '<tr>
									<td colspan="4">' . strip_tags( $howtouse ) . '</td>
								</tr>';
	}
	
	//start date
	if( !empty( $start_date ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="4">' . sprintf( __( 'Valid From: %s', 'woovoucher' ), $start_date ) . '</td>
								</tr>';
	}
	
	//expiration date
	if( !empty( $expiry_date ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="4">' . sprintf( __( 'Valid Until: %s', 'woovoucher' ), $expiry_date ) . '</td>
								</tr>';
	}
	
	//locations for voucher use
	if( !empty( $locations ) ) {
		
		$voucher_template_html .= '<tr>
									<td colspan="4"><h4>' . __( 'Locations where you can redeem the Voucher', 'woovoucher' ) . '</h4></td>
								</tr>';
		
		foreach ( $locations as $key => $value ) {
			
			/*$key = $key + 1;
			$location = '(' . $key . ') ' . $value[$prefix.'locations'];
			
			if( !empty( $value[$prefix.'map_link'] ) ) { 
				$location .= ' - ' . $value[$prefix.'map_link'];
			}*/
			
			$location = '';
			if( isset( $value[$prefix.'locations'] ) && !empty( $value[$prefix.'locations'] ) ) {
			
				if( isset( $value[$prefix.'map_link'] ) && !empty( $value[$prefix.'map_link'] ) ) {
					$location .= '<a style="text-decoration: none;" href="' . $value[$prefix.'map_link'] . '">' . $value[$prefix.'locations'] . '</a> ';
				} else {
					$location .= $value[$prefix.'locations'] . ' ';
				}
			}
				
		$voucher_template_html .= '<tr>
									<td colspan="4">' . $location . '</td>
								</tr>';
		}
	}
	$voucher_template_html .= '</table>';
}

$pdf_args['vou_codes'] 		= $voucodes; // Taking voucher codes
$pdf_args['char_support']	= (!empty($voucher_char_support) && $voucher_char_support == 'yes' ) ? 1 : 0; // Character support

woo_vou_generate_pdf_by_html( $voucher_template_html, $pdf_args );
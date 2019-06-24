<div id="listing_sidebar_products-6" class="widget  widget_listing_sidebar_products">				
	<h3 class="widget_sidebar_title">
		Detalji o popustu
	</h3>
	<div class="listing-products__items">
		<div class="product woocommerce add_to_cart_inline " id="product-11510">
			<div class="summary entry-summary">
				<h1 class="product_title entry-title">
					<?php echo $item->discount_description; ?>
				</h1>
				<p class="price" style="text-align: center;"><?php echo $item->pass_customer_percentage; ?>%</p>
				<form class="cart" action="buy_credits/" method="post" enctype="multipart/form-data">
					<button type="submit" name="add-to-cart" value="1875" class="single_add_to_cart_button button alt">Dopuni kredit</button>
				</form>
			</div><!-- .summary -->
		</div>
	</div><!-- .listing-products__items -->
</div>
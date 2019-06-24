<div class="widget  widget_listing_sidebar_map">
	<h3>Lokacije</h3>
	<div class="listing-map-content">
		<?php for ($i=0; $i < sizeof($item->locations); $i++) { ?> 
			<address class="listing-address">
				<div itemprop="">
						<span class="address__street">
							<?php echo $item->locations[$i]->street; ?>
						</span>
				</div>
				<div itemprop="">
						<span class="address__street">
							<?php echo $item->locations[$i]->part_of_city; ?>, <?php echo $item->locations[$i]->city; ?>
						</span>
				</div>			
			</address>
			<a href="//maps.google.com/maps?daddr=<?php echo $item->locations[$i]->latitude; ?>,<?php echo $item->locations[$i]->longitude; ?>" class="listing-address-directions" target="_blank">
					Pronađi na mapi
			</a>
		<?php } ?>
		
	</div><!-- .listing-map-content -->
</div>

<style type="text/css">
	.listing-map-content{
		position: initial!important;
	}

	.listing-map{
		height: auto;
	}

	.listing-address{
		margin: 0 0;
	}

	.listing-map-content a{
		display: block;
		margin-bottom: 20px;
	}

	.widget_listing_sidebar_map{
		text-align: center;
	}
</style>
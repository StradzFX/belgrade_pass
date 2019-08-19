<div id="listing_sidebar_gallery-2" class="widget  widget_listing_sidebar_gallery">
	<header class="listing-gallery__header">
		<span class="listing-gallery__title">Photo gallery</span>
		<a href="http://belgradepass.com/wp-content/uploads/2017/08/tranzit_bar_1.jpeg" class="listing-gallery__all">All photos (<?php echo sizeof($school->gallery); ?>)</a>
	</header>
	<div class="js-widget-gallery">
		<div class="row">
			<?php for($i=0;$i<sizeof($school->gallery);$i++){ ?>
				<div class="col-12 col-sm-4" <?php if($i>9){ ?>style="display:none"<?php } ?>>
					<a href="<?php echo $school->gallery[$i]->display_picture; ?>" class="listing-gallery__item">
						<div class="gallery_picture" style="background:url(<?php echo $school->gallery[$i]->display_picture; ?>) center no-repeat">
							
						</div>
					</a>
				</div>
			<?php } ?>	
		</div>
					
	</div><!-- .listing-gallery__items -->
</div>
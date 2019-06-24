<div id="listing_sidebar_gallery-2" class="widget  widget_listing_sidebar_gallery">
	<header class="listing-gallery__header">
		<span class="listing-gallery__title">Photo gallery</span>
		<a href="http://belgradepass.com/wp-content/uploads/2017/08/tranzit_bar_1.jpeg" class="listing-gallery__all">All photos (5)</a>
	</header>
	<div class="listing-gallery__items  js-widget-gallery">
		<?php for($i=0;$i<sizeof($school->gallery);$i++){ ?>
			<a href="<?php echo $school->gallery[$i]->display_picture; ?>" class="listing-gallery__item">
				<img width="150" height="150" src="<?php echo $school->gallery[$i]->display_picture; ?>" class="attachment-thumbnail size-thumbnail" alt="" itemprop="image" caption="" description="" sizes="(max-width: 150px) 100vw, 150px" />
			</a>
		<?php } ?>				
		</a>
	</div><!-- .listing-gallery__items -->
</div>
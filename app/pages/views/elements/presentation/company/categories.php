<div id="listing_sidebar_categories-2" class="widget  widget_listing_sidebar_categories">
	<ul class="categories">
		<?php for ($i=0; $i < sizeof($item->categories); $i++) { 
			$svg_icon = file_get_contents('public/images/icons/'.$item->categories[$i]->logo);
		?> 
		<li>
			<a href="companies/?search_keywords=&search_location=&search_categories=<?php echo $item->categories[$i]->id; ?>&submit=&filter_job_type=">
				<span class="category-icon">
					<?php echo $svg_icon; ?>
				</span>
				<span class="category-text"><?php echo $item->categories[$i]->name; ?></span>
			</a>
		</li>
		<?php } ?>
		
		<?php /*
		<li>
			<a href="http://belgradepass.com/listing-category/nightlife/">
				<span class="category-icon">
					<?php echo $wp_svg_icons['beer']; ?>
				</span>
				<span class="category-text">Nightlife</span>
			</a>
		</li>

		<li>
			<a href="http://belgradepass.com/listing-category/restaurant/">
				<span class="category-icon">
					<?php echo $wp_svg_icons['bartender']; ?>
				</span>
				<span class="category-text">Restaurant</span>
			</a>
		</li>
		*/ ?>
	</ul><!-- .categories -->
</div>
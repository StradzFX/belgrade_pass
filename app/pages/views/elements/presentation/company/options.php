<div id="listing_tags-4" class="widget  widget_listing_tags">
	<ul class="listing-tag-list">

		<?php for ($i=0; $i < sizeof($company_options_all); $i++) { ?> 
			<li>
				<a href="tag/<?php echo $company_options_all[$i]->tag; ?>/" class="listing-tag">
					<span class="tag__icon">
						<img src="public/images/options/<?php echo $company_options_all[$i]->tag; ?>.svg" alt="">
					</span>
					<span class="tag__text"><?php echo $options[$company_options_all[$i]->tag]['name']; ?></span>
				</a>
			</li>
		<?php } ?>
	</ul><!-- .listing-tag-list -->
</div>
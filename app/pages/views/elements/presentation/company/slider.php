<?php if(sizeof($item->gallery) > 0){ ?>
<div class="entry-featured-carousel">
	<div class="entry-featured-gallery">
		<?php for($i=0;$i<sizeof($item->gallery);$i++){ ?>
			<img class="entry-featured-image" src="<?php echo $item->gallery[$i]->display_picture; ?>" itemprop="image" />
		<?php } ?>
	</div>
</div>
<?php } ?>
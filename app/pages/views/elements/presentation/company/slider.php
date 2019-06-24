<?php if(sizeof($school->gallery) > 0){ ?>
<div class="entry-featured-carousel">
	<div class="entry-featured-gallery">
		<?php for($i=0;$i<sizeof($school->gallery);$i++){ ?>
			<img class="entry-featured-image" src="<?php echo $school->gallery[$i]->display_picture; ?>" itemprop="image" />
		<?php } ?>
	</div>
</div>
<?php } ?>
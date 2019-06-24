<?php
	if(!is_numeric($coach_row_size)){
		$coach_row_size = 4;
	}
?>
<div class="col m<?php echo $coach_row_size; ?>">
	<a href="<?php echo $coach_preview->link; ?>">
		<div class="item">
			<div>
				<div class="picture" style="background: url(<?php echo $coach_preview->photo_display; ?>) no-repeat center; background-size:cover;"></div>
			</div>
			<div class="name">
				<?php echo $coach_preview->full_name; ?>
			</div>
			<div class="description">
				<?php echo $coach_preview->short_description; ?>
			</div>
		</div>
	</a>
	
</div>
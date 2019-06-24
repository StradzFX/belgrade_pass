<div class="col s12 m3">
	<a href="<?php echo $coach_preview->link; ?>">
		<div class="item">
			<div>
				<div class="picture" style="background: url(<?php echo $coach_preview->photo_display; ?>) no-repeat center; background-size:cover;"></div>
			</div>
			<div class="name">
				<?php echo $coach_preview->full_name; ?>
			</div>
			<div class="description fade-container">
				<?php echo $coach_preview->short_description; ?>
				<div class="fade_element"></div>
			</div>
		</div>
	</a>
	
</div>


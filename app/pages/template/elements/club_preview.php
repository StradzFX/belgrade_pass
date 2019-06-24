	<div class="col col-xs-12 col-sm-4">
		<div class="club-preview">
			<div class="picture waves-effect waves-light" style="background: url(<?php echo $school_preview->thumb; ?>) no-repeat center; background-size:cover;">
				<a href="<?php echo $school_preview->link; ?>"></a>
			</div>
			<!-- /.picture -->
			<h3>
				<a href="<?php echo $school_preview->link; ?>">
					<?php echo $school_preview->name; ?>
				</a>
			</h3>
			<div class="location">
				<i class="fa fa-map-marker"></i> <?php echo $school_preview->short_location_display; ?>
			</div>
			<div class="description">
				<?php echo $school_preview->short_description; ?>
			</div>
			<!-- /.description -->
			<div class="">
				<a class="btn" href="<?php echo $school_preview->link; ?>">POGLEDAJTE DETALJE</a>
			</div>
			<!-- /.description -->
		</div>
		<!-- /.inv-project -->
	</a>
</div>
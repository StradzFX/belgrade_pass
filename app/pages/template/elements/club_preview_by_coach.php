<div class="col s12 m12">
	<div class="club-preview">
		<div class="row">
			<div class="col s4">
				<div class="picture waves-effect waves-light" style="background: url(<?php echo $school_preview->thumb; ?>) no-repeat center; background-size:cover;">
					<a a href="<?php echo $school_preview->link; ?>"></a>
				</div>
				<!-- /.picture -->
			</div>
			<div class="col s8">
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

				<div class="statistics">
					<div class="row">
						<div class="col s12 m6">
							<i class="fa fa-star green-mark"></i>
							<i class="fa fa-star green-mark"></i>
							<i class="fa fa-star green-mark"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<div class="col s12 m6">
							<div class="pull-right votes">
								26 glasova
							</div>
						</div>
					</div>
				</div>
				<!-- /.description -->
			</div>
		</div>
	</div>
</div>
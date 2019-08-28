<?php
	$week_days = array('Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota','Nedelja');
?>

<div class="widget  widget_listing_sidebar_map">
	<h3>Radno vreme</h3>
	<div class="listing-map-content working_hours">

		<?php for ($i=0; $i < sizeof($company_location->working_hours); $i++) {
			$current_working_time = $company_location->working_hours[$i]; 
			$day_of_week = $week_days[$current_working_time->day_of_week-1];
			$working_time = sprintf("%02d", $current_working_time->working_from_hours).':'.sprintf("%02d",$current_working_time->working_from_minutes).' - '.sprintf("%02d",$current_working_time->working_to_hours).':'.sprintf("%02d",$current_working_time->working_to_minutes);
			$current_css = $current_working_time->day_of_week == date('N') ? 'current_day' : '';
			?> 
			<div class="working_hours_item <?php echo $current_css; ?>">
				<div class="row">
					<div class="col-12 col-xs-6">
						<?php echo $day_of_week; ?>
					</div>
					<div class="col-12 col-xs-6 working_time">
						<?php echo $working_time; ?>
					</div>
				</div>
			</div>
		<?php } ?>
		
	</div><!-- .listing-map-content -->
</div>

<style type="text/css">
	.current_day{
		font-weight: bold;
		color:#FF4D55;
	}

	.working_hours{
		text-align: left;
	}

	.working_hours_item{
		margin-bottom: 5px;
		border-bottom: 1px solid #eee;
		padding-bottom: 5px;
	}

	.working_time{
		text-align: right;
	}

	.listing-map-content{
		position: initial!important;
	}

	.listing-map{
		height: auto;
	}

	.listing-address{
		margin: 0 0;
	}

	.listing-map-content a{
		display: block;
		margin-bottom: 20px;
	}

	.widget_listing_sidebar_map{
		text-align: center;
	}
</style>
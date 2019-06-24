<?php

$post_data = $_POST;
$filters = $post_data['filters'];


$schools = SchoolModule::get_search_birthdays($filters);

?>
<?php if(sizeof($schools) > 0){ ?>
<div class="row">
	<?php for ($i=0;$i<sizeof($schools);$i++) {
		$school_preview = $schools[$i];
		include 'app/pages/template/elements/club_preview.php';
	?>
	<?php } ?>
</div>
<?php }else{ ?>
<div class="no-registration">
	<div class="icon">
		<i class="fas fa-compass"></i>
	</div>

	<div class="warning_block_one">
		Nema rezultata
	</div>
	<div class="warning_block_two">
		Za odabranu pretragu.
	</div>

</div>
<?php } ?>

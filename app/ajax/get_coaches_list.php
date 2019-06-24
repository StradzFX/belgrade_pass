<?php

$post_data = $_POST;
$filters = $post_data['filters'];


$coaches = CoachModule::get_search($filters);

?>

<div class="row">
	<?php for ($i=0;$i<sizeof($coaches);$i++) {
		$coach_preview = $coaches[$i];
		include 'app/pages/template/elements/coach_preview_search.php';
	?>
	<?php } ?>
</div>
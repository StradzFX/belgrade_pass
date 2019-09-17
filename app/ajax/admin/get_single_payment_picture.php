<?php


$data = $post_data['data'];

$pathx = "../public/images/post_office/";
/*koliko je pametno ovako ostaviti varijabilu???*/
$file = $data['id'];
$jpg = ".jpg";


?>

<div class="img_holder">
	<?php echo '<img src="'.$pathx.$file.$jpg.'">'; ?>

</div>


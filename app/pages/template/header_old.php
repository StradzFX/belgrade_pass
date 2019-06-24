<?php

$list_categories_header = CategoryModule::list_all_popular();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="ex9k1j3sr5CaGcA0i1xqQW1b1doJILKqtHhs3fYAiFI" />
<?php $seo->echo_seo_tags();?>

<base href="<?php echo $base_url;?>" />
<!-- ======================= GLOBAL JS SCRIPT ========================-->
<script>
	var master_data = {};
		master_data.base_url = "<?php echo $base_url; ?>";
		master_data.website_name = "<?php echo $site_name; ?>";
</script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- ======================= CSS IMPORT ========================-->
<?php for($i=0;$i<sizeof($default_css_files);$i++){ ?>
<link href="<?php echo $default_css_files[$i]; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<!-- Compiled and minified CSS -->
 
<!-- ======================= JS IMPORT =========================-->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<?php for($i=0;$i<sizeof($default_js_files);$i++){ ?>
<script src="<?php echo $default_js_files[$i]; ?>" type="text/javascript"></script>
<?php } ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131414886-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-131414886-1');
</script>


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="public/plugins/materialize/css/materialize.min.css" rel="stylesheet">
</head>
<body>

<?php 
	if(CoreConfig::$development){ 
		$debug_company = $broker->get_session('company');
		if($debug_company){ ?>
		<div>
			ID: <?php echo $debug_company->id; ?> <br/>
			Location ID: <?php echo $debug_company->location->id; ?>
		</div>
		<?php } ?>
<?php }

?>

<!-- ======================= LOADER ========================-->
<div id="loader">
	<div id="loader_position">
		<img src="public/images/loader/loading.gif">
    </div>
</div>
<!-- ======================= WEBSITE SYSTEM MESSAGE ========================-->
<div class="website_system_message"></div>


<?php include_once 'app/pages/template/responsive_menu.php'; ?>
<?php include_once 'app/pages/template/registration_popup.php'; ?>


<div class="main-header">
	<div class="gray">
		<div class="container">
			<div class="logo">
				<a href="<?php echo $base_url; ?>">
					<img src="public/images/_general/logo.png" class="logo_big" />
				</a> 

				
			</div>
			<!-- /.logo -->
			<div class="main_menu hide-on-med-and-down">
				<a href="companies/">Sve aktivnosti</a>
				<a href="kako_funkcionise/">Kako funkcioniše?</a>
				<a href="registracija/">Registruj se</a>
				<a href="kupi_paket/">Kupi paket</a>
				<a href="o_nama/">O nama</a>
			</div>

			<div class="navigation">
				<?php include_once 'app/pages/template/desktop_menu.php'; ?>
			</div>
		</div>
	</div>
</div>
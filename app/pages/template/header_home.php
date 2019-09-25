<?php
global $broker;
$reg_user = $broker->get_session('user');
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


 
<!-- ======================= JS IMPORT =========================-->
<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
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

<link rel='dns-prefetch' href='//maps.google.com' />
<link rel='dns-prefetch' href='//cdnjs.cloudflare.com' />
<link rel='dns-prefetch' href='//s.w.org' />
<link rel="alternate" type="application/rss+xml" title="Belgradepass &raquo; Feed" href="feed/" />
<link rel="alternate" type="application/rss+xml" title="Belgradepass &raquo; Comments Feed" href="comments/feed/" />
<link rel="alternate" type="text/calendar" title="Belgradepass &raquo; iCal Feed" href="events/?ical=1" />
<link rel='stylesheet' id='login-with-ajax-css'  href='wp-content/plugins/login-with-ajax/widget/widget.css?ver=3.1.7' type='text/css' media='all' />
<link rel='stylesheet' id='chosen-css'  href='wp-content/plugins/wp-job-manager/assets/css/chosen.css?ver=1.1.0' type='text/css' media='all' />
<link rel='stylesheet' id='wp-job-manager-frontend-css'  href='wp-content/plugins/wp-job-manager/assets/css/frontend.css?ver=1.28.0.1' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-calendar-style-css'  href='wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-full.min.css?ver=4.5.12.2' type='text/css' media='all' />
<link rel='stylesheet' id='tribe-events-calendar-mobile-style-css'  href='wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-full-mobile.min.css?ver=4.5.12.2' type='text/css' media='only screen and (max-width: 768px)' />
<link rel='stylesheet' id='woo-vou-public-style-css'  href='wp-content/plugins/woocommerce-pdf-vouchers/includes/css/woo-vou-public.css?ver=2.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='listable-style-css'  href='wp-content/themes/listable/style.css?ver=1.8.10' type='text/css' media='all' />
<link rel='stylesheet' id='listable-login-with-ajax-css'  href='wp-content/themes/listable/assets/css/login-with-ajax.css?ver=1.8.10' type='text/css' media='all' />
<link rel='stylesheet' id='A2A_SHARE_SAVE-css'  href='wp-content/plugins/add-to-any/addtoany.min.css?ver=1.14' type='text/css' media='all' />

<!-- ======================= CSS IMPORT ========================-->
<?php for($i=0;$i<sizeof($default_css_files);$i++){ ?>
<link href="<?php echo $default_css_files[$i]; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<!-- Compiled and minified CSS -->


<script type='text/javascript' src='wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>
<script type='text/javascript' src='wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var LWA = {"ajaxurl":"http:\/\/belgradepass.com\/wp-admin\/admin-ajax.php"};
/* ]]> */
</script>
<script type='text/javascript' src='wp-content/plugins/login-with-ajax/widget/login-with-ajax.js?ver=3.1.7'></script>
<script type='text/javascript' src='wp-content/plugins/add-to-any/addtoany.min.js?ver=1.0'></script>
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenLite.min.js?ver=4.8.9'></script>
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/plugins/ScrollToPlugin.min.js?ver=4.8.9'></script>
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/plugins/CSSPlugin.min.js?ver=4.8.9'></script>
<link rel='https://api.w.org/' href='wp-json/' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 4.8.9" />
<meta name="generator" content="WooCommerce 3.1.2" />
<link rel="canonical" href="" />
<link rel='shortlink' href='' />
<link rel="alternate" type="application/json+oembed" href="wp-json/oembed/1.0/embed?url=http%3A%2F%2Fbelgradepass.com%2F" />
<link rel="alternate" type="text/xml+oembed" href="wp-json/oembed/1.0/embed?url=http%3A%2F%2Fbelgradepass.com%2F&#038;format=xml" />

<script type="text/javascript">
var a2a_config=a2a_config||{};a2a_config.callbacks=a2a_config.callbacks||[];a2a_config.templates=a2a_config.templates||{};
</script>
<script type="text/javascript" src="https://static.addtoany.com/menu/page.js" async="async"></script>
			<script type="text/javascript">
				if (typeof WebFont !== 'undefined') {					WebFont.load({
						google: {families: ['Source Sans Pro:regular']},
						classes: false,
						events: false
					});
				} else {
					var tk = document.createElement('script');
					tk.src = '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
					tk.type = 'text/javascript';

					tk.onload = tk.onreadystatechange = function () {
						WebFont.load({
							google: {families: ['Source Sans Pro:regular']},
							classes: false,
							events: false
						});
					};

					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(tk, s);
				}
			</script>
	<meta name="tec-api-version" content="v1"><meta name="tec-api-origin" content="http://belgradepass.com"><link rel="https://theeventscalendar.com" href="wp-json/tribe/events/v1/" />	<noscript><style>.woocommerce-product-gallery{ opacity: 1 !important; }</style></noscript>

	<link href="https://fonts.googleapis.com/css?family=Armata&display=swap" rel="stylesheet">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-44137778-16"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-44137778-16');
	</script>

</head>
<body class="home page-template page-template-page-templates page-template-front_page page-template-page-templatesfront_page-php page page-id-206 wp-custom-logo tribe-no-js group-blog listable" data-mapbox-token="" data-mapbox-style="mapbox.emerald">

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

<?php include_once 'app/pages/template/admin_control_panel.php'; ?>
<?php include_once 'app/pages/template/registration_popup.php'; ?>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content">Skip to content</a>

	<header id="masthead" class="site-header  header--transparent" role="banner">
		<div class="site-branding  site-branding--image"><a href="" class="custom-logo-link  custom-logo-link--light" rel="home" itemprop="url"><img width="130" height="130" src="wp-content/uploads/2017/07/logo-belgrade.png" class="custom-logo" alt="" itemprop="logo" /></a></div>
		

				<button class="menu-trigger  menu--open  js-menu-trigger">
		<svg width="30px" height="30px" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs></defs>
    <g id="Responsiveness" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
        <g id="noun_70916" transform="translate(0.000000, 5.000000)">
            <path d="M0.909090909,2.22222222 L29.0909091,2.22222222 C29.5927273,2.22222222 30,1.72444444 30,1.11111111 C30,0.497777778 29.5927273,0 29.0909091,0 L0.909090909,0 C0.407272727,0 0,0.497777778 0,1.11111111 C0,1.72444444 0.407272727,2.22222222 0.909090909,2.22222222 L0.909090909,2.22222222 Z" id="Shape"></path>
            <path d="M0.909090909,11.1111111 L29.0909091,11.1111111 C29.5927273,11.1111111 30,10.6133333 30,10 C30,9.38666667 29.5927273,8.88888889 29.0909091,8.88888889 L0.909090909,8.88888889 C0.407272727,8.88888889 0,9.38666667 0,10 C0,10.6133333 0.407272727,11.1111111 0.909090909,11.1111111 L0.909090909,11.1111111 Z" id="Shape"></path>
            <path d="M0.909090909,20 L29.0909091,20 C29.5927273,20 30,19.5022222 30,18.8888889 C30,18.2755556 29.5927273,17.7777778 29.0909091,17.7777778 L0.909090909,17.7777778 C0.407272727,17.7777778 0,18.2755556 0,18.8888889 C0,19.5022222 0.407272727,20 0.909090909,20 L0.909090909,20 Z" id="Shape"></path>
        </g>
    </g>
</svg>
		</button>
		<nav id="site-navigation" class="menu-wrapper" role="navigation">
			<button class="menu-trigger  menu--close  js-menu-trigger">

				<svg class="close-icon" width="30" height="30" viewBox="0 0 30 30" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.326 15l13.4-13.4c.366-.366.366-.96 0-1.325-.366-.367-.96-.367-1.326 0L15 13.675 1.6.275C1.235-.093.64-.093.275.275c-.367.365-.367.96 0 1.324l13.4 13.4-13.4 13.4c-.367.364-.367.96 0 1.323.182.184.422.275.662.275.24 0 .48-.09.663-.276l13.4-13.4 13.4 13.4c.183.184.423.275.663.275.24 0 .48-.09.662-.276.367-.365.367-.96 0-1.324L16.325 15z" fill-rule="evenodd"/>

			</button>

			<ul id="menu-main-menu" class="primary-menu"><li id="menu-item-11042" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-11042"><a href="companies/" class=" ">Kuda</a>
				<ul  class="sub-menu">
					<li id="menu-item-11076" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11076"><a href="companies/" class=" ">Sve kategorije</a></li>
					<?php for ($i=0; $i < sizeof($list_categories_header); $i++) { ?> 
						<li class="menu-item menu-item-type-taxonomy menu-item-object-job_listing_category menu-item-11047">
							<a href="<?php echo $list_categories_header[$i]->link; ?>" class=" ">
								<?php echo $list_categories_header[$i]->name; ?>
							</a>
						</li>
					<?php } ?>
					
				</ul>
			</li>
<?php /*
<li id="menu-item-11590" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11590"><a href="events/" class=" ">EVENTS</a></li>
<li id="menu-item-11057" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11057"><a href="tips-articles/" class=" ">Blog</a></li>
*/ ?>
<li id="menu-item-11136" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-11136"><a href="profile/" class=" ">Moj nalog</a>
<ul  class="sub-menu">
	<li id="menu-item-11137" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11137">
		<?php if(!$reg_user){ ?>
		<a href="registracija/" class=" ">Moj profil</a>
		<?php }else{ ?>
		<a href="profile/" class=" ">Moj profil</a>
		<?php } ?>
	</li>
	<?php if($reg_user){ ?>
	<li id="menu-item-11138" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11138"><a href="logout/" class=" ">Izloguj se</a></li>
	<?php } ?>
</ul>
</li>
</ul>
		</nav>
			</header><!-- #masthead -->

			<div id="content" class="site-content js-header-height-padding-top">

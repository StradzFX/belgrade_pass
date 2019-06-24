	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
								<article id="post-206" class="post-206 page type-page status-publish has-post-thumbnail hentry">
					<header class="entry-header has-image">
						<div class="entry-featured" style="background-image: url(http://belgradepass.com/wp-content/uploads/2015/10/image_14.jpg);">
													</div>
						<div class="header-content">
							<h1 class="page-title">Istraži Beograd</h1>

							<div class="entry-subtitle">
								<p>Pronađi odlična mesta, uštedi sa karticom.</p>
							</div>

							
<form class="search-form   job_search_form  js-search-form" action="companies/" method="get" role="search">
	
	<div class="search_jobs  search_jobs--frontpage">

		
		
		<div class="search-field-wrapper  search-filter-wrapper">
			<label for="search_keywords">Ključne reći</label>
			<input class="search-field  js-search-suggestions-field" type="text" name="search_keywords" id="search_keywords" placeholder="Šta tražite?" autocomplete="off" value=""/>
					</div>

		
		
			<div class="search_location  search-filter-wrapper">
				<label for="search_location">Lokacija</label>
									<input type="text" name="search_location" id="search_location" placeholder="Lokacija" />
							</div>

		
		
        <div class="search_categories  search-filter-wrapper">
            <label for="search_categories">Category</label>
            <select name='search_categories' id='search_categories' class='job-manager-category-dropdown '  data-placeholder='Choose a category&hellip;' data-no_results_text='No results match' data-multiple_text='Select Some Options'>
				<option value="">Sve kategorije</option>
				<?php for ($i=0; $i < sizeof($categories_search); $i++) { ?>
					<option class="level-0" value="<?php echo $categories_search[$i]->id; ?>">
						<?php echo $categories_search[$i]->name; ?>
					</option>
				<?php } ?>
			</select>
        </div>

        
		
		<button class="search-submit" name="submit" id="searchsubmit">
			<svg class="search-icon" width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs></defs>
    <g id="Layout---Header" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Header-4" transform="translate(-486.000000, -76.000000)" fill="currentColor">
            <g id="Header" transform="translate(0.000000, 55.000000)">
                <g id="Search" transform="translate(226.000000, 17.000000)">
                    <path d="M276.815533,20.8726 C276.2478,21.4392667 275.3406,21.4392667 274.801133,20.8726 L270.318733,16.3611333 C267.7374,18.0352667 264.2478,17.7518 261.9782,15.4539333 C259.3406,12.8155333 259.3406,8.61633333 261.9782,5.979 C264.6166,3.34033333 268.815533,3.34033333 271.4542,5.979 C273.694733,8.21953333 274.035533,11.7374 272.3614,14.3184667 L276.8718,18.8299333 C277.3542,19.3686 277.3542,20.3051333 276.815533,20.8726 L276.815533,20.8726 Z M269.694733,7.6518 C268.020867,5.979 265.297933,5.979 263.624067,7.6518 C261.949933,9.32593333 261.949933,12.0499333 263.624067,13.7227333 C265.297933,15.3966 268.020867,15.3966 269.694733,13.7227333 C271.368867,12.0499333 271.368867,9.32593333 269.694733,7.6518 L269.694733,7.6518 Z" id="Search-Icon"></path>
                </g>
            </g>
        </g>
    </g>
</svg>
			<span>Pretraži</span>
		</button>
	</div>

		<ul class="job_types">
					<li><label for="job_type_eat" class="eat"><input type="checkbox" name="filter_job_type[]" value="eat"  id="job_type_eat" /> Eat</label></li>
					<li><label for="job_type_shop" class="shop"><input type="checkbox" name="filter_job_type[]" value="shop"  id="job_type_shop" /> Shop</label></li>
					<li><label for="job_type_stay" class="stay"><input type="checkbox" name="filter_job_type[]" value="stay"  id="job_type_stay" /> Stay</label></li>
					<li><label for="job_type_visit" class="visit"><input type="checkbox" name="filter_job_type[]" value="visit"  id="job_type_visit" /> Visit</label></li>
			</ul>
	<input type="hidden" name="filter_job_type[]" value="" />
<div class="showing_jobs"></div></form>


<noscript>Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.</noscript>


						</div>

						<div class="top-categories">
							<?php for ($i=0; $i < sizeof($categories_highlights); $i++) { 
								$svg_icon = file_get_contents('public/images/icons/'.$categories_highlights[$i]->logo);
								?> 
								<a href="category/<?php echo $categories_highlights[$i]->id; ?>">
									<span class="cat__icon">
										<?php echo $svg_icon; ?>
									</span>
									<span class="cat__text">
										<?php echo $categories_highlights[$i]->name; ?>
									</span>
								</a>
							<?php } ?>
							
							<div style="position: relative;">
								<span class="cta-text">Ili istražite najpopularnije</span>
							</div>
						</div>
					</header>

										<!-- .entry-content -->

					<div class="widgets_area">
						<div class="front-page-section">
							<div class="section-wrap">
								<h3 class="widget_title  widget_title--frontpage">
									Za šta ste danas raspoloženi?
									<span class="widget_subtitle  widget_subtitle--frontpage">
										Istražite BelgradePass i uštedite koristeći našu karticu.
									</span>
								</h3>

								<div class="categories-wrap  categories-wrap--widget">
									<ul class="categories  categories--widget">
										<?php for ($i=0; $i < sizeof($categories_wrap); $i++) { 
											$svg_icon = file_get_contents('public/images/icons/'.$categories_wrap[$i]->logo);
										?> 
											<li>
												<div class="category-cover" style="background-image: url(<?php echo $categories_wrap[$i]->map_logo; ?>)">
													<a href="category/<?php echo $categories_wrap[$i]->id; ?>">
														<div class="category-icon">
															<?php echo $svg_icon; ?>
															
															<span class="category-count">
																<?php echo $categories_wrap[$i]->count; ?>
															</span>
														</div>
														<span class="category-text">
															<?php echo $categories_wrap[$i]->name; ?>
														</span>
													</a>
												</div>
											</li>
										<?php } ?>
									</ul><!-- .categories -->
								</div><!-- .categories-wrap -->
							</div>
						</div>

		<div class="front-page-section"><div class="section-wrap">
		<div class="widget_front_page_listing_cards" itemscope="" itemtype="http://schema.org/LocalBusiness">
			<h3 class="widget_title  widget_title--frontpage">
				Najbolje ponude u gradu	
				<span class="widget_subtitle--frontpage">
					Istražite najbolje ponude naših partnera.					
				</span>
			</h3>
			<div class="grid  grid--widget  list">
				<?php for ($i=0; $i < sizeof($top_places); $i++) { ?>
				<a href="company/<?php echo $top_places[$i]->id; ?>" class="grid__item  grid__item--widget">
					<article class="card  card--listing  card--widget   product product first instock virtual sold-individually purchasable product-type-booking">
						<aside class="card__image" style="background-image: url(<?php echo $top_places[$i]->thumb; ?>);">
						</aside>

						<div class="card__content">
							<h2 class="card__title" itemprop="name">
								<?php echo $top_places[$i]->name; ?>
							</h2>
							<div class="card__tagline">
								<?php echo $top_places[$i]->short_description; ?>
							</div>
							<footer class="card__footer">
								
								<ul class="card__tags">
									<?php for ($j=0; $j < sizeof($top_places[$i]->categories); $j++) { 
										$svg_icon = file_get_contents('public/images/icons/'.$top_places[$i]->categories[$j]->logo);
									?> 
										<li>
											<div class="card__tag">
												<div class="pin__icon">
														<?php echo $svg_icon; ?>							
												</div>
											</div>
										</li>
									<?php } ?>
								</ul>

								<div class="address  card__address">
									<div itemprop="streetAddress">
										<span class="address__street"><?php echo $top_places[$i]->pass_customer_percentage; ?>% popusta</span>
									</div>					
								</div>
							</footer>
						</div><!-- .card__content -->
					</article><!-- .card.card--listing -->
				</a><!-- .grid_item -->
				<?php } ?>
			</div>
		</div>
	</div>
</div>

		<div class="front-page-section"><div class="section-wrap">
		<h3 class="widget_title  widget_title--frontpage">
			Kako funkcioniše BelgradePass				<span class="widget_subtitle  widget_subtitle--frontpage">Iskoristi BelgradePass karticu i uštedi kod naših partnera</span>
					</h3>

		
		<div class="grid  grid--widget">
							<div class="grid__item  grid__item--widget">
					<div class="card  card--post  card--feature  card--widget">
						<div class="card__content">
							<img src="public/images/restaurant.png" />
							<div class="card__title">Odaberi restoran</div>

							Zabava je na svakom koraku, pronađi je! Preko 300 restorana samo u Beogradu daju širom izbor mogućnosti
						</div><!-- .card__content -->
					</div><!-- .card.card--post.card--feature -->
				</div><!-- .grid__item -->

							<div class="grid__item  grid__item--widget">
					<div class="card  card--post  card--feature  card--widget">
						<div class="card__content">
							<img src="public/images/credit-card.png" />
															<div class="card__title">Zatraži karticu i uplati kredite</div>
							Registracijom dobijate karticu na koju možete uplaćivati kredite koje kasnije trošite kod naših partnera						</div><!-- .card__content -->
					</div><!-- .card.card--post.card--feature -->
				</div><!-- .grid__item -->

							<div class="grid__item  grid__item--widget">
					<div class="card  card--post  card--feature  card--widget">
						<div class="card__content">
							<img src="public/images/frame.png" />
							<div class="card__title">Plati QR kodom</div>
							Sve što je neohdno da uradite je da pokažete QR kod vaše kartice i transakcija će biti zabeležena						</div><!-- .card__content -->
					</div><!-- .card.card--post.card--feature -->
				</div><!-- .grid__item -->

					</div><!-- .grid -->

				</div></div>
					</div>
					
				</article><!-- #post-## -->

			
		</main>
		<!-- #main -->
	</div><!-- #primary -->


	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
					<div id="footer-sidebar" class="footer-widget-area" role="complementary">
				<aside id="a2a_follow_widget-3" class="widget  widget--footer  widget_a2a_follow_widget"><h2 class="widget-title">Follow us</h2><div class="a2a_kit a2a_kit_size_32 a2a_follow addtoany_list" data-a2a-url="http://belgradepass.com/" data-a2a-title="Discover Belgrade" style=""><a class="a2a_button_facebook" href="https://sr-rs.facebook.com/belgradepass/" title="Facebook" rel="noopener" target="_blank"></a><a class="a2a_button_instagram" href="https://www.instagram.com/belgradepass/" title="Instagram" rel="noopener" target="_blank"></a><a class="a2a_button_youtube_channel" href="https://www.youtube.com/user/belgradepass" title="YouTube Channel" rel="noopener" target="_blank"></a></div></aside>			</div><!-- #primary-sidebar -->
				<div class="footer-text-area">
			<div class="site-info">
									<div class="site-copyright-area">
						Copyright © 2017 BelgradePass					</div>
											</div><!-- .site-info -->
			<div class="theme-info">
				<a href="https://wordpress.org/"> </a>
				<span class="sep">  </span>
				<a href="http://themeforest.net/item/listable-a-friendly-directory-wordpress-theme/13398377?ref=pixelgrade" rel="theme"></a>  <a href="https://pixelgrade.com/" rel="designer"></a>.			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div class="hide">
	<div class="arrow-icon-svg"><svg width="25" height="23" viewBox="0 0 25 23" xmlns="http://www.w3.org/2000/svg"><path d="M24.394 12.81c.04-.043.08-.084.114-.13.02-.02.04-.047.055-.07l.025-.034c.258-.345.412-.773.412-1.24 0-.464-.154-.89-.412-1.237-.01-.02-.022-.036-.035-.05l-.045-.06c-.035-.044-.073-.09-.118-.13L15.138.61c-.814-.813-2.132-.813-2.946 0-.814.814-.814 2.132 0 2.947l5.697 5.7H2.08c-1.148 0-2.08.93-2.08 2.083 0 1.15.932 2.082 2.084 2.085H17.89l-5.7 5.695c-.814.815-.814 2.137 0 2.95.814.815 2.132.815 2.946 0l9.256-9.255c-.004-.003 0-.006 0-.006z" fill="currentColor" fill-rule="evenodd"/></svg>

</div>
	<div class="cluster-icon-svg"><svg width="50px" height="62px" viewBox="0 0 50 62" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-1">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
        <path id="unique-path-2" d="M6.75141997,6.76666667 C0.287315594,13.2746963 -1.50665686,22.6191407 1.24745785,30.7382815 C7.20204673,48.0746963 23.0106822,58 23.0106822,58 C23.0106822,58 38.6298497,48.1382815 44.6475946,30.9969185 C44.6475946,30.9333333 44.7107506,30.8697481 44.7107506,30.8027259 C47.5280214,22.6191407 45.7340489,13.2746963 39.2699445,6.76666667 C30.3086168,-2.25555556 15.7127477,-2.25555556 6.75141997,6.76666667 Z"></path>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-3">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
        <path id="unique-path-4" d="M8.87079997,8.83664825 C3.24983965,14.4470186 1.6898636,22.5025742 4.08474595,29.5018334 C9.26264933,44.4470186 23.0092889,53.0033149 23.0092889,53.0033149 C23.0092889,53.0033149 36.5911736,44.5018334 41.8239953,29.7247964 C41.8239953,29.6699816 41.8789136,29.6151668 41.8789136,29.557389 C44.3287142,22.5025742 42.7687382,14.4470186 37.1477778,8.83664825 C29.355319,1.05887047 16.6632588,1.05887047 8.87079997,8.83664825 Z"></path>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-5">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
        <path id="unique-path-6" d="M10.28372,10.25 C5.22485568,15.2993333 3.82087724,22.5493333 5.97627136,28.8486667 C10.6363844,42.2993333 23.00836,50 23.00836,50 C23.00836,50 35.2320563,42.3486667 39.9415958,29.0493333 C39.9415958,29 39.9910222,28.9506667 39.9910222,28.8986667 C42.1958428,22.5493333 40.7918644,15.2993333 35.7330001,10.25 C28.7197871,3.25 17.296933,3.25 10.28372,10.25 Z"></path>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-7">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
        <path id="unique-path-8" d="M11.69664,11.6666667 C7.19987172,16.154963 5.95189088,22.5994074 7.86779676,28.1988148 C12.0101195,40.154963 23.0074311,47 23.0074311,47 C23.0074311,47 33.8729389,40.1988148 38.0591962,28.3771852 C38.0591962,28.3333333 38.1031309,28.2894815 38.1031309,28.2432593 C40.0629714,22.5994074 38.8149905,16.154963 34.3182223,11.6666667 C28.0842552,5.44444444 17.9306071,5.44444444 11.69664,11.6666667 Z"></path>
    </defs>
    <g id="Page---Listings-Archive" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Pin-4" transform="translate(2.000000, 1.000000)">
            <g id="Pin-Copy-4" filter="url(#filter-1)">
                <use fill="#FFFFFF" xlink:href="#unique-path-2"></use>
                <use id="svgCluster1" fill="currentColor" xlink:href="#unique-path-2"></use>
            </g>
            <g id="Pin-Copy-3" filter="url(#filter-3)">
                <use fill="#FFFFFF" fill-rule="evenodd" xlink:href="#unique-path-4"></use>
                <use id="svgCluster2" fill="none" xlink:href="#unique-path-4"></use>
            </g>
            <g id="Pin-Copy-6" filter="url(#filter-5)">
                <use fill="#FFFFFF" fill-rule="evenodd" xlink:href="#unique-path-6"></use>
                <use id="svgCluster3" fill="none" xlink:href="#unique-path-6"></use>
            </g>
            <g id="Pin-Copy-5" filter="url(#filter-7)">
                <use fill="#FFFFFF" fill-rule="evenodd" xlink:href="#unique-path-8"></use>
                <use id="svgCluster4" fill="none" xlink:href="#unique-path-8"></use>
            </g>
        </g>
    </g>
</svg>
</div>
	<div class="selected-icon-svg"><svg width="48px" height="59px" viewBox="0 0 48 59" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-1">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
        <path id="path-2" d="M6.47133474,6.469534 C0.275396197,12.691788 -1.44415263,21.6259064 1.19570658,29.3885257 C6.90326708,45.9636772 22.0560753,55.4531486 22.0560753,55.4531486 C22.0560753,55.4531486 37.0272756,46.0244703 42.7953721,29.6358057 C42.7953721,29.5750126 42.8559081,29.5142195 42.8559081,29.4501403 C45.5563033,21.6259064 43.8367544,12.691788 37.6408159,6.469534 C29.0512523,-2.15651133 15.0608983,-2.15651133 6.47133474,6.469534 Z"></path>
    </defs>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(2.000000, 1.000000)">
            <g id="Pin" filter="url(#filter-1)">
                <use fill="#FFFFFF" xlink:href="#path-2"></use>
                <use id="selected" xlink:href="#path-2"></use>
            </g>
            <ellipse id="oval" fill="#FFFFFF" cx="22" cy="22.0243094" rx="18" ry="18.0198895"></ellipse>
        </g>
    </g>
</svg>
</div>
	<div class="empty-icon-svg"><svg width="48px" height="59px" viewBox="0 0 48 59" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-1">
            <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
            <feGaussianBlur stdDeviation="1" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
            <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.35 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
            <feMerge>
                <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                <feMergeNode in="SourceGraphic"></feMergeNode>
            </feMerge>
        </filter>
	    <path d="M8.47133474,8.077269 C2.2753962,14.299523 0.55584737,23.2336414 3.19570658,30.9962607 C8.90326708,47.5714122 24.0560753,57.0608836 24.0560753,57.0608836 C24.0560753,57.0608836 39.0272756,47.6322053 44.7953721,31.2435407 C44.7953721,31.1827476 44.8559081,31.1219545 44.8559081,31.0578753 C47.5563033,23.2336414 45.8367544,14.299523 39.6408159,8.077269 C31.0512523,-0.54877633 17.0608983,-0.54877633 8.47133474,8.077269 L8.47133474,8.077269 Z M24,33.607735 C29.5228475,33.607735 34,29.1305825 34,23.607735 C34,18.0848875 29.5228475,13.607735 24,13.607735 C18.4771525,13.607735 14,18.0848875 14,23.607735 C14,29.1305825 18.4771525,33.607735 24,33.607735 L24,33.607735 Z" id="path-empty"></path>
    </defs>
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(2.000000, 1.000000)">
            <g id="Pin" filter="url(#filter-1)">
                <use fill="#FFFFFF" xlink:href="#path-empty"></use>
                <use id="selected" xlink:href="#path-empty"></use>
            </g>
        </g>
    </g>
</svg>
</div>
	<div class="card-pin-svg"><svg width="14px" height="20px" viewBox="0 0 14 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <path d="M7,0 C3.13383665,0 0,3.0828692 0,6.88540084 C0,10.68827 6.33390528,20 7,20 C7.66609472,20 14,10.68827 14,6.88540084 C14,3.0828692 10.8661633,0 7,0 L7,0 Z M7,9.87341772 C5.2947838,9.87341772 3.91146191,8.51274262 3.91146191,6.83544304 C3.91146191,5.15814346 5.2947838,3.79746835 7,3.79746835 C8.7052162,3.79746835 10.0885381,5.15814346 10.0885381,6.83544304 C10.0885381,8.51274262 8.7052162,9.87341772 7,9.87341772 L7,9.87341772 Z" id="Imported-Layers-Copy-5" fill="currentColor" sketch:type="MSShapeGroup"></path>
    </g>
</svg>
</div>

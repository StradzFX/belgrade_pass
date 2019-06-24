<?php

$post_data = $_POST;
$filters = $post_data['filters'];


$schools = SchoolModule::get_search($filters);

for ($i=0; $i < sizeof($schools); $i++) { 
	$sport_category_all = new sport_category();
	$sport_category_all->set_condition('checker','!=','');
	$sport_category_all->add_condition('recordStatus','=','O');
	$sport_category_all->add_condition('id','IN',"(SELECT DISTINCT category FROM company_category WHERE company = ".$schools[$i]->id." AND recordStatus = 'O')");
	$sport_category_all->set_order_by('pozicija','DESC');
	$schools[$i]->categories =  $broker->get_all_data_condition($sport_category_all);

}

?>
<?php for ($i=0;$i<sizeof($schools);$i++) {
		$school_preview = $schools[$i]; ?>
	<div class="grid__item">
		<article class="card  card--listing product product first instock shipping-taxable product-type-simple" itemscope="" data-latitude="44.8172465" data-longitude="20.4560913" data-icon="http://belgradepass.com/wp-content/uploads/2017/07/images-150x150.png">
			<a href="<?php echo $school_preview->link; ?>">
				<aside class="card__image" style="background-image: url(<?php echo $school_preview->thumb; ?>);">
					<span class="product__price"></span>
				</aside><!-- .card__image -->
				<div class="card__content">
					<h2 class="card__title" itemprop="name">
						<?php echo $school_preview->name; ?>
					</h2>
					<div class="card__tagline" itemprop="description">
						<?php echo $school_preview->short_description; ?>
					</div>
					<footer class="card__footer">
						<div class="card__rating  card__pin">
							<svg width="14px" height="20px" viewBox="0 0 14 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
	    						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
							        <path d="M7,0 C3.13383665,0 0,3.0828692 0,6.88540084 C0,10.68827 6.33390528,20 7,20 C7.66609472,20 14,10.68827 14,6.88540084 C14,3.0828692 10.8661633,0 7,0 L7,0 Z M7,9.87341772 C5.2947838,9.87341772 3.91146191,8.51274262 3.91146191,6.83544304 C3.91146191,5.15814346 5.2947838,3.79746835 7,3.79746835 C8.7052162,3.79746835 10.0885381,5.15814346 10.0885381,6.83544304 C10.0885381,8.51274262 8.7052162,9.87341772 7,9.87341772 L7,9.87341772 Z" id="Imported-Layers-Copy-5" fill="currentColor" sketch:type="MSShapeGroup"></path>
							    </g>
							</svg>
						</div>
						<ul class="card__tags">
							<?php for ($j=0; $j < sizeof($schools[$i]->categories); $j++) {
										$svg_icon = file_get_contents('public/images/icons/'.$schools[$i]->categories[$j]->logo);
									 ?> 
							<li>
								<div class="card__tag">
									<div class="pin__icon">
										<?php echo $svg_icon; ?>
									</div>
								</div>
							</li>
							<?php } ?>
						
						</ul><!-- .card__tags -->
						<div class="address  card__address" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
							<div itemprop="streetAddress">
								<span class="address__street">
									<?php echo $school_preview->short_location_display; ?>
								</span>
							</div>
						</div>
					</footer>
				</div><!-- .card__content -->
			</a>
		</article><!-- .card.card--listing -->
	</div><!-- .grid__item -->
	<?php } ?>
<?php

global $broker;

$categories_search = new sport_category();
$categories_search->set_condition('checker','!=','');
$categories_search->add_condition('recordStatus','=','O');
$categories_search->set_order_by('popularity','DESC');
$categories_search = $broker->get_all_data_condition($categories_search);

?>

<div id="primary" class="content-area">
	
	<main id="main" class="site-main" role="main">
		<article id="post-6" class="post-6 page type-page status-publish hentry">
			<div class="entry-content" id="entry-content-anchor">
				<div class="job_listings" data-location="" data-keywords="" data-show_filters="true" data-show_pagination="false" data-per_page="10" data-orderby="featured" data-order="DESC" data-categories="" >
					<div class="myflex">
						<div class="myflex__left">
							<form class="job_filters">

								<div class="search_jobs see_all">
									<div class="row">
										<div class="col-12 col-sm-4">
											<label for="search_location">Kategorija</label>
											<select name="search_category" onchange="get_search_results()">
												<option value="">Sve kategorije</option>
												<?php for ($i=0; $i < sizeof($categories_search); $i++) { ?>
													<option class="level-0" <?php if($_GET['search_categories'] == $categories_search[$i]->id){ ?>selected="selected"<?php } ?> value="<?php echo $categories_search[$i]->id; ?>">
														<?php echo $categories_search[$i]->name; ?>
													</option>
												<?php } ?>
											</select>
										</div>
										<div class="col-12 col-sm-4">
											<label for="search_location">Šta tražite</label>
											<input type="text" name="search_keywords" onkeyup="get_search_results()" value="<?php echo $_GET['search_keywords']; ?>" placeholder="---">
										</div>
										<div class="col-12 col-sm-4">
											<label for="search_location">Lokacija</label>
											<input type="text" name="search_location" onkeyup="get_search_results()" value="<?php echo $_GET['search_location']; ?>" name="" placeholder="---">
										</div>
									</div>
								</div><!-- .search_jobs -->

								<div class="mobile-buttons">
									<button class="btn btn--filter">Filter <span>Listings</span></button>
									<button class="btn btn--view btn--view-map"><span>Map View</span>
									</button>
									<button class="btn btn--view btn--view-cards">
										<span>Cards View </span></button>
								</div>

								<ul class="job_types">
									<li><label for="job_type_eat" class="eat"><input type="checkbox" name="filter_job_type[]" value="eat"  checked='checked' id="job_type_eat" /> Eat</label></li>
									<li><label for="job_type_shop" class="shop"><input type="checkbox" name="filter_job_type[]" value="shop"  checked='checked' id="job_type_shop" /> Shop</label></li>
									<li><label for="job_type_stay" class="stay"><input type="checkbox" name="filter_job_type[]" value="stay"  checked='checked' id="job_type_stay" /> Stay</label></li>
									<li><label for="job_type_visit" class="visit"><input type="checkbox" name="filter_job_type[]" value="visit"  checked='checked' id="job_type_visit" /> Visit</label></li>
								</ul>
								<input type="hidden" name="filter_job_type[]" value="" />
								<div class="showing_jobs"></div>
							</form><!-- .job_filter -->
							<noscript>Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.</noscript>
	
	

							<?php /* ============================= GRID VIEW ======================= */ ?>
							<div class="grid list job_listings search_list">
								
							</div>

							<?php /* ============================= LOADER ======================= */ ?>
							<svg class="loader" width="40px" height="40px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							    <defs>
							        <linearGradient x1="50%" y1="7.52257671%" x2="50%" y2="100%" id="linearGradient-1">
							            <stop stop-color="currentColor" stop-opacity="0.5" offset="0%"></stop>
							            <stop stop-color="currentColor" stop-opacity="0" offset="100%"></stop>
							        </linearGradient>
							        <linearGradient x1="50%" y1="7.70206696%" x2="50%" y2="100%" id="linearGradient-2">
							            <stop stop-color="currentColor" stop-opacity="0.5" offset="0%"></stop>
							            <stop stop-color="currentColor" offset="100%"></stop>
							        </linearGradient>
							    </defs>
							    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							        <g>
							            <path d="M20,0 C31.045695,0 40,8.954305 40,20 C40,31.045695 31.045695,40 20,40 L20,38 C29.9411255,38 38,29.9411255 38,20 C38,10.0588745 29.9411255,2 20,2 L20,0 Z" id="Oval-1" fill="url(#linearGradient-1)"></path>
							            <path d="M20,0 C8.954305,0 0,8.954305 0,20 C0,31.045695 8.954305,40 20,40 L20,38 C10.0588745,38 2,29.9411255 2,20 C2,10.0588745 10.0588745,2 20,2 L20,0 Z" id="Oval-1-Copy" fill="url(#linearGradient-2)"></path>
							        </g>
							    </g>
							</svg>

							<a class="load_more_jobs" href="#" style="display:none;"><strong>Load more listings</strong></a>

						</div><!-- .myflex__left -->

						<?php /* ============================= MAP VIEW ======================= */ ?>
						<div id="mapid" class="map myflex__right leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom map--google"></div>
					</div><!-- .myflex -->
				</div>
			</div><!-- .entry-content -->
		</article><!-- #post-## -->
	</main><!-- #main -->
</div><!-- #primary -->

 <script>
// Initialize and add the map
/*
var marker_list = new Array();
var map = null;
var map_marker_list = new Array();

function initMap() {

	
		
  // The location of Uluru
  var map_center = {lat: 44.8029925, lng: 20.4865823};
  // The map, centered at Uluru
  map = new google.maps.Map(
      document.getElementById('map'), {zoom: 12, center: map_center});
 	populate_markers();

}*/

var blanko_pin = '';


function populate_markers(){
  var marker_image = '<?php echo $base_url; ?>public/images/markers/m1.png';

  var myIcon = L.icon({
	  iconUrl: marker_image,
	  iconRetinaUrl: marker_image,
	  iconSize: [29, 24],
	  iconAnchor: [9, 21],
	  popupAnchor: [0, -14]
	});

 /* var infowindow = new google.maps.InfoWindow({
    content: contentString
  });*/

  map_marker_list = new Array();
 var markerClusters = L.markerClusterGroup({
 	iconCreateFunction: function (cluster) {
        var childCount = cluster.getChildCount();

			var c = ' marker-cluster-';
			if (childCount < 10) {
				c += 'small';
			} else if (childCount < 100) {
				c += 'medium';
			} else {
				c += 'large';
			}

			return new L.DivIcon({ html: marker_list[0][8] + '<span>' + childCount + '</span>', className: 'marker-cluster' + c, iconSize: new L.Point(40, 40) });
    },
                        showCoverageOnHover: false,
                        spiderfyDistanceMultiplier: 3,
                        spiderLegPolylineOptions: {
                            weight: 0
                        }
                    });


  for(var i=0; i< marker_list.length;i++){
  	var iconClass = 'pin';
  		iconHTML = "<div class='" + iconClass + "'>" + marker_list[i][7] + "<div class='pin__icon'>" + marker_list[i][6] + "</div></div>";
  	var m = L.marker([marker_list[i][0],marker_list[i][1]],{
                    icon: new CustomHtmlIcon({
                        html: iconHTML
                    })
                }).addTo(mymap)
		.bindPopup("<a class='popup' href='" + marker_list[i][5] + "'>" +
                        "<div class='popup__image' style='background-image: url(" + marker_list[i][9] + ");'></div>" +
                        "<div class='popup__content'>" +
                        "<h3 class='popup__title'>" + marker_list[i][3] + "</h3>" +
                        "<div class='popup__footer'>" +
                        "<div class='popup__address'>" + marker_list[i][10] + "</div>" +
                        "</div>" +
                        "</div>" +
                        "</a>");

	markerClusters.addLayer( m );

  	/*var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<div id="firstHeading" class="firstHeading">'+marker_list[i][3]+'</div>'+
      '<div id="bodyContent">'+
      '<p>'+marker_list[i][4]+'</b></p>'+
      '<a href="'+marker_list[i][5]+'">Pogledaj detalje</a>.</p>'+
      '</div>'+
      '</div>';

  	var marker_point = {lat: marker_list[i][0], lng: marker_list[i][1]};
  	var marker = new google.maps.Marker({
  		position: marker_point, 
  		map: map, 
  		icon:marker_image,
  		content:contentString
  	});
	  	google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
	  		return function() {
        		infowindow.setContent(content);
       			infowindow.open(map,marker);
    		};
		})(marker,contentString,infowindow));  


  		map_marker_list[i] = marker;
  		*/
  }

  mymap.addLayer( markerClusters );

  /*var markerCluster = new MarkerClusterer(map, map_marker_list,
            {imagePath: 'public/images/markers/m'});*/
}
</script>



<script type="text/javascript">
	
	function get_search_map(){
		var filters = get_search_filters();

		var call_url = "get_search_map";  
        var call_data = { 
          filters:filters 
        }  
        var callback = function(response){ 
        	//clear_markers(); 
        	marker_list = response.marker_list;
        	for (var i = marker_list.length - 1; i >= 0; i--) {
        		marker_list[i][0] = parseFloat(marker_list[i][0]);
        		marker_list[i][1] = parseFloat(marker_list[i][1]);
        	}
        	populate_markers();
        }  
        ajax_json_call(call_url, call_data, callback);
	}

	function get_search_list(){
		var filters = get_search_filters();

        var call_url = "get_search_list";  
        var call_data = { 
          filters:filters 
        }  
        var callback = function(response){  
        	$('.search_list').html(response);
        }  
        ajax_call(call_url, call_data, callback);
	}

	function get_search_results(){
		get_search_list();
		get_search_map();
	}

	$(function(){
		get_search_results();
	});

	function get_search_filters(){
		var filters = {};
			filters.search_text = $('[name="search_keywords"]').val();
			filters.category = $('[name="search_category"]').val();
			filters.location = $('[name="search_location"]').val();
			

		return filters;
	}

	function clear_markers(){
		for (var i = map_marker_list.length - 1; i >= 0; i--) {
			map_marker_list[i].setMap(null);
		}
	}

</script>

<style type="text/css">

</style>

    <link rel="stylesheet" type="text/css" href="public/js/leaflet/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="public/js/leaflet/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="public/js/leaflet/MarkerCluster.Default.css" />

<script type='text/javascript' src='public/js/leaflet/leaflet.js'></script>
<script type='text/javascript' src='public/js/leaflet/leaflet.markercluster.js'></script>


<script type="text/javascript">
	var mymap = L.map('mapid').setView([44.8029925,20.4865823], 14);

	L.HtmlIcon = L.Icon.extend({
		options: {
			/*
			html: (String) (required)
			iconAnchor: (Point)
			popupAnchor: (Point)
			*/
		},

		initialize: function (options) {
			L.Util.setOptions(this, options);
		},

		createIcon: function () {
			var div = document.createElement('div');
			div.innerHTML = this.options.html;
			return div;
		},

		createShadow: function () {
			return null;
		}
	});

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'BelgradePass',
		id: 'mapbox.streets'
	}).addTo(mymap);

	CustomHtmlIcon = L.HtmlIcon.extend({
        options: {
            html: "<div class='pin'></div>",
            iconSize: [48, 59], // size of the icon
            iconAnchor: [24, 59], // point of the icon which will correspond to marker's location
            popupAnchor: [0, -59] // point from which the popup should open relative to the iconAnchor
        }
    });


	


	var greenIcon = L.icon({
	    iconUrl: 'leaf-green.png',
	    shadowUrl: 'leaf-shadow.png',

	    iconSize:     [38, 95], // size of the icon
	    shadowSize:   [50, 64], // size of the shadow
	    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
	    shadowAnchor: [4, 62],  // the same for the shadow
	    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});

	


	var popup = L.popup();

	function onMapClick(e) {
		/*popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(mymap);*/
	}

	mymap.on('click', onMapClick);
</script>
<div class="page_content">
	<div class="schools">
		<div class="container">
			<div class="page-headline border-green">
				<h2>Pretraga aktivnosti</h2>
			</div>
		</div>

		<div class="container">
			<div class="filters">
				<div class="row">
					<div class="col s12 m6">
						<input type="text" name="search_text" onkeyup="search_for_schools()" class="browser-default" placeholder="Pretraga po ključnim rečima" />
					</div>
					<div class="col s12 m2">
						<select name="location" onchange="search_for_schools()" class="browser-default">
							<option value="">Sve lokacije</option>
							<?php for ($i=0; $i < sizeof($list_cities); $i++) {  ?>
								<option value="<?php echo $list_cities[$i]['name']; ?>"><?php echo $list_cities[$i]['name']; ?></option>
								<?php for ($j=0; $j < sizeof($list_cities[$i]['parts']); $j++) {  ?>
								<option value="<?php echo $list_cities[$i]['name']; ?>,<?php echo $list_cities[$i]['parts'][$j]['part_of_city']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $list_cities[$i]['parts'][$j]['part_of_city']; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
					</div>

					<div class="col s12 m2">
						<select name="category" onchange="search_for_schools()" class="browser-default">
							<option value="">Sve kategorije</option>
							<?php for ($i=0; $i < sizeof($list_categories); $i++) {  ?>
								<option value="<?php echo $list_categories[$i]->id; ?>" <?php if($selected_category == $list_categories[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $list_categories[$i]->name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="search_content">
				<div class="search_switch">
					<!-- Switch -->
					  <div class="switch">
					    <label>
					      Mapa
					      <input type="checkbox" name="search_option" onchange="change_search_option()">
					      <span class="lever"></span>
					      Lista
					    </label>
					  </div>
				</div>
				<div>
					<div class="search_option search_map">
						<div id="map"></div>
					</div>

					<div class="search_option search_list none">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.top-cover -->

<script type="text/javascript">
	function change_search_option(){
		var is_checked = $('[name="search_option"]').is(':checked');

		if(is_checked){
			$('.search_map').addClass('none');
			$('.search_list').removeClass('none');
		}else{
			$('.search_map').removeClass('none');
			$('.search_list').addClass('none');
		}
	}
</script>
 <script>
// Initialize and add the map

var marker_list = new Array();
var map = null;
var map_marker_list = new Array();

function initMap() {

	
		
  // The location of Uluru
  var map_center = {lat: 44.8029925, lng: 20.4865823};
  // The map, centered at Uluru
  map = new google.maps.Map(
      document.getElementById('map'), {zoom: 10, center: map_center});
  populate_markers();

}

function populate_markers(){
  var soccer_image = '<?php echo $base_url; ?>public/images/schools/soccer-ball.png';
  var horse_image = '<?php echo $base_url; ?>public/images/schools/horse.png';
  var exercise_image = '<?php echo $base_url; ?>public/images/schools/exercise.png';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  map_marker_list = new Array();

  for(var i=0; i< marker_list.length;i++){

  	var contentString = '<div id="content">'+
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
  		icon:marker_list[i][2],
  		content:contentString
  	});
	  	google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
	  		return function() {
        		infowindow.setContent(content);
       			infowindow.open(map,marker);
    		};
		})(marker,contentString,infowindow));  


  		map_marker_list[i] = marker;
  }
}
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOsWQtPLZxsiYNQd5Eky48Tu2Hg-PSQZU&callback=initMap">
    </script>


<script type="text/javascript">
	
	function get_search_map(){
		var filters = get_search_filters();

		var call_url = "get_search_map";  
        var call_data = { 
          filters:filters 
        }  
        var callback = function(response){ 
        	clear_markers(); 
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

	function clear_markers(){
		for (var i = map_marker_list.length - 1; i >= 0; i--) {
			map_marker_list[i].setMap(null);
		}
	}


	function get_search_filters(){
		var filters = {};
			filters.search_text = $('[name="search_text"]').val();
			filters.category = $('[name="category"]').val();
			filters.location = $('[name="location"]').val();
			

		return filters;
	}


	function search_for_schools(){
		get_search_list();
		get_search_map();
	}

	$(function(){
		search_for_schools();

		var slider = document.getElementById('test-slider');
		  noUiSlider.create(slider, {
		   start: [20, 80],
		   connect: true,
		   step: 1,
		   orientation: 'horizontal', // 'horizontal' or 'vertical'
		   range: {
		     'min': 0,
		     'max': 100
		   }
		  });
	});


	 

</script>
<style type="text/css" href="public/js/nouislider/nouislider.min.css"></style>
<script type="text/javascript" src="public/js/nouislider/nouislider.min.js"></script>

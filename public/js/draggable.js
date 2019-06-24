//============================ DRAGGABLE ================================================
var draggable_selection = false;
$(function(){
	if(draggable_selection){
		add_draggable($('.scenes'));
	}
});
var current_draggable = null;
function add_draggable(node){
	var children = node.children();
	if(children.length > 0){
		for(var i =0; i<children.length;i++){
			add_draggable($(children[i]));
		}
	}

	if(node.css('position') == 'absolute' || node.hasClass('absolute')){
		node.draggable({
			drag: function() {
	        	current_draggable = $(this);

	        	var offset = $(this).offset();
	        	$('#core_element_position_top').val(offset.top+'px');
	        	$('#core_element_position_left').val(offset.left+'px');
	        	$('#core_element_position_css').val('top:'+offset.top+'px; left:'+offset.left+'px;');
	      	}
		});
	}
}

$(document).keydown(function(e) {
	if(current_draggable != null){
	    switch(e.which) {
	        case 37: {
	        	current_draggable.css('left','-=1px');
	        };
	        break;

	        case 38:{
	        	current_draggable.css('top','-=1px');
	        };
	        break;

	        case 39:{
	        	current_draggable.css('left','+=1px');
	        };
	        break;

	        case 40:{
	        	current_draggable.css('top','+=1px');
	        };
	        break;

	        default: return; // exit this handler for other keys
	    }
	    e.preventDefault(); // prevent the default action (scroll / move caret)

	  	$('#core_element_position_top').val(current_draggable.offset().top+'px');
	    $('#core_element_position_left').val(current_draggable.offset().left+'px');
	    $('#core_element_position_css').val('top:'+current_draggable.offset().top+'px; left:'+current_draggable.offset().left+'px;');  	
	}
});
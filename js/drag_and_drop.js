jQuery(document).ready(function($) {

	//var data = {
		//action: 'my_action',
		//whatever: 1234
	//};

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	//$.post(ajaxurl, data, function(response) {
		//alert('Got this from the server: ' + response);
	//});
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("../wp-list-posts.php", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			}); 															 
		}								  
		});
	});
});

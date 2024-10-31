//Preloader and mask
$(window).bind("load" , function() {	
	$('#mask').fadeIn(1000);
        $("#mask").css("display" , "block");
        $('#popupwindow').fadeIn(1000);
        $("#popupwindow").css("display" , "block"); 
        $("#pop_cross").click(function(){
          $("#popupwindow").css("display" , "none");
	      $("#mask").css("display" , "none");
              });
			$("#status").delay(2000).fadeOut("slow"); // will first fade out the loading animation
			$("#preloader").delay(2000).fadeOut("slow"); // will fade out the white DIV that covers the website.  
			  });
			 


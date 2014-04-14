$(document).ready(function(){
   $("Login").hover(function() {
     $(this).addClass("link_hover");
   });
 
   	//AJAX for search query
	$("#search_form").submit(function(event){
		
		//remove any defualt post/get actions
		event.preventDefault();
		
		
		//get the search field value and assign it to a variable
		$search = $("#search_field").val();
		//pass the search
		$.get("search.php", {search: $search},
			function(data){
				
				$("#results").empty().hide(0).append(data).delay(500).fadeIn(500)
							});
	});
	
	
	
	$('.option').live('click', function(){
	
		//get car
		var $car = $(this).children('.id').html();
	
			$.post('view_movie.php', {car: $car},
				function(data){
					$("#results").empty().hide(0).append(data).delay(400).fadeIn(500)
					});
				
			});	
	
	
	
	


	 
	
   
});
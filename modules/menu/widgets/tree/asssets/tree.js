 
 $('.order_input').mouseout(function(){

	$.ajax({
	  url: "test.html",
	  cache: false,
	  success: function(html){
		$("#results").append(html);
	  }
	}); 
	
 });


 $('.attr-public').click(function(){

     $.ajax({
         url: "/menu/default/attrpublic/id/"+$(this).attr('data-id'),
         cache: false,
         success: function(html){
             alert(html);
         }
     });

 });
					$(function($) {
										var field = new Array("email", "name", "message");
											
									$("#call_send").submit(function() {
												var error=0;
													$("#call_send").find(":input").each(function() {
														for(var i=0;i<field.length;i++){
															if($(this).attr("name")==field[i]){ 
																if(!$(this).val()){
																	$(this).css('border', 'red 1px solid');
																	error=1;						
																} else {
																	$(this).css('border', '1px solid #BBB');
																	$(this).css('background', 'url(img/inp-bg.png) repeat-x center;');
																}
															}						
														}			
													})
										if (error==0) {
											
										var $form = $("#call_send"),
											s_name 	= $form.find( 'input[name="name"]' ).val(),
											s_email 	= $form.find( 'input[name="email"]' ).val(),
											s_message 		= $form.find( 'textarea[name="message"]' ).val(),
											url 		= $form.attr( 'action' );
											
											$('#result').fadeIn(100);
											$('#hide').hide(100);
											$('#txt').fadeIn(100);
											$('#result').html("Отправка...");
											$('#txt').html("В ближайшее время ваша заявка будет обработана.");
											$.post( url, { name: s_name, message: s_message, email: s_email} ).done(function(data) {
												$('#result').html(data);
											});
											
										return false;
										} else {
											var err_text = "";
											if(error==1)  err_text="Не все обязательные поля заполнены!";
											return false;
										}
								
									});								
						
});
 
 
var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
     
    browse_button : 'pickfiles', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
     
    url : "/system/images/upload",
     
    filters : {
        max_file_size : '10mb',
        mime_types: [
            {title : "Image files", extensions : "jpg,gif,png"},
            {title : "Zip files", extensions : "zip"}
        ]
    },
 	headers :{ 'X-CSRF-Token': yii.getCsrfToken() },
	
    // Flash settings
    flash_swf_url : '/plupload/js/Moxie.swf',
 
    // Silverlight settings
    silverlight_xap_url : '/plupload/js/Moxie.xap',
     
 
    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
 
            document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
        },
 
        FilesAdded: function(up, files) {
            console.log(plupload);
            plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div class="alert alert-success"  id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><button type="button" class="close plupload_added_close" data-dismiss="alert" aria-hidden="true" data-file="'+file.id+'">&times;</button></div>';
				 
            });
			 
			 
        },
 
        UploadProgress: function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
 		 FileUploaded: function(up, file, info) {
				var obj = jQuery.parseJSON( info.response );
			 
				document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML +'<input type="hidden" name="Pictures['+obj.pid+']" value="'+obj.hash_code+'"  />';
            },
		
        Error: function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});
 
uploader.init();

$('#filelist').on('click','.plupload_added_close',function(e){

 uploader.removeFile($(this).attr('data-file'))

});

 
	
$('.uploaded_delete').click(function(){
		var image=$(this);
		
		$.ajax({
		 url : "/system/images/delete?id="+image.attr('data-id'),
		  success: function(){
			
			image.parent('li').remove();
			image.remove();
		  }
		});
		 
	});


$('.slider').click(function(){
    var el = $(this);
    $.ajax({
        url : $(this).attr('href'),
        success: function(){

            if(el.hasClass('close'))
                el.removeClass('close');
            else
                el.addClass('close');
        }

    });
    return false;
});

$('.glyphicon-chevron-left').click(function(){
	  	
		var obj = $(this).parent('li').prev('li');
		
		$(this).parent('li').after(obj);
	  
	    order_list();
	 });
	 
 $('.glyphicon-chevron-right').click(function(){
	 
	    var obj = $(this).parent('li').next('li');
		
		$(this).parent('li').before(obj);
		
		order_list();
	 }); 
	
function order_list()
{
	var order = '';
	$('.list-inline').each(function(index,el){
		order = order + $(el).attr('data-id')+',';	
	});	
	
	$.ajax({
		  url : "/system/images/order",
		  type:'POST',
		  headers :{ 'X-CSRF-Token': yii.getCsrfToken() },
		  data:'order_seq='+order,
		  success: function(txt){
			 
		  }
		});
}
	
	
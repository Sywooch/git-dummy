
$(document).ready(function(){
var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',

    browse_button : 'pickfiles', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
     
    url : "/system/umages/uploadtouser",
    resize: {
        width: 240,
        height: 240
    },
    filters : {
        max_file_size : '200kb',
        mime_types: [
            {title : "Image files", extensions : "jpg,gif"},

        ]
    },
 	headers :{ 'X-CSRF-Token':$('meta[name=csrf-token]').attr("content") },
	
    // Flash settings
    flash_swf_url : '/plupload/js/Moxie.swf',
 
    // Silverlight settings
    silverlight_xap_url : '/plupload/js/Moxie.xap',
     
 
    init: {
        PostInit: function() {


             /*   $('#uploadfiles').on('touchstart click', function(){

                    uploader.start();
                });*/

            /*   document.getElementById('filelist').innerHTML = '';
 
          document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };

*/
        },
 
        FilesAdded: function(up, files) {
           /* plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div class="alert alert-success"  id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b><button type="button" class="close plupload_added_close" data-dismiss="alert" aria-hidden="true" data-file="'+file.id+'">&times;</button></div>';
				 
            });*/
            jQuery("#pickfiles").parent("div").parent("div").children("img").attr("src",'/img/bx_loader.gif');
            uploader.start();
			 
        },
 
        UploadProgress: function(up, file) {
           // document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
 		 FileUploaded: function(up, file, info) {
				var obj = jQuery.parseJSON( info.response );
			 
				//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML +'<input type="hidden" name="Pictures['+obj.pid+']" value="'+obj.hash_code+'"  />';
             console.log(obj);
                jQuery("#pickfiles").parent("div").parent("div").children("img").attr("src",obj.image);
            },
		
        Error: function(up, err) {
            alert(err.message);
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});
 
uploader.init();
});
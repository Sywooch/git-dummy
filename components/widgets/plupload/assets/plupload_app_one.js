 
 
var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    multipart: false,
    browse_button : 'pickfiles', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
     
    url : "index.php?r=system/images/upload",
     
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
 
        addFile: function(up, files) {
            /*plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
			jQuery('#filelist').show();*/
            alert('sdf');

        },

        UploadProgress: function(up, file) {
           // document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
 		 FileUploaded: function(up, file, info) {
				var obj = jQuery.parseJSON( info.response );
			 
				//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML +'<input type="hidden" name="Pictures['+obj.pid+']" value="'+obj.hash_code+'"  />';
				
					 
            },
		
        Error: function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});
 
 
 
uploader.init();


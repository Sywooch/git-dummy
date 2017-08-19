/**
 * Plupload - multi-runtime File Uploader
 * v2.1.2
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 *
 * Date: 2014-05-14
 */
/**
 * Plupload.js
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

/*global mOxie:true */

;(function(window, o, undef) {

var delay = window.setTimeout
, fileFilters = {}
;

// convert plupload features to caps acceptable by mOxie
function normalizeCaps(settings) {		
	var features = settings.required_features, caps = {};

	function resolve(feature, value, strict) {
		// Feature notation is deprecated, use caps (this thing here is required for backward compatibility)
		var map = { 
			chunks: 'slice_blob',
			jpgresize: 'send_binary_string',
			pngresize: 'send_binary_string',
			progress: 'report_upload_progress',
			multi_selection: 'select_multiple',
			dragdrop: 'drag_and_drop',
			drop_element: 'drag_and_drop',
			headers: 'send_custom_headers',
			urlstream_upload: 'send_binary_string',
			canSendBinary: 'send_binary',
			triggerDialog: 'summon_file_dialog'
		};

		if (map[feature]) {
			caps[map[feature]] = value;
		} else if (!strict) {
			caps[feature] = value;
		}
	}

	if (typeof(features) === 'string') {
		plupload.each(features.split(/\s*,\s*/), function(feature) {
			resolve(feature, true);
		});
	} else if (typeof(features) === 'object') {
		plupload.each(features, function(value, feature) {
			resolve(feature, value);
		});
	} else if (features === true) {
		// check settings for required features
		if (settings.chunk_size > 0) {
			caps.slice_blob = true;
		}

		if (settings.resize.enabled || !settings.multipart) {
			caps.send_binary_string = true;
		}
		
		plupload.each(settings, function(value, feature) {
			resolve(feature, !!value, true); // strict check
		});
	}
	
	return caps;
}

/** 
 * @module plupload	
 * @static
 */
var plupload = {
	/**
	 * Plupload version will be replaced on build.
	 *
	 * @property VERSION
	 * @for Plupload
	 * @static
	 * @final
	 */
	VERSION : '2.1.2',

	/**
	 * Inital state of the queue and also the state ones it's finished all it's uploads.
	 *
	 * @property STOPPED
	 * @static
	 * @final
	 */
	STOPPED : 1,

	/**
	 * Upload process is running
	 *
	 * @property STARTED
	 * @static
	 * @final
	 */
	STARTED : 2,

	/**
	 * File is queued for upload
	 *
	 * @property QUEUED
	 * @static
	 * @final
	 */
	QUEUED : 1,

	/**
	 * File is being uploaded
	 *
	 * @property UPLOADING
	 * @static
	 * @final
	 */
	UPLOADING : 2,

	/**
	 * File has failed to be uploaded
	 *
	 * @property FAILED
	 * @static
	 * @final
	 */
	FAILED : 4,

	/**
	 * File has been uploaded successfully
	 *
	 * @property DONE
	 * @static
	 * @final
	 */
	DONE : 5,

	// Error constants used by the Error event

	/**
	 * Generic error for example if an exception is thrown inside Silverlight.
	 *
	 * @property GENERIC_ERROR
	 * @static
	 * @final
	 */
	GENERIC_ERROR : -100,

	/**
	 * HTTP transport error. For example if the server produces a HTTP status other than 200.
	 *
	 * @property HTTP_ERROR
	 * @static
	 * @final
	 */
	HTTP_ERROR : -200,

	/**
	 * Generic I/O error. For example if it wasn't possible to open the file stream on local machine.
	 *
	 * @property IO_ERROR
	 * @static
	 * @final
	 */
	IO_ERROR : -300,

	/**
	 * @property SECURITY_ERROR
	 * @static
	 * @final
	 */
	SECURITY_ERROR : -400,

	/**
	 * Initialization error. Will be triggered if no runtime was initialized.
	 *
	 * @property INIT_ERROR
	 * @static
	 * @final
	 */
	INIT_ERROR : -500,

	/**
	 * File size error. If the user selects a file that is too large it will be blocked and an error of this type will be triggered.
	 *
	 * @property FILE_SIZE_ERROR
	 * @static
	 * @final
	 */
	FILE_SIZE_ERROR : -600,

	/**
	 * File extension error. If the user selects a file that isn't valid according to the filters setting.
	 *
	 * @property FILE_EXTENSION_ERROR
	 * @static
	 * @final
	 */
	FILE_EXTENSION_ERROR : -601,

	/**
	 * Duplicate file error. If prevent_duplicates is set to true and user selects the same file again.
	 *
	 * @property FILE_DUPLICATE_ERROR
	 * @static
	 * @final
	 */
	FILE_DUPLICATE_ERROR : -602,

	/**
	 * Runtime will try to detect if image is proper one. Otherwise will throw this error.
	 *
	 * @property IMAGE_FORMAT_ERROR
	 * @static
	 * @final
	 */
	IMAGE_FORMAT_ERROR : -700,

	/**
	 * While working on files runtime may run out of memory and will throw this error.
	 *
	 * @since 2.1.2
	 * @property MEMORY_ERROR
	 * @static
	 * @final
	 */
	MEMORY_ERROR : -701,

	/**
	 * Each runtime has an upper limit on a dimension of the image it can handle. If bigger, will throw this error.
	 *
	 * @property IMAGE_DIMENSIONS_ERROR
	 * @static
	 * @final
	 */
	IMAGE_DIMENSIONS_ERROR : -702,

	/**
	 * Mime type lookup table.
	 *
	 * @property mimeTypes
	 * @type Object
	 * @final
	 */
	mimeTypes : o.mimes,

	/**
	 * In some cases sniffing is the only way around :(
	 */
	ua: o.ua,

	/**
	 * Gets the true type of the built-in object (better version of typeof).
	 * @credits Angus Croll (http://javascriptweblog.wordpress.com/)
	 *
	 * @method typeOf
	 * @static
	 * @param {Object} o Object to check.
	 * @return {String} Object [[Class]]
	 */
	typeOf: o.typeOf,

	/**
	 * Extends the specified object with another object.
	 *
	 * @method extend
	 * @static
	 * @param {Object} target Object to extend.
	 * @param {Object..} obj Multiple objects to extend with.
	 * @return {Object} Same as target, the extended object.
	 */
	extend : o.extend,

	/**
	 * Generates an unique ID. This is 99.99% unique since it takes the current time and 5 random numbers.
	 * The only way a user would be able to get the same ID is if the two persons at the same exact milisecond manages
	 * to get 5 the same random numbers between 0-65535 it also uses a counter so each call will be guaranteed to be page unique.
	 * It's more probable for the earth to be hit with an ansteriod. You can also if you want to be 100% sure set the plupload.guidPrefix property
	 * to an user unique key.
	 *
	 * @method guid
	 * @static
	 * @return {String} Virtually unique id.
	 */
	guid : o.guid,

	/**
	 * Get array of DOM Elements by their ids.
	 * 
	 * @method get
	 * @for Utils
	 * @param {String} id Identifier of the DOM Element
	 * @return {Array}
	*/
	get : function get(ids) {
		var els = [], el;

		if (o.typeOf(ids) !== 'array') {
			ids = [ids];
		}

		var i = ids.length;
		while (i--) {
			el = o.get(ids[i]);
			if (el) {
				els.push(el);
			}
		}

		return els.length ? els : null;
	},

	/**
	 * Executes the callback function for each item in array/object. If you return false in the
	 * callback it will break the loop.
	 *
	 * @method each
	 * @static
	 * @param {Object} obj Object to iterate.
	 * @param {function} callback Callback function to execute for each item.
	 */
	each : o.each,

	/**
	 * Returns the absolute x, y position of an Element. The position will be returned in a object with x, y fields.
	 *
	 * @method getPos
	 * @static
	 * @param {Element} node HTML element or element id to get x, y position from.
	 * @param {Element} root Optional root element to stop calculations at.
	 * @return {object} Absolute position of the specified element object with x, y fields.
	 */
	getPos : o.getPos,

	/**
	 * Returns the size of the specified node in pixels.
	 *
	 * @method getSize
	 * @static
	 * @param {Node} node Node to get the size of.
	 * @return {Object} Object with a w and h property.
	 */
	getSize : o.getSize,

	/**
	 * Encodes the specified string.
	 *
	 * @method xmlEncode
	 * @static
	 * @param {String} s String to encode.
	 * @return {String} Encoded string.
	 */
	xmlEncode : function(str) {
		var xmlEncodeChars = {'<' : 'lt', '>' : 'gt', '&' : 'amp', '"' : 'quot', '\'' : '#39'}, xmlEncodeRegExp = /[<>&\"\']/g;

		return str ? ('' + str).replace(xmlEncodeRegExp, function(chr) {
			return xmlEncodeChars[chr] ? '&' + xmlEncodeChars[chr] + ';' : chr;
		}) : str;
	},

	/**
	 * Forces anything into an array.
	 *
	 * @method toArray
	 * @static
	 * @param {Object} obj Object with length field.
	 * @return {Array} Array object containing all items.
	 */
	toArray : o.toArray,

	/**
	 * Find an element in array and return it's index if present, otherwise return -1.
	 *
	 * @method inArray
	 * @static
	 * @param {mixed} needle Element to find
	 * @param {Array} array
	 * @return {Int} Index of the element, or -1 if not found
	 */
	inArray : o.inArray,

	/**
	 * Extends the language pack object with new items.
	 *
	 * @method addI18n
	 * @static
	 * @param {Object} pack Language pack items to add.
	 * @return {Object} Extended language pack object.
	 */
	addI18n : o.addI18n,

	/**
	 * Translates the specified string by checking for the english string in the language pack lookup.
	 *
	 * @method translate
	 * @static
	 * @param {String} str String to look for.
	 * @return {String} Translated string or the input string if it wasn't found.
	 */
	translate : o.translate,

	/**
	 * Checks if object is empty.
	 *
	 * @method isEmptyObj
	 * @static
	 * @param {Object} obj Object to check.
	 * @return {Boolean}
	 */
	isEmptyObj : o.isEmptyObj,

	/**
	 * Checks if specified DOM element has specified class.
	 *
	 * @method hasClass
	 * @static
	 * @param {Object} obj DOM element like object to add handler to.
	 * @param {String} name Class name
	 */
	hasClass : o.hasClass,

	/**
	 * Adds specified className to specified DOM element.
	 *
	 * @method addClass
	 * @static
	 * @param {Object} obj DOM element like object to add handler to.
	 * @param {String} name Class name
	 */
	addClass : o.addClass,

	/**
	 * Removes specified className from specified DOM element.
	 *
	 * @method removeClass
	 * @static
	 * @param {Object} obj DOM element like object to add handler to.
	 * @param {String} name Class name
	 */
	removeClass : o.removeClass,

	/**
	 * Returns a given computed style of a DOM element.
	 *
	 * @method getStyle
	 * @static
	 * @param {Object} obj DOM element like object.
	 * @param {String} name Style you want to get from the DOM element
	 */
	getStyle : o.getStyle,

	/**
	 * Adds an event handler to the specified object and store reference to the handler
	 * in objects internal Plupload registry (@see removeEvent).
	 *
	 * @method addEvent
	 * @static
	 * @param {Object} obj DOM element like object to add handler to.
	 * @param {String} name Name to add event listener to.
	 * @param {Function} callback Function to call when event occurs.
	 * @param {String} (optional) key that might be used to add specifity to the event record.
	 */
	addEvent : o.addEvent,

	/**
	 * Remove event handler from the specified object. If third argument (callback)
	 * is not specified remove all events with the specified name.
	 *
	 * @method removeEvent
	 * @static
	 * @param {Object} obj DOM element to remove event listener(s) from.
	 * @param {String} name Name of event listener to remove.
	 * @param {Function|String} (optional) might be a callback or unique key to match.
	 */
	removeEvent: o.removeEvent,

	/**
	 * Remove all kind of events from the specified object
	 *
	 * @method removeAllEvents
	 * @static
	 * @param {Object} obj DOM element to remove event listeners from.
	 * @param {String} (optional) unique key to match, when removing events.
	 */
	removeAllEvents: o.removeAllEvents,

	/**
	 * Cleans the specified name from national characters (diacritics). The result will be a name with only a-z, 0-9 and _.
	 *
	 * @method cleanName
	 * @static
	 * @param {String} s String to clean up.
	 * @return {String} Cleaned string.
	 */
	cleanName : function(name) {
		var i, lookup;

		// Replace diacritics
		lookup = [
			/[\300-\306]/g, 'A', /[\340-\346]/g, 'a',
			/\307/g, 'C', /\347/g, 'c',
			/[\310-\313]/g, 'E', /[\350-\353]/g, 'e',
			/[\314-\317]/g, 'I', /[\354-\357]/g, 'i',
			/\321/g, 'N', /\361/g, 'n',
			/[\322-\330]/g, 'O', /[\362-\370]/g, 'o',
			/[\331-\334]/g, 'U', /[\371-\374]/g, 'u'
		];

		for (i = 0; i < lookup.length; i += 2) {
			name = name.replace(lookup[i], lookup[i + 1]);
		}

		// Replace whitespace
		name = name.replace(/\s+/g, '_');

		// Remove anything else
		name = name.replace(/[^a-z0-9_\-\.]+/gi, '');

		return name;
	},

	/**
	 * Builds a full url out of a base URL and an object with items to append as query string items.
	 *
	 * @method buildUrl
	 * @static
	 * @param {String} url Base URL to append query string items to.
	 * @param {Object} items Name/value object to serialize as a querystring.
	 * @return {String} String with url + serialized query string items.
	 */
	buildUrl : function(url, items) {
		var query = '';

		plupload.each(items, function(value, name) {
			query += (query ? '&' : '') + encodeURIComponent(name) + '=' + encodeURIComponent(value);
		});

		if (query) {
			url += (url.indexOf('?') > 0 ? '&' : '?') + query;
		}

		return url;
	},

	/**
	 * Formats the specified number as a size string for example 1024 becomes 1 KB.
	 *
	 * @method formatSize
	 * @static
	 * @param {Number} size Size to format as string.
	 * @return {String} Formatted size string.
	 */
	formatSize : function(size) {

		if (size === undef || /\D/.test(size)) {
			return plupload.translate('N/A');
		}

		function round(num, precision) {
			return Math.round(num * Math.pow(10, precision)) / Math.pow(10, precision);
		}

		var boundary = Math.pow(1024, 4);

		// TB
		if (size > boundary) {
			return round(size / boundary, 1) + " " + plupload.translate('tb');
		}

		// GB
		if (size > (boundary/=1024)) {
			return round(size / boundary, 1) + " " + plupload.translate('gb');
		}

		// MB
		if (size > (boundary/=1024)) {
			return round(size / boundary, 1) + " " + plupload.translate('mb');
		}

		// KB
		if (size > 1024) {
			return Math.round(size / 1024) + " " + plupload.translate('kb');
		}

		return size + " " + plupload.translate('b');
	},


	/**
	 * Parses the specified size string into a byte value. For example 10kb becomes 10240.
	 *
	 * @method parseSize
	 * @static
	 * @param {String|Number} size String to parse or number to just pass through.
	 * @return {Number} Size in bytes.
	 */
	parseSize : o.parseSizeStr,


	/**
	 * A way to predict what runtime will be choosen in the current environment with the
	 * specified settings.
	 *
	 * @method predictRuntime
	 * @static
	 * @param {Object|String} config Plupload settings to check
	 * @param {String} [runtimes] Comma-separated list of runtimes to check against
	 * @return {String} Type of compatible runtime
	 */
	predictRuntime : function(config, runtimes) {
		var up, runtime;

		up = new plupload.Uploader(config);
		runtime = o.Runtime.thatCan(up.getOption().required_features, runtimes || config.runtimes);
		up.destroy();
		return runtime;
	},

	/**
	 * Registers a filter that will be executed for each file added to the queue.
	 * If callback returns false, file will not be added.
	 *
	 * Callback receives two arguments: a value for the filter as it was specified in settings.filters
	 * and a file to be filtered. Callback is executed in the context of uploader instance.
	 *
	 * @method addFileFilter
	 * @static
	 * @param {String} name Name of the filter by which it can be referenced in settings.filters
	 * @param {String} cb Callback - the actual routine that every added file must pass
	 */
	addFileFilter: function(name, cb) {
		fileFilters[name] = cb;
	}
};


plupload.addFileFilter('mime_types', function(filters, file, cb) {
	if (filters.length && !filters.regexp.test(file.name)) {
		this.trigger('Error', {
			code : plupload.FILE_EXTENSION_ERROR,
			message : plupload.translate('File extension error.'),
			file : file
		});
		cb(false);
	} else {
		cb(true);
	}
});


plupload.addFileFilter('max_file_size', function(maxSize, file, cb) {
	var undef;

	maxSize = plupload.parseSize(maxSize);

	// Invalid file size
	if (file.size !== undef && maxSize && file.size > maxSize) {
		this.trigger('Error', {
			code : plupload.FILE_SIZE_ERROR,
			message : plupload.translate('File size error.'),
			file : file
		});
		cb(false);
	} else {
		cb(true);
	}
});


plupload.addFileFilter('prevent_duplicates', function(value, file, cb) {
	if (value) {
		var ii = this.files.length;
		while (ii--) {
			// Compare by name and size (size might be 0 or undefined, but still equivalent for both)
			if (file.name === this.files[ii].name && file.size === this.files[ii].size) {
				this.trigger('Error', {
					code : plupload.FILE_DUPLICATE_ERROR,
					message : plupload.translate('Duplicate file error.'),
					file : file
				});
				cb(false);
				return;
			}
		}
	}
	cb(true);
});


/**
@class Uploader
@constructor

@param {Object} settings For detailed information about each option check documentation.
	@param {String|DOMElement} settings.browse_button id of the DOM element or DOM element itself to use as file dialog trigger.
	@param {String} settings.url URL of the server-side upload handler.
	@param {Number|String} [settings.chunk_size=0] Chunk size in bytes to slice the file into. Shorcuts with b, kb, mb, gb, tb suffixes also supported. `e.g. 204800 or "204800b" or "200kb"`. By default - disabled.
	@param {Boolean} [settings.send_chunk_number=true] Whether to send chunks and chunk numbers, or total and offset bytes.
	@param {String} [settings.container] id of the DOM element to use as a container for uploader structures. Defaults to document.body.
	@param {String|DOMElement} [settings.drop_element] id of the DOM element or DOM element itself to use as a drop zone for Drag-n-Drop.
	@param {String} [settings.file_data_name="file"] Name for the file field in Multipart formated message.
	@param {Object} [settings.filters={}] Set of file type filters.
		@param {Array} [settings.filters.mime_types=[]] List of file types to accept, each one defined by title and list of extensions. `e.g. {title : "Image files", extensions : "jpg,jpeg,gif,png"}`. Dispatches `plupload.FILE_EXTENSION_ERROR`
		@param {String|Number} [settings.filters.max_file_size=0] Maximum file size that the user can pick, in bytes. Optionally supports b, kb, mb, gb, tb suffixes. `e.g. "10mb" or "1gb"`. By default - not set. Dispatches `plupload.FILE_SIZE_ERROR`.
		@param {Boolean} [settings.filters.prevent_duplicates=false] Do not let duplicates into the queue. Dispatches `plupload.FILE_DUPLICATE_ERROR`.
	@param {String} [settings.flash_swf_url] URL of the Flash swf.
	@param {Object} [settings.headers] Custom headers to send with the upload. Hash of name/value pairs.
	@param {Number} [settings.max_retries=0] How many times to retry the chunk or file, before triggering Error event.
	@param {Boolean} [settings.multipart=true] Whether to send file and additional parameters as Multipart formated message.
	@param {Object} [settings.multipart_params] Hash of key/value pairs to send with every file upload.
	@param {Boolean} [settings.multi_selection=true] Enable ability to select multiple files at once in file dialog.
	@param {String|Object} [settings.required_features] Either comma-separated list or hash of required features that chosen runtime should absolutely possess.
	@param {Object} [settings.resize] Enable resizng of images on client-side. Applies to `image/jpeg` and `image/png` only. `e.g. {width : 200, height : 200, quality : 90, crop: true}`
		@param {Number} [settings.resize.width] If image is bigger, it will be resized.
		@param {Number} [settings.resize.height] If image is bigger, it will be resized.
		@param {Number} [settings.resize.quality=90] Compression quality for jpegs (1-100).
		@param {Boolean} [settings.resize.crop=false] Whether to crop images to exact dimensions. By default they will be resized proportionally.
	@param {String} [settings.runtimes="html5,flash,silverlight,html4"] Comma separated list of runtimes, that Plupload will try in turn, moving to the next if previous fails.
	@param {String} [settings.silverlight_xap_url] URL of the Silverlight xap.
	@param {Boolean} [settings.unique_names=false] If true will generate unique filenames for uploaded files.
	@param {Boolean} [settings.send_file_name=true] Whether to send file name as additional argument - 'name' (required for chunked uploads and some other cases where file name cannot be sent via normal ways).
*/
plupload.Uploader = function(options) {
	/**
	 * Fires when the current RunTime has been initialized.
	 *
	 * @event Init
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */

	/**
	 * Fires after the init event incase you need to perform actions there.
	 *
	 * @event PostInit
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */

	/**
	 * Fires when the option is changed in via uploader.setOption().
	 *
	 * @event OptionChanged
	 * @since 2.1
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {String} name Name of the option that was changed
	 * @param {Mixed} value New value for the specified option
	 * @param {Mixed} oldValue Previous value of the option
	 */

	/**
	 * Fires when the silverlight/flash or other shim needs to move.
	 *
	 * @event Refresh
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */

	/**
	 * Fires when the overall state is being changed for the upload queue.
	 *
	 * @event StateChanged
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */

	/**
	 * Fires when browse_button is clicked and browse dialog shows.
	 *
	 * @event Browse
	 * @since 2.1.2
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */	

	/**
	 * Fires for every filtered file before it is added to the queue.
	 * 
	 * @event FileFiltered
	 * @since 2.1
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file Another file that has to be added to the queue.
	 */

	/**
	 * Fires when the file queue is changed. In other words when files are added/removed to the files array of the uploader instance.
	 *
	 * @event QueueChanged
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */ 

	/**
	 * Fires after files were filtered and added to the queue.
	 *
	 * @event FilesAdded
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {Array} files Array of file objects that were added to queue by the user.
	 */

	/**
	 * Fires when file is removed from the queue.
	 *
	 * @event FilesRemoved
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {Array} files Array of files that got removed.
	 */

	/**
	 * Fires when just before a file is uploaded. This event enables you to override settings
	 * on the uploader instance before the file is uploaded.
	 *
	 * @event BeforeUpload
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file File to be uploaded.
	 */

	/**
	 * Fires when a file is to be uploaded by the runtime.
	 *
	 * @event UploadFile
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file File to be uploaded.
	 */

	/**
	 * Fires while a file is being uploaded. Use this event to update the current file upload progress.
	 *
	 * @event UploadProgress
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file File that is currently being uploaded.
	 */	

	/**
	 * Fires when file chunk is uploaded.
	 *
	 * @event ChunkUploaded
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file File that the chunk was uploaded for.
	 * @param {Object} response Object with response properties.
	 */

	/**
	 * Fires when a file is successfully uploaded.
	 *
	 * @event FileUploaded
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {plupload.File} file File that was uploaded.
	 * @param {Object} response Object with response properties.
	 */

	/**
	 * Fires when all files in a queue are uploaded.
	 *
	 * @event UploadComplete
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {Array} files Array of file objects that was added to queue/selected by the user.
	 */

	/**
	 * Fires when a error occurs.
	 *
	 * @event Error
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 * @param {Object} error Contains code, message and sometimes file and other details.
	 */

	/**
	 * Fires when destroy method is called.
	 *
	 * @event Destroy
	 * @param {plupload.Uploader} uploader Uploader instance sending the event.
	 */
	var uid = plupload.guid()
	, settings
	, files = []
	, preferred_caps = {}
	, fileInputs = []
	, fileDrops = []
	, startTime
	, total
	, disabled = false
	, xhr
	;


	// Private methods
	function uploadNext() {
		var file, count = 0, i;

		if (this.state == plupload.STARTED) {
			// Find first QUEUED file
			for (i = 0; i < files.length; i++) {
				if (!file && files[i].status == plupload.QUEUED) {
					file = files[i];
					if (this.trigger("BeforeUpload", file)) {
						file.status = plupload.UPLOADING;
						this.trigger("UploadFile", file);
					}
				} else {
					count++;
				}
			}

			// All files are DONE or FAILED
			if (count == files.length) {
				if (this.state !== plupload.STOPPED) {
					this.state = plupload.STOPPED;
					this.trigger("StateChanged");
				}
				this.trigger("UploadComplete", files);
			}
		}
	}


	function calcFile(file) {
		file.percent = file.size > 0 ? Math.ceil(file.loaded / file.size * 100) : 100;
		calc();
	}


	function calc() {
		var i, file;

		// Reset stats
		total.reset();

		// Check status, size, loaded etc on all files
		for (i = 0; i < files.length; i++) {
			file = files[i];

			if (file.size !== undef) {
				// We calculate totals based on original file size
				total.size += file.origSize;

				// Since we cannot predict file size after resize, we do opposite and
				// interpolate loaded amount to match magnitude of total
				total.loaded += file.loaded * file.origSize / file.size;
			} else {
				total.size = undef;
			}

			if (file.status == plupload.DONE) {
				total.uploaded++;
			} else if (file.status == plupload.FAILED) {
				total.failed++;
			} else {
				total.queued++;
			}
		}

		// If we couldn't calculate a total file size then use the number of files to calc percent
		if (total.size === undef) {
			total.percent = files.length > 0 ? Math.ceil(total.uploaded / files.length * 100) : 0;
		} else {
			total.bytesPerSec = Math.ceil(total.loaded / ((+new Date() - startTime || 1) / 1000.0));
			total.percent = total.size > 0 ? Math.ceil(total.loaded / total.size * 100) : 0;
		}
	}


	function getRUID() {
		var ctrl = fileInputs[0] || fileDrops[0];
		if (ctrl) {
			return ctrl.getRuntime().uid;
		}
		return false;
	}


	function runtimeCan(file, cap) {
		if (file.ruid) {
			var info = o.Runtime.getInfo(file.ruid);
			if (info) {
				return info.can(cap);
			}
		}
		return false;
	}


	function bindEventListeners() {
		this.bind('FilesAdded FilesRemoved', function(up) {
			up.trigger('QueueChanged');
			up.refresh();
		});

		this.bind('CancelUpload', onCancelUpload);
		
		this.bind('BeforeUpload', onBeforeUpload);

		this.bind('UploadFile', onUploadFile);

		this.bind('UploadProgress', onUploadProgress);

		this.bind('StateChanged', onStateChanged);

		this.bind('QueueChanged', calc);

		this.bind('Error', onError);

		this.bind('FileUploaded', onFileUploaded);

		this.bind('Destroy', onDestroy);
	}


	function initControls(settings, cb) {
		var self = this, inited = 0, queue = [];

		// common settings
		var options = {
			runtime_order: settings.runtimes,
			required_caps: settings.required_features,
			preferred_caps: preferred_caps,
			swf_url: settings.flash_swf_url,
			xap_url: settings.silverlight_xap_url
		};

		// add runtime specific options if any
		plupload.each(settings.runtimes.split(/\s*,\s*/), function(runtime) {
			if (settings[runtime]) {
				options[runtime] = settings[runtime];
			}
		});

		// initialize file pickers - there can be many
		if (settings.browse_button) {
			plupload.each(settings.browse_button, function(el) {
				queue.push(function(cb) {
					var fileInput = new o.FileInput(plupload.extend({}, options, {
						accept: settings.filters.mime_types,
						name: settings.file_data_name,
						multiple: settings.multi_selection,
						container: settings.container,
						browse_button: el
					}));

					fileInput.onready = function() {
						var info = o.Runtime.getInfo(this.ruid);

						// for backward compatibility
						o.extend(self.features, {
							chunks: info.can('slice_blob'),
							multipart: info.can('send_multipart'),
							multi_selection: info.can('select_multiple')
						});

						inited++;
						fileInputs.push(this);
						cb();
					};

					fileInput.onchange = function() {
						self.addFile(this.files);
					};

					fileInput.bind('mouseenter mouseleave mousedown mouseup', function(e) {
						if (!disabled) {
							if (settings.browse_button_hover) {
								if ('mouseenter' === e.type) {
									o.addClass(el, settings.browse_button_hover);
								} else if ('mouseleave' === e.type) {
									o.removeClass(el, settings.browse_button_hover);
								}
							}

							if (settings.browse_button_active) {
								if ('mousedown' === e.type) {
									o.addClass(el, settings.browse_button_active);
								} else if ('mouseup' === e.type) {
									o.removeClass(el, settings.browse_button_active);
								}
							}
						}
					});

					fileInput.bind('mousedown', function() {
						self.trigger('Browse');
					});

					fileInput.bind('error runtimeerror', function() {
						fileInput = null;
						cb();
					});

					fileInput.init();
				});
			});
		}

		// initialize drop zones
		if (settings.drop_element) {
			plupload.each(settings.drop_element, function(el) {
				queue.push(function(cb) {
					var fileDrop = new o.FileDrop(plupload.extend({}, options, {
						drop_zone: el
					}));

					fileDrop.onready = function() {
						var info = o.Runtime.getInfo(this.ruid);

						self.features.dragdrop = info.can('drag_and_drop'); // for backward compatibility

						inited++;
						fileDrops.push(this);
						cb();
					};

					fileDrop.ondrop = function() {
						self.addFile(this.files);
					};

					fileDrop.bind('error runtimeerror', function() {
						fileDrop = null;
						cb();
					});

					fileDrop.init();
				});
			});
		}


		o.inSeries(queue, function() {
			if (typeof(cb) === 'function') {
				cb(inited);
			}
		});
	}


	function resizeImage(blob, params, cb) {
		var img = new o.Image();

		try {
			img.onload = function() {
				// no manipulation required if...
				if (params.width > this.width &&
					params.height > this.height &&
					params.quality === undef &&
					params.preserve_headers &&
					!params.crop
				) {
					this.destroy();
					return cb(blob);
				}
				// otherwise downsize
				img.downsize(params.width, params.height, params.crop, params.preserve_headers);
			};

			img.onresize = function() {
				cb(this.getAsBlob(blob.type, params.quality));
				this.destroy();
			};

			img.onerror = function() {
				cb(blob);
			};

			img.load(blob);
		} catch(ex) {
			cb(blob);
		}
	}


	function setOption(option, value, init) {
		var self = this, reinitRequired = false;

		function _setOption(option, value, init) {
			var oldValue = set
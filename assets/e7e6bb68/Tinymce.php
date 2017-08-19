<?php
/**
 * Tinymce v4.0.21
 * Homepage: http://www.tinymce.com/
 * Examples: http://www.tinymce.com/tryit/basic.php
 * Options: http://www.tinymce.com/wiki.php/Configuration
 * 
 * Let Yii2 Tinymce v4.0.21 (Yii Framework 2.0 extention)
 * @copyright Copyright (c) 2014 Let.,ltd
 * @author Ngua Go <nguago@let.vn>, Mai Ba Duy <maibaduy@gmail.com>
 */

namespace letyii\tinymce;

use yii\helpers\Html;
use yii\helpers\Json;
use letyii\tinymce\TinymceAssets;

class Tinymce extends \yii\widgets\InputWidget
{
    public $id = '';
    public $content = '';
    public $configs = [];

    /**
	 * Initializes the widget.
	 */
	public function init() {
		TinymceAssets::register($this->view);
	}

	/**
	 * Renders the widget.
	 */
	public function run() {
        $this->options['id'] = empty($this->id) ? 'tinymce' . rand(0, 1000) : $this->id;
      #  $this->configs['selector'] = 'textarea#' . $this->options['id'];
		
		 $this->configs['mode'] = 'textareas';
		 $this->configs['plugins'] = "openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks";
		 
		$this->configs['theme_advanced_buttons1'] = "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect";

		$this->configs['theme_advanced_buttons2'] = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor";
		
		//$this->configs['theme_advanced_buttons3'] = "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen";
		// Theme options
		//$this->configs['theme_advanced_buttons4'] = "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks,|,openmanager";
		
	   $this->configs['theme_advanced_toolbar_location'] = 'top';
	   $this->configs['theme_advanced_toolbar_align'] = 'left';
	   $this->configs['theme_advanced_statusbar_location'] = 'bottom';
	   $this->configs['theme_advanced_resizing'] = 'true';
	   
	   $this->configs['file_browser_callback'] = 'openmanager';
	  # $this->configs['open_manager_upload_path'] = '../../../../../../files/';
	   $this->configs['open_manager_upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/files/';
	   
	   $this->configs['theme_advanced_resizing'] = 'true';
	   
	   $this->configs['content_css'] = ['http://31.130.202.166/css/screen_redactor.css'];
	   $this->configs['template_external_list_url'] = 'lists/template_list.js';
	   $this->configs['external_link_list_url'] = 'lists/link_list.js';
	   $this->configs['external_image_list_url'] = 'lists/image_list.js';
	   $this->configs['media_external_list_url'] = 'lists/media_list.js';
        $this->configs['width'] = '100%';
        $this->configs['height'] = '400px';

	/*
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}*/
			
		$this->getView()->registerJs('tinymce.init('. Json::encode($this->configs) .'); ');
        echo Html::activeTextarea($this->model, $this->attribute, $this->options);
		
	}
}

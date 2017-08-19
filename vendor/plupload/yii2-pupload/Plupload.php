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

namespace plupload\scripts;

use yii\helpers\Html;
use yii\helpers\Json;
use plupload\scripts\PluploadAssets;


class Plupload extends yii\base\Widget
{
    public $id = '';
    public $content = '';
    public $configs = [];

    /**
	 * Initializes the widget.
	 */
	public function init() {
		PluploadAssets::register($this->view);
	}

	/**
	 * Renders the widget.
	 */
	public function run() {
    
		#$this->getView()->registerJs(' ');

		
	}
}

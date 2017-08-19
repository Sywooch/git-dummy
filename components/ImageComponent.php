<?php
    namespace app\components;


    use Imagine\Filter\Transformation;
    use Imagine\Gd\Imagine;
    use Imagine\Image\Box;
    use Imagine\Image\BoxInterface;
    use Imagine\Image\ImageInterface;
    use Imagine\Image\ImagineInterface;
    use Imagine\Image\Point;
    use yii;
    use yii\base\Component;
    use yii\imagine\Image;

    class ImageComponent
    {

        public $previewpath     = '';
        public $filepath        = '';
        public $HttpPreviewPath = '';
        public $return_filename = 0;

        public function init()
        {
            $this->previewpath = \Yii::$app->basePath . '/files/preview/';
            $this->filepath = \Yii::$app->basePath . '/files/';
            $this->HttpPreviewPath = \Yii::$app->params['sitehost'] . 'files/preview/';
        }


        public function convertJpg($file)
        {

            $filePreview = str_replace('http://bountymart.com', '', $file);
            $file = $_SERVER['DOCUMENT_ROOT'] . $filePreview;

            if (!is_file(str_replace('.png', '.jpg', $file))) {
                /*$imagine = new Imagine();

                $imagine->open($file)
                        ->save(str_replace('.png','.jpg',$file));*/
                shell_exec(" convert " . $file . " -quality 75 " . str_replace('.png', '.jpg', $file) . "; ");
            }

            return str_replace('.png', '.jpg', $filePreview);
        }

        public function compress($file)
        {
            if(strstr($file,\Yii::$app->basePath))
                $file=$_SERVER['DOCUMENT_ROOT'].str_replace(\Yii::$app->basePath,'',$file);

            shell_exec(" convert " . $file . " -quality 75 " . $file . "; ");
        }

        public function customResizeWithFill($file, $width, $height, $owidth, $oheight)
        {
            $this->init();
            $filename = $this->getname($file);
            if (is_file(str_replace('.', '-original.', $filename)))
                $filename = str_replace('.', '-original.', $filename);

            $preview_filename = $this->getPreviewName($file, ['w' => $width, 'h' => $height]);
            @unlink($this->previewpath . $preview_filename);
            $imagine = new Imagine();


            $size = new Box($width, $height);
            $watermark = $imagine->open($this->filepath . $filename);// ->resize($size)->save($this->previewpath.'water'.$preview_filename);


            $watermark = $this->cuntomResize($file, $height, $height, 0, 'water' . $preview_filename);
            $sizeImage = getimagesize($watermark);
            if ($sizeImage[0] > $owidth || $sizeImage[0] > $oheight) {
                if ($sizeImage[0] > $owidth && $sizeImage[1] <= $oheight) {
                    $watermark = $this->cuntomResize($file, $owidth, $owidth, 0, 'water' . $preview_filename);
                } elseif ($sizeImage[0] <= $owidth && $sizeImage[1] > $oheight) {
                    $watermark = $this->cuntomResize($file, $oheight, $oheight, 1, 'water' . $preview_filename);
                }
                $sizeImage = getimagesize($watermark);
            }
            $watermark = $imagine->open($watermark);

            /* print_r($sizeImage);

             echo 'orig - '.$owidth.' '.$oheight.'<br>';

             echo $this->HttpPreviewPath.'water'.$preview_filename.'<br>';
             echo $this->HttpPreviewPath.$preview_filename.'<br>'; //321  221*/

            $size = new Box($owidth, $oheight);

            $offset[0] = (int)($owidth - $sizeImage[0]) / 2;
            if ($offset[0] < 0)
                $offset[0] = $offset[0] * -1;

            $offset[1] = (int)($oheight - $sizeImage[1]) / 2;
            if ($offset[1] < 0)
                $offset[1] = $offset[1] * -1;


            $bottomRight = new Point($offset[0], $offset[1]);


            $color = (yii::$app->request->get('color')) ? implode(',', self::hex2rgb(yii::$app->request->get('color'))) : '163,81,81';
            $imagine->create($size)->paste($watermark, $bottomRight)
                ->save($this->previewpath . $preview_filename);


            return $this->HttpPreviewPath . $preview_filename;

        }

        public static function hex2rgb($color)
        {
            if (!preg_match('/^#?(?P<color>\w{3}|\w{6})$/', $color, $match))
                return array(0, 0, 0);
            $mod = strlen($match['color']) / 3;
            foreach (str_split($match['color'], $mod) as $k => $v)
                $rgb[ $k ] = hexdec($mod == 2 ? $v : $v . $v);


            return $rgb;
        }

        //растягивает изображение по ширине
        public function cuntomResize($file, $width, $height, $byHeight = 0, $saveBy = '')
        {
            $this->init();
            $filename = $this->getname($file);
            if (is_file(str_replace('.', '-original.', $filename)))
                $filename = str_replace('.', '-original.', $filename);

            if (!$saveBy)
                $preview_filename = $this->getPreviewName($file, ['w' => $width, 'h' => $height]);
            else
                $preview_filename = $saveBy;


            @unlink($this->previewpath . $preview_filename);
            $imagine = new Imagine();


            $sizeImage = getimagesize($this->filepath . $filename);

            if ($byHeight == 0) {
                $deviationPercentage = (($sizeImage[0] - $width) / (0.01 * $sizeImage[0])) / 100;
                $newWidth = $width;
                $newHeight = $sizeImage[1] - ($sizeImage[1] * $deviationPercentage);
            } else {

                $deviationPercentage = (($sizeImage[1] - $height) / (0.01 * $sizeImage[1])) / 100;
                $newHeight = $height;
                $newWidth = $sizeImage[0] - ($sizeImage[0] * $deviationPercentage);
            }

            $size = new Box($newWidth, $newHeight);
            $imagine->open($this->filepath . $filename)->resize($size)->save($this->previewpath . $preview_filename);


            return $this->HttpPreviewPath . $preview_filename;

        }


//c пустым местом по бокам
        public function doResize($imageLocation, $imageDestination, Array $options = null)
        {
            $newWidth = $newHeight = 0;
            list($width, $height) = getimagesize($imageLocation);

            if (isset($options['newWidth']) || isset($options['newHeight'])) {
                if (isset($options['newWidth']) && isset($options['newHeight'])) {
                    $newWidth = $options['newWidth'];
                    $newHeight = $options['newHeight'];
                } else if (isset($options['newWidth'])) {
                    $deviationPercentage = (($width - $options['newWidth']) / (0.01 * $width)) / 100;

                    $newWidth = $options['newWidth'];
                    $newHeight = $height - ($height * $deviationPercentage);
                } else {
                    $deviationPercentage = (($height - $options['newHeight']) / (0.01 * $height)) / 100;

                    $newWidth = $width - ($width * $deviationPercentage);
                    $newHeight = $options['newHeight'];
                }
            } else {
                // reduce image size up to 20% by default
                $reduceRatio = isset($options['reduceRatio']) ? $options['reduceRatio'] : 20;

                $newWidth = $width * ((100 - $reduceRatio) / 100);
                $newHeight = $height * ((100 - $reduceRatio) / 100);
            }

            return Image::thumbnail(
                $imageLocation,
                (int)$newWidth,
                (int)$newHeight
            )->save(
                $imageDestination
            );
        }

        public function wresize($file, $width = '', $height = '', $orginal = false)
        {
            $this->init();

            $filename = $this->getname($file);

            if ($orginal === true)
                if (is_file(str_replace('.', '-original.', $filename)))
                    $filename = str_replace('.', '-original.', $filename);

            if (!is_file($this->filepath . $filename)) {
                return 'wresize no thound file';
            }

            if (empty($width) && empty($height))

                return $this->HttpPreviewPath . $filename;

            else

                $preview_filename = $this->getPreviewName($file, ['w' => $width, 'h' => $height]);


            if (is_file($this->previewpath . $preview_filename) && !$orginal) {
                return $this->HttpPreviewPath . $preview_filename;
            }

            $imagine = new Imagine();

            $size = new Box($width, $height);

            $mode = ImageInterface::THUMBNAIL_INSET;

            $imagine->open($this->filepath . $filename)->thumbnail($size, $mode)->save($this->previewpath . $preview_filename);


            return $this->HttpPreviewPath . $preview_filename;
        }


        public function crop($file, $width = '', $height = '', $orginal = false, $sex = 0, $fromFile = '')
        {
            $this->init();
            $filename = $this->getname($file);
            $preview_filename = str_replace('preview', 'preview-crop', $this->getPreviewName($file, ['w' => $width, 'h' => $height]));


            /*if( is_file($this->previewpath.$preview_filename) )
            {
                unlink($this->previewpath.$preview_filename);
            }*/


            if (is_file($this->previewpath . $preview_filename)) {

                //$this->compress($this->previewpath . $preview_filename);
                return $this->HttpPreviewPath . $preview_filename;
            }

            if (!is_file($this->filepath . $filename)) {
                return 'no thound file';
            }

            if ($fromFile)
                $imagine = (new Imagine())->open($this->filepath . '/preview/' . $file['id'] . $fromFile);
            else
                $imagine = (new Imagine())->open($this->filepath . $filename);

            $size = $imagine->getSize();


            $ratio_orig = $size->getWidth() / $size->getHeight();


            if ($width / $height > $ratio_orig) {
                $new_height = $width / $ratio_orig;
                $new_width = $width;
            } else {
                $new_width = $height * $ratio_orig;
                $new_height = $height;
            }


            /*  if($sex){
                  $new_width=$new_width+$sex;
                  $new_height=$new_height+$sex;
              }*/
            $box = new Box($new_width + $sex, $new_height + $sex);

            $point = new Point(($new_width - $width + $sex) / 2, ($new_height - $height + $sex) / 2);

            $imagine->resize($box);

            if ($height < $new_height)
                $box = new Box($new_width, $height);
            else
                $box = new Box($width, $new_height);


            $imagine->crop($point, $box)->save($this->previewpath . $preview_filename);

            $this->compress($this->HttpPreviewPath . $preview_filename);
            return $this->HttpPreviewPath . $preview_filename;
        }


        public function hresize($file, $width = '', $height = '', $orginal = false)
        {
            $this->init();
            $filename = $this->getname($file);
            $preview_filename = $this->getPreviewName($file, ['w' => $width, 'h' => $height]);

            if ($orginal === true) {
                if (is_file(str_replace('.', '-original.', $filename)))
                    $filename = str_replace('.', '-original.', $filename);


            }

            if (is_file($this->previewpath . $preview_filename) && !$orginal) {
                return $this->HttpPreviewPath . $preview_filename;
            }


            if (!is_file($this->filepath . $filename)) {
                return 'hresize no thound file ' . $this->filepath . $filename;
            }

            $imagine = (new Imagine())->open($this->filepath . $filename);

            $size = $imagine->getSize();


            $ratio_orig = $size->getWidth() / $size->getHeight();

            if ($width / $height > $ratio_orig) {
                $new_height = $width / $ratio_orig;
                $new_width = $width;
            } else {
                $new_width = $height * $ratio_orig;
                $new_height = $height;
            }

            $box = new Box($new_width, $new_height);

            $point = new Point(($new_width - $width) / 2, ($new_height - $height) / 2);

            $imagine->resize($box)->save($this->previewpath . $preview_filename);

            return $this->HttpPreviewPath . $preview_filename;
        }


        public function adaptive($file, $width = '', $height = '', $orginal = false)
        {
            $this->init();
            $filename = $this->getname($file);


            $preview_filename = $this->getPreviewName($file, ['w' => $width, 'h' => $height]);


            if (is_file($this->previewpath . $preview_filename) && !$orginal) {

                return $this->HttpPreviewPath . $preview_filename;
            }


            if (!is_file($this->filepath . $filename)) {
                return 'adaptive no thound file';
            }

            $imagine = (new Imagine())->open($this->filepath . $filename);

            $size = $imagine->getSize();


            if ($width == '') {
                return '/files/' . $filename;
            } elseif ($size->getWidth() > $size->getHeight()) {
                return $this->wresize($file, $width, $height, $orginal);
            } else {
                return $this->hresize($file, $width, $height, $orginal);
            }


        }


        public function getname($file)
        {
            return $file['id'] . '-' . $file['hash_code'] . '.' . $file['extension'];
        }

        public function getPreviewName($file, $params = '')
        {
            $postfix = '';
            if (is_array($params)) {
                foreach ($params as $f => $v)
                    $postfix .= '-' . $f . $v;
            }

            return $file['id'] . '-preview' . $postfix . '.' . $file['extension'];
        }

        public function delete_files($file)
        {
            $this->init();

            $filename = $this->getname($file);

            if (is_file($this->filepath . $filename)) {
                unlink($this->filepath . $filename);
            }

            foreach (glob("$this->previewpath" . $file['id'] . "*") as $findfile) {
                unlink($findfile);
            }

        }

        public function delete_preview_files($file)
        {
            $this->init();

            foreach (glob("$this->previewpath" . $file['id'] . "*") as $findfile) {
                unlink($findfile);
            }

        }
    }


<?php
    /**
     * @link http://www.yiiframework.com/
     * @copyright Copyright (c) 2008 Yii Software LLC
     * @license http://www.yiiframework.com/license/
     */

    namespace app\components;

    use Yii;
    use yii\base\Component;
    use yii\base\ErrorHandler;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\base\Model;
    use \yii\widgets\ActiveField as YAF;

    /**
     * ActiveField represents a form input field within an [[ActiveForm]].
     *
     * @author Qiang Xue <qiang.xue@gmail.com>
     * @since 2.0
     */
    class ActiveField  extends YAF
    {

        public function error($options = [])
        {

           if ($options === false) {
                $this->parts['{error}'] = '';
                return $this;
            }
            $options = array_merge($this->errorOptions, $options);
            $this->parts['{error}'] = Html::error($this->model, $this->attribute, $options);

            return $this;
        }


    }

<?php
 namespace app\components;

 use Yii;
 use yii\db\ActiveQuery;

trait LanguageTrate
{


    public function lang($language = null)
    {
        if (!$language)
            $language = Yii::$app->language;

        $this->with(['translation' => function ($query) use ($language) {
            $query->where([$this->languageField => substr($language, 0, 2)]);
        }]);
        return $this;
    }


}
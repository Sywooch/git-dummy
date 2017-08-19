<?php

    namespace app\components\behaviors;

    use yii;
    use yii\base\Behavior;
    use yii\db\ActiveRecord;
    use yii\helpers\Inflector;

    class Language extends Behavior
    {

        public $index='';
        public $table=0;
        public $fields=[];

        public function events()
        {
            return [

                ActiveRecord::EVENT_AFTER_INSERT   => 'Insert',
                ActiveRecord::EVENT_AFTER_UPDATE   => 'Update',
                ActiveRecord::EVENT_BEFORE_DELETE  => 'DelAll',
                ActiveRecord::EVENT_AFTER_FIND     => 'afterFind',

            ];
        }


        public function afterFind(){

            $owner = $this->owner;
            if((int)$owner->langid > 0 && yii::$app->user->getId() != 1){
                $owner->setAttribute($this->index, $owner->langid);
            }
        }

        public function Insert()
        {

            \yii::$app->language='ru';

              if($this->owner->lang) return;
              $id=$this->getIndex();
              if($id){
                  foreach(\app\components\widgets\Language::getLangs() as $lang){
                      $post = yii::$app->request->post();
                      if(isset($post[$lang])){
                         $model = new $this->owner;
                            if ($model->load($post[$lang])) {
                                $model->lang=$lang;
                                $model->langid=$id;

                                $model = $this->updateAttribute($model);
                            }
                      }
                  }
              }
        }

        public function updateAttribute($model){

            \yii::$app->language='ru';

            if(!$model->validate())
                foreach($model->getErrors() as $field=>$r){
                    $model->{$field} = $this->owner->{$field};
                }

            foreach($this->fields as $field){
                $model->{$field} = $this->owner->{$field};
            }


            if($model->validate())
                $model->save();
            else{
                print_r($model->getErrors());
            }
        }

        public function Update()
        {

            \yii::$app->language='ru';
            if($this->owner->lang) return;
            $id=$this->getIndex();

           // print_r($_POST);
            if($id){
                foreach(\app\components\widgets\Language::getLangs() as $lang){
                    $post = yii::$app->request->post();

                    if(isset($post[$lang])){

                        $model = $this->owner->find()->where('langid = '.$id.' and lang="'.$lang.'"')->one();

                        if($model === null)
                            $model = new $this->owner;

                        if ($model->load($post[$lang])) {
                            $model->lang=$lang;
                            $model->langid=$id;

                            $model = $this->updateAttribute($model);
                        }
                    }
                }
            }
        }

        public function DelAll(  )
        {
            \Yii::$app->db->createCommand()->delete($this->table,['langid'=>$this->getIndex() ])->execute();
        }

        public function getIndex(){
            return $this->owner->{$this->index};
        }


    }
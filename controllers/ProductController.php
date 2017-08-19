<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Catalog;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;
use yii\web\Response;

class ProductController extends BaseController
{



    public function actionView($url)
    {
	   $url=Catalog::urlPrefix().$url.'.html';	

        if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1){

	        $model = Catalog::find()->andWhere([ 'catalog_url' =>$url ] )->one();
          /*  if(\yii::$app->request->get('lang') == 'en'){
                $model = Catalog::find()->where([ 'langid' =>$model->catalog_id,'lang'=>'en' ] )->one();
            }*/

        }
        else
            $model = Catalog::find()->andWhere([ 'catalog_url' =>$url,'catalog_public'=>1 ] )->one();

        if(!$model)
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

	   \app\modules\seo\models\Seo::makeHead($model);

        $model->catalog_look++;
        $model->ForLangSave(['catalog_look'=>$model->catalog_look],$model->catalog_id);

        //$model->ForLangSave();

               if($model->terms->terms_parent !=0){
            $terms = Terms::find()->where('terms_id = '.$model->terms->terms_parent)->one();
            $this->breadcrumbs[]= ['label' => $terms->terms_text, 'url' => $terms->terms_url ];
        }

        $this->breadcrumbs[]= ['label' => $model->terms->terms_text, 'url' => $model->terms->terms_url ];
        $this->breadcrumbs[]= ['label' => $model->catalog_name];

        if($model->iszoomer)
            return $this->render('view-zoom', ['data' => $model,  'breadcrumbs' => $this->breadcrumbs ]);
	   return $this->render('view', ['data' => $model,  'breadcrumbs' => $this->breadcrumbs ]);
    }

    public function actionZoomer($id)
    {

        $model = Catalog::find()->Where([ 'catalog_id' =>$id ] )->one();

        $temp = Catalog::find()->andWhere([ 'langid' =>$id ] )->one();
        if($temp)
            $model=$temp;

        if(!$model)
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

        echo $this->renderPartial('_zoom', ['data' => $model ]);
        exit;
    }
	
	
	 public function actionList($url='')
    {
        $query = Catalog::find();
		if($url){
            $terms = Terms::getId($url, 1);

            $inner_cats = Terms::getTreeIn(1,$terms->terms_id,1);
            $inner_cats[]=$terms->terms_id;
            if($inner_cats)
            $query->andWhere(['catalogcatid'=>$inner_cats ]);
            if($terms == null)       throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

            $breadcrumbs = Terms::getTree($terms,'',true);

            if(count($breadcrumbs) == 1)
                $this->breadcrumbs[]= ['label' => $terms->terms_text];
            else
            {
                $this->breadcrumbs=$breadcrumbs;
                unset($this->breadcrumbs[1]);
                $this->breadcrumbs[]= ['label' => $terms->terms_text];
            }
            $label=$terms->terms_text;
			}
		else{
            $this->breadcrumbs[]= ['label' => \yii::t('app','Все')];
            $label= \yii::t('app','Все');
        }



        if($order = \yii::$app->request->get('order')){
            if(in_array($order,['hot.desc','popular.desc','timeend.desc'/*,'catalog_date.desc'*/])){
                $order=explode('.',$order);
                //$query->andWhere($order[0].' = 1');
                    if(/*$order[0]=='hot' ||*/ $order[0]=='popular')
                    $query->orderBy($order[0].' DESC');
                    elseif($order[0]=='hot' )
                        $query->orderBy(  '  persent DESC ');
            }else{
                $query->orderBy('catalog_date DESC');
            }
        }else{
            $query->orderBy('catalog_date DESC');
        }

        if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1) {
            $query->andWhere('  catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
        }else{
            $query->andWhere(' catalog_public = 1 and catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
        }



        \app\modules\seo\models\Seo::makeHead($terms);//  throw new \yii\web\HttpException(404, 'The requested Item could not be found.');



	  return $this->out($query, $label);
    }

    public function actionSearch($url='')
    {

        $query = Catalog::find();

        $this->breadcrumbs[]= ['label' => \yii::t('app','Результаты')];
        $label=\yii::t('app','Поиск').' - '.\yii::$app->request->get('key');

        if(\yii::$app->request->get('key')){

            if(\yii::$app->request->get('indesc') == 1)
                $query->andWhere(' (catalog_name LIKE "%'.\yii::$app->request->get('key').'%" or catalog_text LIKE "%'.\yii::$app->request->get('key').'%") ');
            else
                $query->andWhere(' catalog_name LIKE "%'.\yii::$app->request->get('key').'%" ');
        }


        if(\yii::$app->request->get('subcatid') )
            $query->andWhere(' catalogcatid = '.\yii::$app->request->get('subcatid').' ');
        elseif(\yii::$app->request->get('catid') ) {
            $inner_cats = Terms::getTreeIn(1,\yii::$app->request->get('catid'),1);
            $inner_cats[]=\yii::$app->request->get('catid');
            if($inner_cats)
                $query->andWhere(['catalogcatid'=>$inner_cats ]);
        }

        if($order = \yii::$app->request->get('order')){
            if(in_array($order,['hot.desc','popular.desc','timeend.desc'/*,'catalog_date.desc'*/])){
                $order=explode('.',$order);
                $query->andWhere($order[0].' = 1');

            }
        }


        if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1) {
            $query->andWhere('  catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
        }else{
            $query->andWhere(' catalog_public = 1 and catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
        }



        $query->orderBy(['catalog_date' => SORT_DESC]);


        //\app\modules\seo\models\Seo::makeHead($terms);//  throw new \yii\web\HttpException(404, 'The requested Item could not be found.');



        return $this->out($query, $label,'search');
    }

    public function actionSubcat(){
        if(\yii::$app->request->isPost && $catid = \yii::$app->request->post('catid')){
            $items = \app\modules\terms\models\Terms::dropDown_children(1,$catid);

            if(is_array($items)){
                foreach($items as $id=>$item){
                    echo '<li><a href="#" class="select-link" onclick="'."$('#search-subcatid').val($id);
                                    $(this).parent('li').parent('ul').parent('div').find('.filter-selected').html('$item');".'">'.$item.'</a></li>';
                }

            }
            exit;
        }

    }




    public function actionTypethread(){
        if(\yii::$app->request->isPost && $key = \yii::$app->request->post('key')){

            $query = Catalog::find();
            $query->andWhere(' catalog_name LIKE "%'.$key.'%"');

            if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1) {
                $query->andWhere('  catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
            }else{
                $query->andWhere(' catalog_public = 1 and catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  ');
            }


            $rows = $query->orderBy(['catalog_date' => SORT_DESC])->limit(3)->all();
            return $this->renderPartial('_list_type',  [ 'models'=>$rows   ]);
            //return  ;
            exit;
        }

    }

    public function actionAjaxpopular(){
        if(\yii::$app->request->isAjax){
            $limit =18;
            $query = Catalog::find();
            $not='';
            if(preg_match('/[0-9\,]+$/',\yii::$app->request->get('not')))
                 $not = ' and langid not in('.\yii::$app->request->get('not').') and catalog_id NOT IN('.\yii::$app->request->get('not').')';


            if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1) {
                $query->andWhere('  catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  '.$not);
            }else{
                $query->andWhere(' catalog_public = 1 and catalog_count > 0 and catalog_dateend > "' . date("Y-m-d H:i:s") . '"  '.$not);
            }


            $query->orderBy(['catalog_look' => SORT_DESC]);

            $countQuery = clone $query;
            $count = $countQuery->count();
            $pages = new Pagination(['totalCount' => $count,'pageSize'=>$limit]);

            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();


            if( ceil($count/$limit)>=\yii::$app->request->get('page'))
                echo $this->renderPartial('popular_index',  [ 'data'=>$models   ]);
            exit;
        }
        echo 'not ajax';
    }

    public function actionMorereviews($id){
        if(\yii::$app->request->isAjax){
            $model = Catalog::find()->andWhere([ 'catalog_id' =>(int)$id ] )->one();
            if(!$model)
                throw new \Exception('Нет такой страницы');

            echo $this->renderPartial('_ajax_review_list',  [ 'model'=>$model,'max'=>\yii::$app->request->get('page')   ]);
            exit;
        }
        echo 'not ajax';
    }

    public function out($query,$label, $tpl='list'){
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>\yii::$app->request->get('per-page',12)]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render($tpl,  ['pages'=>$pages,'breadcrumbs'=> $this->breadcrumbs, 'models'=>$models,'label'=>$label  ]);
    }
	
}
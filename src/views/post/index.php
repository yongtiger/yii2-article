<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $searchModel yongtiger\article\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('message', 'Posts');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('message', 'Create Post'), ['create', 'category_id' => $this->params['categoryId']], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'title',
            'summary',

            ///[post search]Test!
            ///'content_id',
            // [
            //     'attribute' => 'content_body',
            //     'label' => 'Content Body',
            //     'value' => function($model){
            //         return is_object($model->content)?$model->content->body:null;
            //     },
            // ],

            // 'user_id',
            // 'status',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {  ///[v0.3.2 (#ADD category layout)]
                    return [$action, 'id' => $key, 'category_id' => $model->category_id];
                }
            ],
        ],
    ]); ?>

</div>
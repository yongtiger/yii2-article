<?php

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yongtiger\article\Module;
use yongtiger\category\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel yongtiger\article\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name;

$label = ($category = Category::findOne($this->params['categoryId'])) ? $category->name : Module::t('message', 'Posts');
$this->params['breadcrumbs'][] = [
    'label' => $label, 
    'url' => ['index', 'category_id' => $this->params['categoryId']]
];
$this->title = $label . ' - ' . $this->title;

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
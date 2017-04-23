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

    <div class="col-sm-3">

        <?php ///[v0.3.0 (#ADD category)]
            // // echo \yii\widgets\Menu::widget([
            // // echo \yii\jui\Menu::widget([
            // // echo \yii\bootstrap\Nav::widget([
            // echo \yongtiger\listgroupmenu\widgets\ListGroupMenu::widget([
            //     // 'tag' => 'div',
            //     'items' => $menuItems,
            //     // 'options' => ['id' => 'yii2doc'],   // optional
            //     'activateParents' => true,  // optional
            // ]);

            echo \yongtiger\bootstraptree\widgets\BootstrapTree::widget([
                'options'=>[
                    //https://github.com/jonmiles/bootstrap-treeview#options
                    'data' => $menuItems,   ///(needed!)
                    'enableLinks' => true,  ///(optional)
                    'showTags' => true, ///(optional)
                    'levels' => 3,  ///(optional)
                    // 'multiSelect' => true,  ///(optional, but when `selectParents` is true, you must also set this to true!)
                ],
                // 'htmlOptions' => [  ///(optional)
                //     'id' => 'treeview-tabs',
                // ],
                // 'events'=>[ ///(optional)
                //     //https://github.com/jonmiles/bootstrap-treeview#events
                //     'onNodeSelected'=>'function(event, data) {
                //         // Your logic goes here
                //         alert(data.text);
                //     }'
                // ],

                ///(needed for using jonmiles bootstrap-treeview 2.0.0, must specify it as `<a href="{href}">{text}</a>`)
                // 'textTemplate' => '<a href="{href}">{text}</a>',

                ///(optional) Note: when it is true, you must also set `multiSelect` of the treeview widget options to true!
                // 'selectParents' => true,
            ]); 
            ///[http://www.brainbook.cc]
        ?>

    </div>
    <div class="col-sm-9">

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Module::t('message', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
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
</div>

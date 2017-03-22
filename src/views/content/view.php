<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Content */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Content', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Content'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'body:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerAttachment->totalCount){
    $gridColumnAttachment = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'attachmentType.id',
                'label' => 'Attachment Type'
            ],
            'attachment_upload_id',
            [
                'attribute' => 'user.username',
                'label' => 'User'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAttachment,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-attachment']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Attachment'),
        ],
        'export' => false,
        'columns' => $gridColumnAttachment
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerPost->totalCount){
    $gridColumnPost = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'category.name',
                'label' => 'Category'
            ],
            'title',
            'description',
                        [
                'attribute' => 'user.username',
                'label' => 'User'
            ],
            'count',
            'status',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerPost,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-post']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Post'),
        ],
        'export' => false,
        'columns' => $gridColumnPost
    ]);
}
?>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */
/* @var $postModelClassName string */

$this->title = $postModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$postModelClassName = $postModel->className();

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $postModel->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Delete', ['delete', 'id' => $postModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); ?>
    </p>

    <?= DetailView::widget([
        'model' => $postModel,
        'attributes' => [
            'id',
            'category_id',
            'title',
            'summary', ///?????'summary:html',
            [
                'label'=>'正文',
                'format'=>'raw',    ///@see http://www.yiiframework.com/doc-2.0/guide-output-formatting.html#other
                'value'=>$postModel->content->body,
            ],
            [
                'label'=>'用户名',
                'value'=>$postModel->user->username,
            ],
            [
                'label'=>'状态',
                'value'=>[
                    $postModelClassName::STATUS_DELETE => 'STATUS_DELETE',
                    $postModelClassName::STATUS_MODERATE => 'STATUS_MODERATE',
                    $postModelClassName::STATUS_ACTIVE => 'STATUS_ACTIVE',
                ][$postModel->status]
            ],
            'created_at',
            'updated_at',
        ],
    ]); ?>

</div>

<!--///[yongtiger/yii2-comment]-->
<?php 
echo \yongtiger\comment\widgets\Comment::widget([
    'model' => $postModel,
    'dataProviderConfig' => [
        'pagination' => [
            // 'pageParam' => 'comment-page',
            // 'pageSizeParam' => 'comment-per-page',
            'pageSize' => 3,
            // 'pageSizeLimit' => [1, 50],
        ],
    ],
    'sort' => 'created-at-asc',
]);

///[v0.1.3 (ADD# yongtiger\comment\behaviors)]///[v0.1.4 (CHG# comment sort)]
// echo $postModelClassName::findOne(5)->displayComment(
//     [
//         'dataProviderConfig' => [
//             'pagination' => [
//                 // 'pageParam' => 'comment-page',
//                 // 'pageSizeParam' => 'comment-per-page',
//                 'pageSize' => 5,
//                 // 'pageSizeLimit' => [1, 50],
//             ],
//         ],
//         'sort' => 'created-at-asc',
//     ],
// );
?>

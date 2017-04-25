<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */
/* @var $postModelClassName string */

$this->title = $postModel->title;
if ($postModel->category_id) {
    $this->params['breadcrumbs'][] = ['label' => Module::t('message', 'Post Category: ') . $postModel->category->name, 'url' => ['index', 'category_id' => $postModel->category_id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => Module::t('message', 'Posts'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;

$postModelClassName = $postModel->className();

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Module::t('message', 'Update'), ['update', 'id' => $postModel->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Module::t('message', 'Delete'), ['delete', 'id' => $postModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('message', 'Are you sure you want to delete this item?'),
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
                'label' => Module::t('message', 'Content'),
                'format' => 'raw',    ///@see http://www.yiiframework.com/doc-2.0/guide-output-formatting.html#other
                'value' => $postModel->content->body,
            ],
            [
                'label' => Module::t('message', 'Username'),
                'value' => $postModel->user->username,
            ],
            [
                'label' => Module::t('message', 'Status'),
                'value' => [
                    $postModelClassName::STATUS_DELETE => Module::t('message', 'STATUS_DELETE'),
                    $postModelClassName::STATUS_MODERATE => Module::t('message', 'STATUS_MODERATE'),
                    $postModelClassName::STATUS_ACTIVE => Module::t('message', 'STATUS_ACTIVE'),
                ][$postModel->status]
            ],
            'created_at:date',
            'updated_at:date',
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

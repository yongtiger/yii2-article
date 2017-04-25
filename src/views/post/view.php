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

<?php ///[v0.3.5 (#ADD displayCommentCallback)]
    if (is_callable($displayCommentCallback = Module::instance()->displayCommentCallback)) {
        echo call_user_func($displayCommentCallback, $postModel);
    }
?>

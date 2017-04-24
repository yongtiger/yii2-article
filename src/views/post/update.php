<?php

use yii\helpers\Html;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */

$this->title = Module::t('message', 'Update Post: ') . $postModel->title;
// $this->params['breadcrumbs'][] = ['label' => Module::t('message', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('message', 'Post Category: ') . $postModel->category->name, 'url' => ['index', 'category_id' => $postModel->category_id]];
$this->params['breadcrumbs'][] = ['label' => $postModel->title, 'url' => ['view', 'id' => $postModel->id]];
$this->params['breadcrumbs'][] = Module::t('message', 'Update');

?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'postModel' => $postModel,
        'contentModel' => $contentModel,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */

$this->title = 'Update Post: ' . $postModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $postModel->title, 'url' => ['view', 'id' => $postModel->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'postModel' => $postModel,
        'contentModel' => $contentModel,
    ]) ?>

</div>

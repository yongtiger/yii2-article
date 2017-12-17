<?php

use yii\helpers\Html;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */

$this->title = Yii::$app->name;

$label = $postModel->category ? $postModel->category->name : Module::t('message', 'Posts');
$this->params['breadcrumbs'][] = [
    'label' => $label, 
    'url' => ['index', 'category_id' => $postModel->category_id]
];
$this->title = $label . ' - ' . $this->title;

$this->params['breadcrumbs'][] = Module::t('message', 'Create Post');
$this->title = Module::t('message', 'Create Post') . ' - ' . $this->title;

?>
<div class="post-create">

    <?= $this->render('_form', [
        'postModel' => $postModel,
        'contentModel' => $contentModel,
    ]) ?>

</div>

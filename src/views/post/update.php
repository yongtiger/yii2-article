<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
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

$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($postModel->title, 100), 'url' => ['view', 'id' => $postModel->id]];
$this->title = StringHelper::truncate($postModel->title, 100) . ' - ' . $this->title;

$this->params['breadcrumbs'][] = Module::t('message', 'Update Post');
$this->title = Module::t('message', 'Update Post') . ' - ' . $this->title;

?>
<div class="post-update">

    <?= $this->render('_form', [
        'postModel' => $postModel,
        'contentModel' => $contentModel,
    ]) ?>

</div>

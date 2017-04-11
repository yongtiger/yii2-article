<?php

use yii\helpers\Html;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */

$this->title = Module::t('message', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Module::t('message', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'postModel' => $postModel,
        'contentModel' => $contentModel,
    ]) ?>

</div>

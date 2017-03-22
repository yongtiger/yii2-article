<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post_model yongtiger\article\models\Post */
/* @var $content_model yongtiger\article\models\Content */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <!---///[yii2-brainblog_v0.5.1_f0.5.0_post_content_multiple_model]-->
    <?= $this->render('_form', [
        'post_model' => $post_model,
        'content_model' => $content_model,
    ]) ?>

</div>

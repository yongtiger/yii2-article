<?php
///[yii2-brainblog_v0.11.0_f0.10.1_post_search]
use yii\helpers\Html;
?>

<div class="post-search">

    <?= Html::beginForm(['index'], 'get'); ?>

    <?= Html::textInput('PostSearch[keywords]') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?= Html::endForm(); ?>

</div>
<!-- ///[http://www.brainbook.cc] -->
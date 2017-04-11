<?php
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

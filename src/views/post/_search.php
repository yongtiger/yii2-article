<?php
use yii\helpers\Html;
use yongtiger\article\Module;

?>
<div class="post-search">

    <?= Html::beginForm(['index'], 'get'); ?>

    <?= Html::textInput('PostSearch[keywords]') ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('message', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Module::t('message', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?= Html::endForm(); ?>

</div>

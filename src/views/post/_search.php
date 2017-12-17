<?php
use yii\helpers\Html;
use yongtiger\article\Module;

?>
<div class="post-search">

    <?= Html::beginForm(['index', 
    	'category_id' => isset($this->params['categoryId']) ? $this->params['categoryId'] : ''
    ], 'get'); ?>
		<div class="form-group">
	    	<?= Html::textInput('PostSearch[keywords]') ?>
	        <?= Html::submitButton(Module::t('message', 'Search'), ['class' => 'btn btn-primary']) ?>
	        <?= Html::resetButton(Module::t('message', 'Reset'), ['class' => 'btn btn-default']) ?>
	    </div>
    <?= Html::endForm(); ?>

</div>

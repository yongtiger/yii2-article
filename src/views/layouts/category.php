<?php ///[v0.3.2 (#ADD category layout)]

use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $menuItems array */

///[v0.3.4 (#ADD generateCategoryCallback, displayCategoryCallback)]
$menuItems = call_user_func(Module::instance()->generateCategoryCallback, $this);

$this->beginContent(Module::instance()->layout); ?>

<div class="col-sm-3">

    <?= call_user_func(Module::instance()->displayCategoryCallback, $menuItems) ?>

</div>
<div class="col-sm-9">

	<?= call_user_func([isset($this->params['alertClassName']) ? $this->params['alertClassName'] : 'common\\widgets\\Alert', 'widget']); ?>

	<?= $content ?>

</div>

<?php $this->endContent(); ?>
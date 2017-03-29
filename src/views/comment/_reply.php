<?php ///[comment reply]

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */
/* @var $form yii\widgets\ActiveForm */
/* @var $key ///?????? */

///[toggle show/hide]
$this->registerJs(
<<<JS
$("#comment-reply-'.$key.'").click(function(){
	$("#comment-form-'.$key.'").toggle(300);	///animation duration
	return false;
});
JS
);

?>
<div class="comment-reply">

    <?= HtmlPurifier::process($commentModel->text) ?>
    
    <a id="comment-reply-<?= $key ?>" href="javascript:void(0);">回复</a><!--///[toggle show/hide]-->

    <!--///[comment vote]-->
    <a href="javascript:void(0);" onclick="vote(<?= $key ?>, 1)">顶</a>
    <a href="javascript:void(0);" onclick="vote(<?= $key ?>, -1)">踩</a>

	<div id="comment-form-<?= $key ?>" style="display:none;">

		<?php $form = ActiveForm::begin(
		    [
		        'method' => 'post',
		        /// 'action' => ['create-comment'], ///Note: Can not have page redirect jumps! Such as form action, js redirect.
		        'options' => ['data-pjax' => true]	///ListView with Pjax
		    ]
		); ?>

	    <?= $form->field($commentModel, 'parent_id')->hiddenInput(['value' => $key])->label(false) ?>

	    <?= $form->field($commentModel, 'post_id')->hiddenInput(['value' => $postModel->id])->label(false) ?>

		<?= $form->field($commentModel, 'text')->textarea(['placeholder'=>'您也来评论吧！', 'rows' => 3])->label(false) ?>

	    <div class="form-group">
	        <?= Html::submitButton('回复', ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>

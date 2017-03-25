<?php
///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]ListView嵌套的item页面
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>
<div class="comment-view">
    <?= HtmlPurifier::process($model->text) ?>
    <!--///切换显示/隐藏回复评论-->
    <a id="comment-reply-<?= $key ?>" href="javascript:void(0);">回复</a>

    <!--///[yii2-brainblog_v0.10.2_f0.10.1_post_comment_vote]-->
    <a href="javascript:void(0);" onclick="vote(<?= $key ?>, 1)">顶</a>
    <a href="javascript:void(0);" onclick="vote(<?= $key ?>, -1)">踩</a>

	<div id="comment-form-<?= $key ?>" style="display:none;">

		<?php
		$form = ActiveForm::begin(
		    [
		        'method' => 'post',
		        ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]ListView with Pjax
		        /// 'action' => ['create-comment'], ///注意：不能有页面跳转!比如form中的action、js的重定向等！
		        'options' => ['data-pjax' => true]	///ListView with Pjax
		    ]
		); ?>

	    <?= $form->field($comment_model, 'parent_id')->hiddenInput(['value' => $key])->label(false) ?>

	    <?= $form->field($comment_model, 'post_id')->hiddenInput(['value' => $post_model->id])->label(false) ?>

		<?= $form->field($comment_model, 'text')->textarea(['placeholder'=>'您也来评论吧！', 'rows' => 3])->label(false) ?>

	    <div class="form-group">
	        <?= Html::submitButton('回复', ['class' => 'btn btn-success']) ?>
	    </div>
	    <?php ActiveForm::end(); ?>

	</div>
</div>

<?php   ///切换显示/隐藏回复评论
$this->registerJs('
    $("#comment-reply-'.$key.'").click(function(){
    	$("#comment-form-'.$key.'").toggle(300);	///渐变动画延时
    	return false;
    });
');
?>
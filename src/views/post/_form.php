<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yongtiger\article\models\Post;
use yongtiger\article\Module;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $contentModel yongtiger\article\models\Content */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($postModel, 'category_id')->textInput() ?>

    <!--///[yii2-brainblog_v0.4.5_f0.4.4_tag_input_improve]-->
    <?= $form->field($postModel, 'tagValues')->widget('\yuncms\tag\widgets\TagsinputWidget', [
        'model' => $postModel, 'options' => ['value' => $postModel->isNewRecord ? '' : $postModel->tagValues]
    ]); ?>

    <?= $form->field($postModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($postModel, 'summary')->textInput(['maxlength' => true]) ?>

    <?php ///[editorCallback]
        $field = $form->field($contentModel, 'body');
        $params = ['rows' => 10];
        if (is_callable($editor = Module::instance()->editorCallback)) {
            echo call_user_func($editor, $field, $contentModel, 'body');
        } else {
            echo $field->textarea($params);
        }
    ?>

    <?= $form->field($postModel, 'count')->textInput() ?>

    <!--///[yii2-brainblog_v0.7.0_f0.6.0_post_status]-->
    <?php echo $form->field($postModel, 'status')->dropDownList(
            [Post::STATUS_DELETE => 'STATUS_DELETE', Post::STATUS_MODERATE => 'STATUS_MODERATE', Post::STATUS_ACTIVE => 'STATUS_ACTIVE'], 
            ['prompt'=>'Select...']
    ); ?>

    <div class="form-group">
        <?= Html::submitButton($postModel->isNewRecord ? 'Create' : 'Update', ['class' => $postModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

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

    <!--///[TagsinputWidget]-->
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

    <?php echo $form->field($postModel, 'status')->dropDownList(
            [Post::STATUS_DELETE => Module::t('message', 'STATUS_DELETE'), Post::STATUS_MODERATE => Module::t('message', 'STATUS_MODERATE'), Post::STATUS_ACTIVE => Module::t('message', 'STATUS_ACTIVE')], 
            ['prompt' => Module::t('message', '(Select ...)')]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton($postModel->isNewRecord ? Module::t('message', 'Create') : Module::t('message', 'Update'), ['class' => $postModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

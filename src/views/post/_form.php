<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yongtiger\article\models\Post;

/* @var $this yii\web\View */
/* @var $post_model yongtiger\article\models\Post */
/* @var $content_model yongtiger\article\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($post_model, 'category_id')->textInput() ?>

    <!--///[yii2-brainblog_v0.4.5_f0.4.4_tag_input_improve]-->
    <?= $form->field($post_model, 'tagValues')->widget('\yuncms\tag\widgets\TagsinputWidget', [
            'model' => $post_model, 'options' => ['value' => $post_model->isNewRecord ? '' : $post_model->tagValues]
        ]) ?>
    <!--///[http://www.brainbook.cc]-->

    <?= $form->field($post_model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($post_model, 'description')->textInput(['maxlength' => true]) ?>

    <!--///[yii2-brainblog_v0.5.1_f0.5.0_post_content_multiple_model]-->
    <!--///[yii2-brainblog_v0.5.0_f0.4.4_rich_text_ueditor]-->
    <?= $form->field($content_model, 'body')->widget('yongtiger\ueditor\UEditor', [
        'clientOptions' => [

            //编辑区域大小
            'initialFrameHeight' => '320',

            //设置语言
            'lang' =>'zh-cn', //中文为 zh-cn，英文为 en

            //定制按钮
            'toolbars' => [
                [
                    'fullscreen', //全屏
                    'source', //源代码
                    '|',
                    'undo', //撤销
                    'redo', //重做
                    '|',
                    'bold', //加粗
                    'italic', //斜体
                    'underline', //下划线
                    'fontborder', //字符边框
                    'strikethrough', //删除线
                    '|',
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'fontfamily', //字体
                    'fontsize', //字号
                    '|',
                    'paragraph', //段落格式
                    'rowspacingtop', //段前距
                    'rowspacingbottom', //段后距
                    'lineheight', //行间距
                    '|',
                    'insertorderedlist', //有序列表
                    'insertunorderedlist', //无序列表
                    'indent', //首行缩进
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'justifyjustify', //两端对齐
                    '|',
                    'removeformat', //清除格式
                    'formatmatch', //格式刷
                    'pasteplain', //纯文本粘贴模式
                    'autotypeset', //自动排版
                ],
                [
                    'searchreplace', //查询替换
                    'selectall', //全选
                    'cleardoc', //清空文档
                    '|',
                    'wordimage', //图片转存
                    'snapscreen', //截图
                    'scrawl', //涂鸦
                    'charts', // 图表
                    'simpleupload', //单图上传
                    'insertimage', //多图上传
                    'imagenone', //默认
                    'imagecenter', //居中
                    'imageleft', //左浮动
                    'imageright', //右浮动
                    '|',
                    'attachment', //附件
                    'insertvideo', //视频
                    'insertframe', //插入Iframe
                    'insertcode', //代码语言
                    '|',
                    'template', //模板
                    '|',
                    'background', //背景
                    'blockquote', //引用
                    '|',
                    'spechars', //特殊字符
                    'emotion', //表情
                    'time', //时间
                    'date', //日期
                    'anchor', //锚点
                    'link', //超链接
                    'unlink', //取消链接
                    'horizontal', //分隔线
                    '|',
                    'preview', //预览
                    'help', //帮助
                ],
            ],
        ],
        
        ///[yii2-brainblog_v0.9.0_f0.8.0_UEditor_SyntaxHighlighter]
        ///[UEditor:自定义请求参数]（注意：编辑器内容首行不能有pre！否则失效）@see http://fex.baidu.com/ueditor/#dev-serverparam
        'serverparam' => [
            // 'imagePathFormat'=>'/upload/image/'.Yii::$app->user->identity->id.'_{yyyy}{mm}{dd}/{time}{rand:6}',
            // 'scrawlPathFormat'=>'/upload/scrawl/'.Yii::$app->user->identity->id.'_{yyyy}{mm}{dd}/{time}{rand:6}',
            // 'videoPathFormat'=>'/upload/video/'.Yii::$app->user->identity->id.'_{yyyy}{mm}{dd}/{time}{rand:6}',
            // 'filePathFormat'=>'/upload/file/'.Yii::$app->user->identity->id.'_{yyyy}{mm}{dd}/{time}{rand:6}',
            'imagePathFormat'=>'/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'scrawlPathFormat'=>'/upload/scrawl/{yyyy}{mm}{dd}/{time}{rand:6}',
            'videoPathFormat'=>'/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}',
            'filePathFormat'=>'/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}',
        ],

        ///[UEditor_Event_insertimage_insertfile_simpleuploadge]
        ///[yii2-brainblog_v0.9.2_f0.9.1_post_attachment_AttachableBehavior]
        'uploadInputNames' => [
            'image' => 'Content[attachValues][uploadimages][]',
            'file' => 'Content[attachValues][uploadfiles][]',
        ]

    ]); ?>

    <!-- <?///= Html::activeHiddenInput($post_model, 'attachmentValues') ?> -->

    <!-- <?///= $form->field($post_model, 'content_id')->textInput() ?> -->
    <!--///[http://www.brainbook.cc]-->

    <!--///[yii2-brainblog_v0.6.0_f0.5.1_post_user_id_BlameableBehavior]-->
    <!--<?///= $form->field($post_model, 'user_id')->textInput() ?> -->

    <?= $form->field($post_model, 'count')->textInput() ?>

    <!--///[yii2-brainblog_v0.7.0_f0.6.0_post_status]-->
    <?php echo $form->field($post_model, 'status')->dropDownList(
            [Post::STATUS_DELETE => 'STATUS_DELETE', Post::STATUS_MODERATE => 'STATUS_MODERATE', Post::STATUS_ACTIVE => 'STATUS_ACTIVE'], 
            ['prompt'=>'Select...']
        );
     ?>
     <!--///[http://www.brainbook.cc]-->

    <!--///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]-->
    <!-- <?///= Html::activeHiddenInput($post_model, 'attachmentValues') ?> -->
    <!--///[http://www.brainbook.cc]-->

    <div class="form-group">
        <?= Html::submitButton($post_model->isNewRecord ? 'Create' : 'Update', ['class' => $post_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

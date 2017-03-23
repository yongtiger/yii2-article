<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yongtiger\article\models\Post;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $post_model yongtiger\article\models\Post */

$this->title = $post_model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $post_model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $post_model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <!---///[yii2-brainblog_v0.8.0_f0.7.0_post_view]-->
    <?= DetailView::widget([
        'model' => $post_model,
        'attributes' => [
            'id',
            'category_id',
            'title',
            'description:html',
            [
                'label'=>'正文',
                'format'=>'raw', 
                'value'=>$post_model->content->body,
                'contentOptions' => ['class' => 'btn btn-danger'],  ///[BUG]无效？？？？？
                'captionOptions' => ['class' => 'btn btn-danger'],  ///[BUG]无效？？？？？
            ],
            [
                'label'=>'用户名',
                'value'=>$post_model->user->username,
                'contentOptions' => ['class' => 'btn btn-danger'],  ///[BUG]无效？？？？？
                'captionOptions' => ['class' => 'btn btn-danger'],  ///[BUG]无效？？？？？
            ],
            'count',
            [
                'label'=>'状态',
                'value'=>[Post::STATUS_DELETE => 'STATUS_DELETE', Post::STATUS_MODERATE => 'STATUS_MODERATE', Post::STATUS_ACTIVE => 'STATUS_ACTIVE'][$post_model->status]
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <!--///[http://www.brainbook.cc]-->

</div>



<!--///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]Pjax显示评论列表（用ListView）-->
<?php Pjax::begin(['id' => 'comments']) ///Pjax显示评论列表（用ListView）?>

<?= ListView::widget([
    'dataProvider' => $comment_dataProvider,
    'itemView' => '_comment',   ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]ListView嵌套的item页面
    'viewParams' => [
        'post_model' => $post_model,
        'comment_model' => $comment_model,
    ],
    'itemOptions' => ['style' => 'border-bottom:1px solid #ccc;'],  ///分割线
    'summary' => '
        <div>已有{totalCount}条评论</div>
        <!--///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]a标签实现Pjax评论过滤功能-->
        <ul id="comment-orders">
            <!--///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]替换url中的参数，而不是追加-->
            <li class="active"><a id="order-desc" href="'.Url::current(['orderby' => 'order-desc']).'">最新评论</a></li>
            <li><a id="order-asc" href="'.Url::current(['orderby' => 'order-asc']).'">最早评论</a></li>
            <li><a id="order-hot" href="'.Url::current(['orderby' => 'order-hot']).'">最热评论</a></li>
        </ul>
    ',
    'emptyText' => '没有任何评论',
]); ?>

<?php $this->beginBlock('comment_js_block') ///Pjax显示评论列表（用ListView）?>
    ///<script>
    $("#new-comment").on("pjax:end", function() {
        $.pjax.reload({container:"#comments"});  //Reload ListView
    });

    ///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]a标签实现Pjax评论过滤功能
    $("#comment-orders #"+getquerystring('orderby')).parent().addClass("active").siblings().removeClass("active");

    ///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]JS获取url参数
    function getquerystring(name)
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    }

<?php $this->endBlock(); ?>

<?php $this->registerJs($this->blocks['comment_js_block']); ?>

<?php Pjax::end(); ///Pjax显示评论列表（用ListView）?>
<!--///[http://www.brainbook.cc]-->



<!--///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]Pjax发表评论-->
剩余<span id="textCount">5</span>个字<br /><!--///发表评论时显示剩余字数-->

<div class="comment-form">

    <?php yii\widgets\Pjax::begin(['id' => 'new-comment']) ///Pjax发表评论?>

    <?php $form = ActiveForm::begin(
        [
            'method' => 'post',
            /// 'action' => ['create-comment'], ///注意：Pjax不能有页面跳转!比如form中的action、js的重定向等！
            'options' => ['data-pjax' => true]  ///Pjax发表评论
        ]
    ); ?>

    <?= $form->field($comment_model, 'parent_id')->hiddenInput()->label(false) ?>

    <?= $form->field($comment_model, 'post_id')->hiddenInput(['value' => $post_model->id])->label(false) ?>

    <?= $form->field($comment_model, 'text')->textarea([
        'id'=>'comment-reply-text',
        'placeholder'=>'test', 'rows' => 6,
        'oninput'=>"wordcount();",     ///发表评论时显示剩余字数
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($comment_model->isNewRecord ? '发表评论' : 'Update', ['class' => $comment_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ///Pjax发表评论?>

</div>

<?php $this->beginBlock('wordcount_js_block') ///发表评论时显示剩余字数?>
    ///<script>
    function wordcount() 
    { 
        var curLength=$("#comment-reply-text").val().length; 
        if(curLength>5) 
        { 
            var num=$("#comment-reply-text").val().substr(0,5); 
            $("#comment-reply-text").val(num); 
            alert("超过字数限制，多出的字将被截断！" ); 
        } 
        else 
        { 
            $("#textCount").text(5-$("#comment-reply-text").val().length); 
        } 
    } 
<?php $this->endBlock(); ?>

<?php $this->registerJs($this->blocks['wordcount_js_block'], yii\web\View::POS_END); ?>
<!--///[http://www.brainbook.cc]-->



<!--///[yii2-brainblog_v0.9.0_f0.8.0_UEditor_SyntaxHighlighter]-->
<?php
///获取ueditor.parse.js所在的目录为rootPath
/// 比如‘/[yii2project]/yii2-brainblog/frontend/web/assets/95dccb21’
$ueditor_parse_root_path = Yii::$app->assetManager->getPublishedUrl('@vendor/kucha/ueditor/assets');
?>

<?php $this->beginBlock('ueditor_parse_js_block') ?>
    
    UE.sh_config.sh_js="shCore.min.js";     //语法解析文件 
    UE.sh_config.sh_theme="Default";    ///语法高亮设置,一共有8种主题可选：Default,Django,Eclipse,Emacs,FadeToGrey,MDUltra,Midnight,RDark
    uParse(".post-view",{rootPath: "<?= $ueditor_parse_root_path ?>"});

<?php $this->endBlock(); ?>

<?php
frontend\assets\UeditorParseAsset::register($this);
$this->registerJs($this->blocks['ueditor_parse_js_block'], yii\web\View::POS_END);
?>
<!--///[http://www.brainbook.cc]-->



<!--///[yii2-brainblog_v0.10.2_f0.10.1_post_comment_vote]-->
<?php $this->beginBlock('vote_js_block') ///发表评论时显示剩余字数?>
    ///<script>
    function vote(comment_id, vote) 
    { 
        htmlobj=$.ajax({url:"<?=Url::to(['comment/update-vote'])?>&id="+comment_id+"&vote="+vote});
    } 
<?php $this->endBlock(); ?>

<?php $this->registerJs($this->blocks['vote_js_block'], yii\web\View::POS_END); ?>
<!--///[http://www.brainbook.cc]-->
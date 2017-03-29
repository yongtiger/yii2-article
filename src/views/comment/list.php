<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $postModel yongtiger\article\models\Post */
/* @var $commentModel yongtiger\article\models\Comment */

$this->registerJs(
<<<JS
///Reload comment list
$("#new-comment").on("pjax:end", function(){
    $.pjax.reload({container:"#comment-list"});  
});

///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]a标签实现Pjax评论过滤功能
$("#comment-orders #"+getquerystring('orderby')).parent().addClass("active").siblings().removeClass("active");

///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]JS获取url参数
function getquerystring(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null) return unescape(r[2]);
    return null;
}
JS
);

///[word count]
$this->registerJs(
<<<JS
function wordcount(){
    var curLength=$("#comment-reply-text").val().length; 
    if(curLength>5){ 
        var num=$("#comment-reply-text").val().substr(0,5); 
        $("#comment-reply-text").val(num); 
        alert("超过字数限制，多出的字将被截断！"); 
    }else{ 
        $("#textCount").text(5-$("#comment-reply-text").val().length); 
    } 
}
JS
, View::POS_END);

///[vote]
$this->registerJs(
<<<JS
function vote(comment_id, vote){ 
    htmlobj=$.ajax({url:"<?= Url::to(['comment/update-vote']) ?>&id="+comment_id+"&vote="+vote});
}
JS
, View::POS_END);

?>
<div class="comment-form">

    <?php Pjax::begin(['id' => 'new-comment']); ?>

    <?php $form = ActiveForm::begin(
        [
            'method' => 'post',
            /// 'action' => ['create-comment'], ///注意：Pjax不能有页面跳转!比如form中的action、js的重定向等！
            'options' => ['data-pjax' => true]  ///Pjax发表评论
        ]
    ); ?>

    <?= $form->field($commentModel, 'parent_id')->hiddenInput()->label(false); ?>

    <?= $form->field($commentModel, 'post_id')->hiddenInput(['value' => $postModel->id])->label(false); ?>

    <?= $form->field($commentModel, 'text')->textarea([
        'id' => 'comment-reply-text',
        'placeholder' => 'test', 'rows' => 6,
        'oninput' => 'wordcount();',     ///[word count]
    ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($commentModel->isNewRecord ? '发表评论' : 'Update', ['class' => $commentModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    剩余<span id="textCount">5</span>个字<br /><!--///[word count]-->

    <?php Pjax::end(); ?>

</div>

<!--///[comment list]-->
<?php Pjax::begin(['id' => 'comment-list']); ?>

<?= ListView::widget([
    'dataProvider' => $commentDataProvider,
    'itemView' => '_reply',   ///[comment reply]
    'viewParams' => [
        'postModel' => $postModel,
        'commentModel' => $commentModel,
    ],
    'itemOptions' => ['style' => 'border-bottom:1px solid #ccc;'],  ///dividing line
    'summary' => '
        <div>已有{totalCount}条评论</div>
        <!--///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]a标签实现Pjax评论过滤功能-->
        <ul id="comment-orders">
            <!--///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]替换url中的参数，而不是追加-->
            <li class="active"><a id="order-desc" href="'.Url::current(['orderby' => 'order-desc']).'">最新评论</a></li>
            <li><a id="order-asc" href="'.Url::current(['orderby' => 'order-asc']).'">最早评论</a></li>
            <li><a id="order-hot" href="'.Url::current(['orderby' => 'order-hot']).'">最热评论</a></li>
        </ul>
    ',///?????use block
    'emptyText' => '没有任何评论',
]); ?>

<?php Pjax::end(); ?>

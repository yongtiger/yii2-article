<?php
///[yii2-brainblog_v0.3.1_f0.3.0_tree-manager]Category
use yongtiger\tree\TreeView;
use yongtiger\article\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yongtiger\tree\Module;

//////[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category]
if(!Yii::$app->user->isGuest){
    $model = Category::findOne(['root' => Yii::$app->user->id, 'lvl' => 0]);

    ///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category]创建用户分类
    if($model){
	    $query=$model->children();

		echo TreeView::widget([
		    'query' => $query,
		    'rootOptions' => ['label'=>$model->name, 'parent_id' => $model->id],
		    'allowNewRoots' => false,	///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category]去掉添加root按钮
		    'isAdmin' => true,         // optional (toggle to enable admin mode)
		    'displayValue' => $model->id,        // initial display value

		    'headingOptions' => ['label' => 'Categories'],
		    'fontAwesome' => true,     // optional
		    'softDelete' => true,       // defaults to true
		    'cacheSettings' => [
		        'enableCache' => true   // defaults to true
		    ],
		    'toolbar' => [TreeView::BTN_CREATE_ROOT => false],	///去掉Add New Root按钮

		    ///[yii2-brainblog_v0.3.3_f0.3.2_tree-manager_gridview]nodeActions
          //   'nodeActions' => [
		        // Module::NODE_MANAGE => Url::to(['node/manage']),
		        // Module::NODE_SAVE => Url::to(['node/save']),
		        // Module::NODE_REMOVE => Url::to(['node/remove']),
		        // Module::NODE_MOVE => Url::to(['node/move']),
          //   ],
            // 'nodeView' => '@yongtiger\article/views/node/_detail',
            ///[http://www.brainbook.cc]

		]);
    }else{

    	///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category]创建用户分类：如果用户没建分类则提示创建分类
    	echo Html::a('创建分类', Url::to(['category/make-user-root']));	///[test!!!]

    }
}
//////[http://www.brainbook.cc]

///[http://www.brainbook.cc]

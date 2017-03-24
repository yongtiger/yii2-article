<?php
///[yii2-brainblog_v0.3.1_f0.3.0_tree-manager]TreeViewInput
use yongtiger\tree\TreeViewInput;
use yongtiger\article\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;

if(!Yii::$app->user->isGuest){
	$model = Category::findOne(['root' => Yii::$app->user->id, 'lvl' => 0]);

    if($model){
	    $query=$model->children();

		echo TreeViewInput::widget([
		    // single query fetch to render the tree
		    'query'             => $query, 
		    'rootOptions'       => ['label'=>$model['name'], 'parent_id' => $model->id],
		    'name'              => 'kv-product',    // input name
		    'value'             => '1,2,3',         // values selected (comma separated for multiple select)
		    'asDropdown'        => true,            // will render the tree input widget as a dropdown.

		    'multiple'          => true,            // set to false if you do not need multiple selection
		    'headingOptions'    => ['label' => 'Categories'],
		    'fontAwesome'       => true,            // render font awesome icons
		    //'options'         => ['disabled' => true],

		    ///[yii2-brainblog_v0.3.3_f0.3.2_tree-manager_gridview]nodeActions
            'nodeActions' => [
		        // Module::NODE_MANAGE => Url::to(['node/manage']),
            ],
            'nodeView' => '@yongtiger/article/views/node/_detail',
            ///[http://www.brainbook.cc]


		]);
    }else{

    	///如果用户没建分类则提示创建分类
    	echo Html::a('创建分类', Url::to(['category/make-user-root']));	///[test!!!]

    }
}
///[http://www.brainbook.cc]
<?php ///[Yii2 article]

/**
 * Yii2 article
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-article
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\article\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yongtiger\article\models\Category;

/**
 * CategoryController implements the CRUD actions for Category model.
 *
 * @package yongtiger\article\controllers
 */
class CategoryController extends Controller {
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    ///[yii2-brainblog_v0.3.1_f0.3.0_tree-manager]TreeViewInput
    public function actionTreeViewInput()
    {
        return $this->render('tree-view-input');
    }
    ///[http://www.brainbook.cc]

    ///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category]创建用户分类
    public function actionMakeUserRoot()
    {
        $model = new Category(
        	[
        		'root' => Yii::$app->user->id,
        		'name' => Yii::$app->user->identity->username,
        		'lft' => 1,
        		'rgt' => 2,
        		'lvl' => 0,
        	]
        );

        if ($model->makeRoot(false)) {  ///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category][BUG]public static $treeQueryClass
            return $this->redirect(Url::to(['category']));
        } else {
            echo 'failed';	///调试！！！
        }

    }
    ///[http://www.brainbook.cc]

}
///[http://www.brainbook.cc]
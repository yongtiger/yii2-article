<?php
///[yii2-brainblog_v0.3.1_f0.3.0_tree-manager]Category
namespace frontend\models;

use Yii;

class Category extends \kartik\tree\models\Tree
{

    ///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category][BUG]public static $treeQueryClass
    ///public static $treeQueryClass = 'frontend\models\TreeQuery';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * Override isDisabled method if you need as shown in the
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        // if (Yii::$app->user->identity->username !== 'admin') {
        //     return true;
        // }
        return parent::isDisabled();
    }
}
///[http://www.brainbook.cc]
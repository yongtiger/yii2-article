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

namespace yongtiger\article\models;

use Yii;
use yongtiger\tree\models\Tree;

class Category extends Tree
{

    ///[yii2-brainblog_v0.3.2_f0.3.1_tree-manager_user_category][BUG]public static $treeQueryClass
    ///public static $treeQueryClass = 'frontend\models\TreeQuery';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
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
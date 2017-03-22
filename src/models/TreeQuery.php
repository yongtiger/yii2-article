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

use kartik\tree\models\TreeQuery;

class TreeQuery extends TreeQuery
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        	///'something...';
        ];
    }
}

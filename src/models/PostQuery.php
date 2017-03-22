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

use yii\db\ActiveQuery;
use creocoder\taggable\TaggableQueryBehavior;   ///[yii2-brainblog_v0.4.1_f0.3.3_tag]creocoder/yii2-taggable

/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Post
 */
class PostQuery extends ActiveQuery
{
    ///[yii2-brainblog_v0.4.1_f0.3.3_tag]creocoder/yii2-taggable
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
    ///[http://www.brainbook.cc]

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

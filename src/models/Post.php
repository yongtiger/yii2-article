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
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $summary
 * @property integer $content_id
 * @property integer $user_id
 * @property integer $count
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comment[] $comments
 * @property Category $category
 * @property Content $content
 * @property User $user
 * @property PostTagAssn[] $postTagAssns/////////????
 * @property Tag[] $tags
 */
class Post extends ActiveRecord
{

    ///[yii2-brainblog_v0.7.0_f0.6.0_post_status]
    const STATUS_DELETE = -1;
    const STATUS_MODERATE = 0;
    const STATUS_ACTIVE = 1;
    ///[http://www.brainbook.cc]

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_post}}';
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],

            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],

            ///[yii2-brainblog_v0.4.1_f0.3.3_tag]creocoder/yii2-taggable
            'taggable' => [
                'class' => \yongtiger\taggable\TaggableBehavior::className(),
                // 'tagValuesAsArray' => false,
                // 'tagRelation' => 'tags',
                // 'tagValueAttribute' => 'name',
                // 'tagFrequencyAttribute' => 'frequency',
            ],

            ///[v0.1.3 (ADD# yongtiger\comment\behaviors)]///[v0.1.4 (CHG# comment sort)]
            // 'comment' => [
            //     'class' => \yongtiger\comment\behaviors\CommentBehavior::className(),
            //     'config' => [
            //         'dataProviderConfig' => [
            //             'pagination' => [
            //                 // 'pageParam' => 'comment-page',
            //                 // 'pageSizeParam' => 'comment-per-page',
            //                 'pageSize' => 10,
            //                 // 'pageSizeLimit' => [1, 50],
            //             ],
            //         ],
            //         'sort' => 'created-at-asc',
            //     ],
            // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'content_id', 'count', 'status'], 'integer'],
            [['title'], 'required'],
            [['title', 'summary'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],

            ['tagValues', 'safe'],  ///[yii2-brainblog_v0.4.1_f0.3.3_tag]creocoder/yii2-taggable

            ['status', 'default', 'value' => self::STATUS_ACTIVE],  ///[yii2-brainblog_v0.7.0_f0.6.0_post_status]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content_id' => 'Content ID',
            'user_id' => 'User ID',
            'count' => 'Count',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tagValues' => '标签',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getPostTagAssns()///???????????
    // {
    //     return $this->hasMany(PostTagAssn::className(), ['post_id' => 'id']);
    // }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }


    ///[yii2-brainblog_v0.4.1_f0.3.3_tag]creocoder/yii2-taggable
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable(PostTagAssn::tableName(), ['post_id' => 'id']);
    }
    ///[http://www.brainbook.cc]

}

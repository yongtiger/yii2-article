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
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Post $post
 * @property Attachment[] attachments
 */
class Content extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_content}}';
    }

    ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]
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

            ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]
            'attachable' => [
                'class' => \yongtiger\ueditor\behaviors\AttachableBehavior::className(),///?????replacable!
            ],
            ///[http://www.brainbook.cc]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
            [['body'], 'string'],

            ['attachValues', 'safe'],   ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['content_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['content_id' => 'id']);
    }
}

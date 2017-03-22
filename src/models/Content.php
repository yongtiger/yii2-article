<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $content
 *
 * @property Post[] $posts
 */
class Content extends \yii\db\ActiveRecord
{
    private $_attachments;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]
    public function behaviors()
    {
        return [
            ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]
            'attachable' => [
                'class' => AttachableBehavior::className(),
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['content_id' => 'id']);
    }

}
///[http://www.brainbook.cc]
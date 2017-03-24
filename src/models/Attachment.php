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
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property integer $content_id
 * @property integer $attachment_type_id
 * @property integer $attachment_id
 * @property integer $user_id
 * @property string $created_at
 *
 * @property AttachmentType $attachmentType
 * @property Content $content
 * @property User $user
 */
class Attachment extends ActiveRecord
{
    private $_attachmentUpload; ///[yii2-brainblog_v0.9.1_f0.9.0_post_attachment_AttachableBehavior]

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_attachment}}';
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
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],

            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'attachment_type_id', 'attachment_upload_id', 'user_id'], 'integer'],

            [['attachment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AttachmentType::className(), 'targetAttribute' => ['attachment_type_id' => 'id']],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getUser()->identityClass, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'attachment_type_id' => 'Attachment Type ID',
            'attachment_upload_id' => 'Attachment ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachmentType()
    {
        return $this->hasOne(AttachmentType::className(), ['id' => 'attachment_type_id']);
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
     * @inheritdoc
     * @return AttachmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    ///[yii2-brainblog_v0.9.3_f0.9.2_post_attachment_AttachableBehavior]
    public function getAttachmentUpload()
    {
        if($this->_attachmentUpload) return $this->_attachmentUpload;

        $attachType = AttachmentType::findByTypeId($this->attachment_type_id);
        $attachmentTableName = $attachType['attachment_upload_table_name'];    ///table name

        $this->_attachmentUpload = (new Query())->from($attachmentTableName)->where(['id'=>$this->attachment_upload_id])->one();

        return $this->_attachmentUpload;
    }

    public function getAttachmentTypeName()
    {
        $attachType = AttachmentType::findByTypeId($this->attachment_type_id);
        return $attachType['attachment_type_name'];    ///type name
    }

    public function getAttachmentUploadTableName()
    {
        $attachType = AttachmentType::findByTypeId($this->attachment_type_id);
        return $attachType['attachment_upload_table_name'];    ///table name
    }
    ///[http://www.brainbook.cc]

}
///[http://www.brainbook.cc]
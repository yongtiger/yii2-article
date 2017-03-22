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

/**
 * This is the model class for table "attachment_type".
 *
 * @property integer $id
 * @property string $attachment_type_name
 * @property string $attachment_table_name
 * @property string $rootpath
 *
 * @property Attachment[] $attachments
 */
class AttachmentType extends ActiveRecord
{

    ///[yii2-brainblog_v0.9.3_f0.9.2_post_attachment_AttachableBehavior]
    ///用静态数组存放attachment_type表全部数据，方便随时取用
    public static $attachmentTypes = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachment_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attachment_type_name'], 'required'],
            [['id'], 'integer'],
            [['attachment_type_name', 'attachment_upload_table_name', 'rootpath'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attachment_type_name' => 'Attachment Type Name',
            'attachment_upload_table_name' => 'Attachment Upload Table Name',
            'rootpath' => 'Rootpath',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['attachment_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AttachmentTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \yii\db\ActiveQuery(get_called_class());
    }

    ///[yii2-brainblog_v0.9.3_f0.9.2_post_attachment_AttachableBehavior]
    ///由$typeName获得数据表attachment_type的相应数组
    public static function findByTypeName($typeName)
    {
        return self::findByType('attachment_type_name', $typeName);
    }

    ///由$typeId获得数据表attachment_type的相应数组
    public static function findByTypeId($typeId)
    {
        return self::findByType('id', $typeId);
    }

    ///由$type, $value获得数据表attachment_type的相应数组（只访问一次数据库查询！）
    public static function findByType($type, $value){
        if(!self::$attachmentTypes){
            self::$attachmentTypes = self::find()->asArray()->all();  ///[BUG]self::findAll()会返回缺少参数的错误！
        }

        foreach (self::$attachmentTypes as $attachmentType) {
            if($attachmentType[$type] == $value) {
                return $attachmentType;
            }
        }
        return false;
    }
    ///[http://www.brainbook.cc]

}
///[http://www.brainbook.cc]
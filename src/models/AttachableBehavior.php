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

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class AttachableBehavior extends Behavior
{

    private $_attachValues = [];

    public function getAttachValues()
    {
        if(!isset($this->owner->id) || $this->_attachValues){   ///优化创建Post页面：如果是新建Post页面，$this->owner->id为null
        	return $this->_attachValues;
        }

        $attachments = $this->owner->hasMany(Attachment::className(), ['content_id' => 'id'])->all();
        foreach ($attachments as $attachment) {

        	$attachmentTypeName = $attachment->attachmentTypeName;    ///type name
            $attachmentUpload = $attachment->attachmentUpload;

            if($attachment->id){
                $attachmentUpload['attachment_id'] = $attachment->id;
            }

            $this->_attachValues[$attachmentTypeName][] = json_encode($attachmentUpload);
        }

        return $this->_attachValues;
    }

    public function setAttachValues($values)
    {
        if (is_array($values)) {
            $this->_attachValues = $values;
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function afterInsert($event)
    {
        $this->insertAttachValues();
    }

    public function afterUpdate($event)
    {
        $this->insertAttachValues();
        $this->deleteAttachValues();
    }

    public function beforeDelete($event)
    {
        $this->deleteAttachValues();
    }

    public function insertAttachValues()
    {
        if(!is_array($this->_attachValues) || !$this->_attachValues) return;

        foreach ($this->_attachValues as $key => $value) {

            ///由$key查询数据表attachment_type中的table_name
            $attachType = AttachmentType::findByTypeName($key);
            $attachmentUploadTableName = $attachType['attachment_upload_table_name'];    ///table name
            $attachmentTypeId = $attachType['id'];

            ///获得每个upload的JSON对象，并转换为数组
            foreach ($value as $k => $uploadJsonObject) {

                $uploadArray = json_decode($uploadJsonObject, true);	///@see http://www.jb51.net/article/59875.htm

                if(isset($uploadArray['id'])) continue;    ///如果有id，不能insert（以后考虑可以update？？？？？）

                ///@see http://www.yiiframework.com/doc-2.0/guide-db-dao.html
                $this->owner->getDb()->createCommand()->insert(
                $attachmentUploadTableName,
                $uploadArray
                )->execute();

                $primaryKey = $this->owner->getDb()->getLastInsertID();
                $uploadArray['id'] = $primaryKey;

                if(isset($uploadArray['attachment_id'])) continue; ///如果有attachment_id，不能insert（以后考虑可以update？？？？？）

                $attachment = new Attachment();
                $attachment->setAttribute('content_id', $this->owner->id);
                $attachment->setAttribute('attachment_type_id', $attachmentTypeId);
                $attachment->setAttribute('attachment_upload_id', $primaryKey);

                if($attachment->save()){
                	///insert元素的attachment_id设置为新增加记录的id，否则update的deleteAttachValues会再次被删除！
                    $primaryKey = $this->owner->getDb()->getLastInsertID();
                    $uploadArray['attachment_id'] = $primaryKey;
                    $this->_attachValues[$key][$k] = json_encode($uploadArray);
                }
            }
        }
    }

    public function deleteAttachValues()
    {
    	///从attachment表中获得已有的$old_attachments
        $old_attachments = $this->owner->hasMany(Attachment::className(), ['content_id' => 'id'])->all();
        if(!$old_attachments) return;
        $old_attachments = ArrayHelper::index($old_attachments, 'id');

        ///规范化$this->_attachValues、并去掉其中无attachment_id的元素，得到结果$attachments
        $attachments = [];
        foreach ($this->_attachValues as $key => $value) {
            foreach ($value as $uploadJsonObject) {
                $uploadArray = json_decode($uploadJsonObject, true);
                if(!isset($uploadArray['attachment_id'])) continue;
                $attachments[$uploadArray['attachment_id']]=$uploadArray;
            }
        }

        ///删除$old_attachments中有、而$attachments没有的
        $deleteAttachmentIds = $deleteUploads = [];

        foreach ($old_attachments as $old_attachment){
            if(isset($attachments[$old_attachment['id']])) continue;

            ///先删除$old_attachment关联的attachment_image或attachment_file表中记录
            $attachmentUploadTableName = $old_attachment->attachmentUploadTableName;    ///table name
            $deleteUploads[$attachmentUploadTableName][] = $old_attachment->attachmentUpload['id'];

            ///删除$old_attachment
            $deleteAttachmentIds[] = $old_attachment['id'];

        }

        foreach ($deleteUploads as $attachmentUploadTableName => $attachmentUploadIds){
            $this->owner->getDb()->createCommand()->delete(
                $attachmentUploadTableName,
                ['id'=>$attachmentUploadIds]
            )->execute();
        }

        if($deleteAttachmentIds) {
            Attachment::deleteAll(['id'=>$deleteAttachmentIds]);
        }
    }

}
///[http://www.brainbook.cc]
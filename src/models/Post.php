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
use yongtiger\article\Module;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $summary
 * @property integer $content_id
 * @property integer $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property Content $content
 * @property User $user
 */
class Post extends ActiveRecord
{
    const STATUS_DELETE = -1;
    const STATUS_MODERATE = 0;
    const STATUS_ACTIVE = 1;

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
        return array_merge([
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                // 'value' => new \yii\db\Expression('NOW()'),
            ],

            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],

        ], Module::instance()->postBehaviors);  ///[v0.4.0 (move out taggble and tag)]
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'content_id', 'status'], 'integer'],
            [['title'], 'required'],
            [['title', 'summary'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::instance()->categoryModelClass, 'targetAttribute' => ['category_id' => 'id']],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('message', 'ID'),
            'category_id' => Module::t('message', 'Category ID'),
            'title' => Module::t('message', 'Title'),
            'summary' => Module::t('message', 'Summary'),
            'content_id' => Module::t('message', 'Content ID'),
            'user_id' => Module::t('message', 'User ID'),
            'status' => Module::t('message', 'Status'),
            'created_by' => Module::t('message', 'Created By'),
            'updated_by' => Module::t('message', 'Updated By'),
            'created_at' => Module::t('message', 'Created At'),
            'updated_at' => Module::t('message', 'Updated At'),

             ///[v0.4.0 (move out taggble and tag)]?????
            ///@see http://www.yiiframework.com/forum/index.php/topic/2886-does-behavior-override-owners-implementation-or-just-extend-it/
            //behavior doesn't (can't) override owner's method. behavior mainly enhances owner in two ways: 1. add new methods. 2. respond to events raised in owner.
            'tagValues' => Module::t('message', 'Tag'),   
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Module::instance()->categoryModelClass, ['id' => 'category_id']);///////////
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
        return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'created_by']);
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    ///[v0.4.0 (move out taggble and tag)]?????
    ///@see http://www.yiiframework.com/forum/index.php/topic/2886-does-behavior-override-owners-implementation-or-just-extend-it/
    //behavior doesn't (can't) override owner's method. behavior mainly enhances owner in two ways: 1. add new methods. 2. respond to events raised in owner. 
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
}

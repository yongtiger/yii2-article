<?php
///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]
namespace frontend\models;

use Yii;
///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]TimestampBehavior、BlameableBehavior
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $post_id
 * @property string $text
 * @property integer $user_id
 * @property integer $top
 * @property integer $vote
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comment $parent
 * @property Comment[] $comments
 * @property Post $post
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]TimestampBehavior、BlameableBehavior
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
        ];
    }
    ///[http://www.brainbook.cc]

    /**
     * @inheritdoc
     */
    public function rules()
    {
        ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]TimestampBehavior、BlameableBehavior
        return [
            ///[['parent_id', 'post_id', 'user_id', 'top', 'hot', 'status'], 'integer'],
            [['parent_id', 'post_id', 'top', 'hot', 'status'], 'integer'],
            ///[['text', 'created_at', 'updated_at'], 'required'],
            [['text'], 'required'],
            [['text'], 'string'],
            //[['created_at', 'updated_at'], 'safe'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            //[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
        ///[http://www.brainbook.cc]
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'post_id' => 'Post ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'top' => 'Top',
            'hot' => 'Hot',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
///[http://www.brainbook.cc]
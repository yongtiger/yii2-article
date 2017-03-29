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
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommentSearch represents the model behind the search form about `yongtiger\article\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'post_id', 'user_id', 'top', 'hot', 'status'], 'integer'],
            [['text', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        ///[yii2-brainblog_v0.10.1_f0.10.0_post_comment_orderby]
        $query->where(['post_id'=>$params['id']]);

        if(isset($params['orderby'])){
            if($params['orderby']=='order-hot'){
                $query->orderBy(['hot'=>SORT_DESC, 'created_at'=>SORT_DESC]);
            }elseif($params['orderby']=='order-asc'){
                $query->orderBy(['created_at'=>SORT_ASC]);
            }else{
                $query->orderBy(['created_at'=>SORT_DESC]);
            }
        }else{
            $query->orderBy(['created_at'=>SORT_DESC]);
        }
        ///[http://www.brainbook.cc]

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'top' => $this->top,
            'hot' => $this->hot,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}

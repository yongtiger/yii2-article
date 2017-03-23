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
use yongtiger\article\models\Post;

/**
 * PostSearch represents the model behind the search form about `yongtiger\article\models\Post`.
 */
class PostSearch extends Post
{
    public $keywords;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'content_id', 'user_id', 'count', 'status'], 'integer'],
            [['title', 'description', 'created_at', 'updated_at'], 'safe'],

            [['keywords'], 'safe'],
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
        $query = Post::find();

        // add conditions that should always apply here
        ///[yii2-brainblog_v0.11.0_f0.10.1_post_search]
        $query->join('LEFT JOIN', Content::tableName(), 'article_content.id = article_post.content_id');

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
            'category_id' => $this->category_id,
            'content_id' => $this->content_id,
            'user_id' => $this->user_id,
            'count' => $this->count,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        ///[yii2-brainblog_v0.11.0_f0.10.1_post_search]
        $query->andFilterWhere(['or', ['like', 'title', $this->keywords], ['like', 'description', $this->keywords], ['like', 'body', $this->keywords]]);
        ///$query->createCommand()->rawsql;

        return $dataProvider;
    }
}

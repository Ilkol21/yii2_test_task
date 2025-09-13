<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

class BookSearch extends Book
{
    public $author_search;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'description', 'publication_date', 'author_search'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Book::find()->joinWith(['authors']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'book.title', $this->title]);

        $query->andFilterWhere([
            'or',
            ['like', 'author.first_name', $this->author_search],
            ['like', 'author.last_name', $this->author_search],
        ]);

        $query->groupBy('book.id');

        return $dataProvider;
    }
}
<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return 'author';
    }

    public function rules()
    {
        return [
            [['last_name', 'first_name'], 'required'],
            [['last_name'], 'string', 'min' => 3, 'max' => 100],
            [['first_name', 'middle_name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id']);
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . ($this->middle_name ? ' ' . $this->middle_name : '');
    }
}
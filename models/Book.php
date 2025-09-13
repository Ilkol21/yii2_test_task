<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Book extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $author_ids = [];

    public static function tableName()
    {
        return 'book';
    }

    public function rules()
    {
        return [
            [['title', 'publication_date', 'author_ids'], 'required'],
            [['description'], 'string'],
            [['publication_date'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp', 'maxSize' => 1024 * 1024 * 2],
            [['author_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва',
            'description' => 'Короткий опис',
            'image' => 'Зображення',
            'publication_date' => 'Дата опублікування',
            'imageFile' => 'Файл зображення',
            'author_ids' => 'Автори',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->author_ids = $this->getAuthors()->select('id')->column();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('authors', true);
        if (is_array($this->author_ids)) {
            foreach ($this->author_ids as $author_id) {
                $author = Author::findOne($author_id);
                if ($author) {
                    $this->link('authors', $author);
                }
            }
        }
    }

    public function upload()
    {
        if ($this->validate(['imageFile'])) {
            if ($this->imageFile) {
                $path = 'uploads/books/';
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }
                $fileName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs($path . $fileName);
                $this->image = $fileName;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    public function getAuthorsString()
    {
        $authors = $this->authors;
        $authorNames = [];
        foreach($authors as $author) {
            $authorNames[] = $author->getFullName();
        }
        return implode(', ', $authorNames);
    }
}
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="book-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::button('Add a book', ['value' => Url::to(['book/create']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        </p>

        <?php
        Modal::begin([
            'title' => '<h4>Book</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
        ?>

        <?php Pjax::begin(['id' => 'book-grid']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'image',
                    'format' => 'html',
                    'value' => function($model){
                        return $model->image ? Html::img('@web/uploads/books/' . $model->image, ['width' => '70']) : 'Немає фото';
                    },
                ],
                'title',
                [
                    'attribute' => 'author_search',
                    'label' => 'Authors',
                    'value' => 'authorsString'
                ],
                'publication_date',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::button('<i class="fas fa-pencil-alt"></i>', [
                                'value' => Url::to(['update', 'id' => $model->id]),
                                'class' => 'btn btn-sm btn-primary modal-update-button',
                                'title' => 'Update'
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fas fa-trash"></i>', $url, [
                                'class' => 'btn btn-sm btn-danger',
                                'title' => 'Delete',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this book?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

<?php
$this->registerJs("
    $(function(){
        $('#modalButton').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });

        $(document).on('click', '.modal-update-button', function() {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    });
");
?>
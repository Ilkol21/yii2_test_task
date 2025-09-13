<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Add author', [
            'value' => Url::to(['author/create']),
            'class' => 'btn btn-success',
            'id' => 'modalButton'
        ]) ?>
    </p>

    <?php
    Modal::begin([
        'title' => '<h4>Author</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => true]
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();

    Modal::begin([
        'title' => '<h4 class="modal-title">Confirmation of deletion</h4>',
        'id' => 'confirm-modal',
        'size' => 'modal-sm',
        'footer' => Html::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) .
            Html::button('Confirm', ['class' => 'btn btn-danger', 'id' => 'confirm-delete-button']),
    ]);
    echo '<p>Are you sure you want to delete this entry?</p>';
    Modal::end();
    ?>

    <?php Pjax::begin(['id' => 'author-grid']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'last_name',
            'first_name',
            'middle_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button('<i class="fas fa-pencil-alt"></i>', [
                            'value' => Url::to(['update', 'id' => $model->id]),
                            'class' => 'btn btn-sm btn-primary modal-update-button',
                            'title' => 'Update'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'class' => 'btn btn-sm btn-danger',
                            'title' => 'Delete',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this author?',
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
$js = <<<JS
$(function() {
    var modal = $('#modal');
    var modalContent = $('#modalContent');

    // --- AJAX submit ---
    $(document).off('submit', '#author-form').on('submit', '#author-form', function(e) {
        e.preventDefault();
        var form = $(this);

        if (form.data('is-submitting')) {
            return false;
        }
        form.data('is-submitting', true);

        var submitButton = form.find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(data) {
                if (data.success) {
                    modal.modal('hide');
                    $.pjax.reload({ container: '#author-grid', timeout: 5000 });
                } else {
                    submitButton.prop('disabled', false).text('Save');
                }
            },
            error: function() {
                alert('Error sending form!');
                submitButton.prop('disabled', false).text('Save');
            },
            complete: function() {
                form.removeData('is-submitting');
            }
        });
        return false;
    });
    
    function loadModalForm(url) {
        modal.modal('show');
        modalContent.load(url);
    }

    $(document).on('click', '#modalButton, .modal-update-button', function() {
        loadModalForm($(this).attr('value'));
    });

    modal.on('hidden.bs.modal', function() {
        modalContent.html('');
    });
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY, 'author-modal-handler');
?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Author;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author_ids')->widget(Select2::class, [
        'data' => ArrayHelper::map(Author::find()->all(), 'id', 'fullName'),
        'options' => ['placeholder' => 'Select authors ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'publication_date')->widget(DatePicker::class, [
        'options' => ['placeholder' => 'Enter the publication date ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?php if ($model->image): ?>
        <p>Current image:</p>
        <?= Html::img('@web/uploads/books/' . $model->image, ['width' => '150']) ?>
        <hr>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
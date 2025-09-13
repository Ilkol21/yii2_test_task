<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="author-form">

    <?php $form = ActiveForm::begin([
        'id' => 'author-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 0,
        ],
    ]); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

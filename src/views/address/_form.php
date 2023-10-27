<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\Country;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Address $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
    
<?= Html::activeHiddenInput($model, 'person_id') ?>
<?= Html::activeHiddenInput($model, 'organization_id') ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'type')->dropDownList(Address::ADDRESS_TYPE) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'country')->dropDownList(Country::CODE_NAME) ?>
    </div>
</div>

<?= $form->field($model, 'line_1')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'line_2')->textInput(['maxlength' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="bi bi-check-circle"></i> Save', ['class' => 'btn btn-success  mt-3']) ?>
</div>

<?php ActiveForm::end(); ?>

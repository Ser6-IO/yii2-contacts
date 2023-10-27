<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ser6io\yii2contacts\models\Person;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Organization $model */
/** @var yii\widgets\ActiveForm $form */

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'type')->dropDownList(\ser6io\yii2contacts\models\Organization::ORGANIZATION_TYPE) ?>
    </div>
</div>

<?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'contact_id')->dropDownList(ArrayHelper::map(Person::find()->where(['organization_id' => $model->id])->notDeleted()->orderBy(['email' => SORT_ASC])->all(), 'id', 'email'), ['prompt' => 'Please select...']) ?>

<div class="form-group">
    <?= Html::submitButton('<i class="bi bi-check-circle"></i> Save', ['class' => 'btn btn-success mt-3']) ?>
</div>

<?php ActiveForm::end(); ?>

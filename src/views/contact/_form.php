<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ser6io\yii2contacts\models\Contact;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Contact $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'type')->dropDownList(\ser6io\yii2contacts\models\Contact::TYPE) ?>    
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'sub_type')->dropDownList(\ser6io\yii2contacts\models\Contact::SUB_TYPE) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>    
        <div class="col-md-3">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'contact_id')->dropDownList(ArrayHelper::map(Contact::find()->where(['organization_id' => $model->id])->andWhere(['type' => 0])->notDeleted()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => 'Please select...']) ?>
        </div>    
        <div class="col-md-6">
            <?= $form->field($model, 'organization_id')->dropDownList(ArrayHelper::map(Contact::find()->where(['>', 'type', 0])->notDeleted()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['prompt' => 'Please select...']) ?>
        </div>
    </div>

    <?= $form->field($model, 'notes')->textarea(['style' => "height: 100px"]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="bi bi-check-circle"></i> Save', ['class' => 'btn btn-success mt-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use ser6io\yii2contacts\models\Organization;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Person $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'organization_id')->dropDownList(ArrayHelper::map(Organization::find()->notDeleted()->orderBy(['nickname' => SORT_ASC])->all(), 'id', 'nickname'), ['prompt' => 'Please select...']) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

<?php if ($model->isNewRecord): ?>
    <?= $form->field($model, 'create_system_user')->checkbox() ?>
<?php endif; ?>

<div class="form-group">
    <?= Html::submitButton('<i class="bi bi-check-circle"></i> Save', ['class' => 'btn btn-success mt-3']) ?>
</div>

<?php ActiveForm::end(); ?>

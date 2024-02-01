<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\ContactSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nickname') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'website') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'metadata') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'sub_type') ?>

    <?php // echo $form->field($model, 'organization_id') ?>

    <?php // echo $form->field($model, 'contact_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'isDeleted') ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

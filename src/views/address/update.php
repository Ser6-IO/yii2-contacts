<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Address $model */

$this->title = 'Update Address: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
if ($model->person_id != null){
    $this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['person/index']];
    $this->params['breadcrumbs'][] = ['label' => $model->person->name, 'url' => ['person/view', 'id' => $model->person_id]];
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['organization/index']];
    $this->params['breadcrumbs'][] = ['label' => $model->organization->nickname, 'url' => ['organization/view', 'id' => $model->organization_id]];
}

$this->params['breadcrumbs'][] = 'Update Address';
?>
<div class="address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

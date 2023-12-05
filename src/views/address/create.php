<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Address $model */

$this->title = 'Create Address';

$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['contact/index']];
$this->params['breadcrumbs'][] = ['label' => $model->contact->name, 'url' => ['contact/view', 'id' => $model->contact_id]];


$this->params['breadcrumbs'][] = $this->title;

?>
<div class="address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

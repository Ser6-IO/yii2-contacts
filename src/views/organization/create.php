<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Organization $model */

$this->title = 'Create Organization';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

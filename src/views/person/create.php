<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Person $model */

$this->title = 'Create Person';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

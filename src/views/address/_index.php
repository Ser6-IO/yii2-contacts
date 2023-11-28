<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ListView;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\AddressSearch;


$searchModel = new AddressSearch();

if ($idParam == 'o_id') {
    $searchModel->organization_id = $model->id;
    $url = ['organization/view', 'id' => $model->id];
} else {
    $searchModel->person_id = $model->id;
    $url = ['person/view', 'id' => $model->id];
}

$dataProvider = $searchModel->search($this->context->request->queryParams);
$dataProvider->sort = ['defaultOrder' => ['country' => SORT_ASC, 'state' => SORT_ASC, 'city' => SORT_ASC]];


?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => 'Addresses',
    'titleTag' => 'h4',
    'btnSize' => 'sm',
    'groups' => [
        [
            'buttons' => ['create'], 
            'visible' => Yii::$app->user->can('contacts'),
            'config' => [
                'create' => ['url' => ['address/create', $idParam => $model->id]]
            ]
        ],
        [
            'buttons' => ['show-deleted'], 
            'visible' => Yii::$app->user->can('admin'),
            'config' => [
                'show-deleted' => ['url' => $url]
            ]
        ],  
    ],
]) ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_address',
]) ?>

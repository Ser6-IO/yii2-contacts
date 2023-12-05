<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ListView;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\AddressSearch;


$searchModel = new AddressSearch();
$searchModel->contact_id = $contact->id;
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
                'create' => ['url' => ['address/create', 'contact_id' => $contact->id]]
            ]
        ],
        [
            'buttons' => ['show-deleted'], 
            'visible' => Yii::$app->user->can('admin'),
            'config' => [
                'show-deleted' => ['url' => ['contact/view', 'id' => $contact->id]]
            ]
        ],  
    ],
]) ?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_address',
]) ?>

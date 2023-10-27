<?php

use ser6io\yii2contacts\models\Address;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;


/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\AddressSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Addresses';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="hstack gap-2">
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'type',
            'format' => 'raw',
            'value' => function ($model) {
                $deleted = $model->isDeleted ? '<span class="badge text-bg-danger">Deleted</span>' : '';
                return "$deleted <span class='badge text-bg-secondary'>" . Address::ADDRESS_TYPE[$model->type] . "</span>";
            },
            'filter' => Address::ADDRESS_TYPE,
        ],
        [
            'attribute' => 'country',
            'format' => 'raw',
            'value' => function ($model) {
                return \ser6io\yii2contacts\models\Country::CODE_NAME[$model->country];
            },
            'filter' => \ser6io\yii2contacts\models\Country::CODE_NAME,
        ],
        'state',
        'city',
        [
            'label' => 'Contact',
            'format' => 'raw',
            'value' => function ($model) {
                if (isset($model->person_id))
                    return Html::a(
                        '<i class="bi bi-person"></i> ' . $model->person->email,
                        Url::to(['person/view', 'id' => $model->person_id]),
                        [
                            'title' => 'View Person',
                            'data-bs-toggle' => 'tooltip'
                        ]
                    );
                else
                    return Html::a(
                        '<i class="bi bi-building"></i> ' . $model->organization->nickname,
                        Url::to(['organization/view', 'id' => $model->organization_id]),
                        [
                            'title' => 'View Organization',
                            'data-bs-toggle' => 'tooltip'
                        ]
                    );
            },
        ],
        //'line_1',
        //'line_2',
        //'zip',
        //'created_at',
        //'updated_at',
    ],
]); ?>

<?= \ser6io\yii2bs5widgets\ShowDeletedWidget::widget() ?>
<?php

use ser6io\yii2contacts\models\Person;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\PersonSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'People';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => $this->title, 
    'groups' => [
        ['buttons' => ['create'], 'visible' => 'contactsAdmin'],
    ],
]) ?>

<?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'email',
            'format' => 'raw',
            'value' => function ($model) {
                $deleted = $model->isDeleted ? '<span class="badge text-bg-danger">Deleted</span>' : '';
                return Html::a(
                    "$deleted $model->email",
                    Url::to(['view', 'id' => $model->id]),
                    [
                        'title' => 'View Person',
                        'data-bs-toggle' => 'tooltip'
                    ]
                );
            },

        ],
        'name',
        //'phone',
        'mobile',
        //'notes:ntext',
        //'metadata',
        'organization.nickname:text:Organization',
        //'user_id',
        //'created_at',
        //'updated_at',
        //'created_by',
        //'updated_by',
    ],
]); ?>

<?php Pjax::end(); ?>

<?= \ser6io\yii2bs5widgets\ShowDeletedWidget::widget() ?>
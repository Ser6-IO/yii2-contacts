<?php

use ser6io\yii2contacts\models\Organization;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\OrganizationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organizations';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => $this->title, 
    'groups' => [
        ['buttons' => ['create'], 'visible' => 'contactsAdmin'],
    ],
]) ?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //'full_name',
        [
            'attribute' => 'nickname',
            'label' => 'Name',
            'format' => 'raw',
            'value' => function ($model) {
                $deleted = $model->isDeleted ? '<span class="badge text-bg-danger">Deleted</span>' : '';
                return Html::a(
                    "$deleted $model->nickname",
                    Url::to(['view', 'id' => $model->id]),
                    [
                        'title' => 'View Organization',
                        'data-bs-toggle' => 'tooltip'
                    ]
                ) . "<br><small>$model->full_name</small>";
            },

        ],
        [
            'attribute' => 'type',
            'format' => 'raw',
            'value' => function ($model) {
                return "<span class='badge text-bg-secondary'>" . Organization::ORGANIZATION_TYPE[$model->type] . "</span>";
            },
            'filter' => Organization::ORGANIZATION_TYPE,
        ],
        //'nickname',
        
        //'email:email',
        //'phone',
        //'notes:ntext',
        //'metadata',
        'designatedContact.email:text:Designated Contact',
        //'created_at',
        //'updated_at',
        //'created_by',
        //'updated_by',
    ],
]); ?>

<?= \ser6io\yii2bs5widgets\ShowDeletedWidget::widget() ?>
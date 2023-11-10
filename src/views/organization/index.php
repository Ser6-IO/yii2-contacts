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
    'rowOptions'=>function($model){ return $model->isDeleted ? ['class' => 'bg-danger-subtle'] : null;},
    'columns' => [
        //'full_name',
        [
            'attribute' => 'nickname',
            'label' => 'Name',
            'format' => 'raw',
            'value' => function ($model) {
                return "$model->nickname<br><small>$model->full_name</small>";
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
        [
            'attribute' => 'contact_id',
            'label' => 'Contact',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->contact_id ? $model->designatedContact->email . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/person/view', 'id' => $model->contact_id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']) : null;
            }
        ],
        //'nickname',
        
        //'email:email',
        //'phone',
        //'notes:ntext',
        //'metadata',
        //'created_at',
        //'updated_at',
        //'created_by',
        //'updated_by',
        [
            'class' => ActionColumn::className(),
            'template' => '{view}',
            'urlCreator' => function ($action, Organization $model, $key, $index, $column) {
                return Url::toRoute(["$action", 'id' => $model->id]);
             }
        ],
    ],
]); ?>

<?= \ser6io\yii2bs5widgets\ShowDeletedWidget::widget() ?>
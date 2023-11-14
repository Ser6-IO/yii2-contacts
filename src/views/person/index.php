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
    'rowOptions'=>function($model){ return $model->isDeleted ? ['class' => 'bg-danger-subtle'] : null;},
    'columns' => [
        'name',
        'email',
        //'phone',
        'mobile',
        //'notes:ntext',
        //'metadata',
        //'organization.nickname:text:Organization',
        [
            'attribute' => 'organization_id',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->organization) {
                    return $model->organization->nickname . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/organization/view', 'id' => $model->organization->id], ['title' => 'View Organization', 'data-bs-toggle' => 'tooltip']);
                } else {
                    return '';
                }
            },
        ],
        //'user_id',
        //'created_at',
        //'updated_at',
        //'created_by',
        //'updated_by',
        [
            'class' => ActionColumn::className(),
            'template' => '{view}',
            'urlCreator' => function ($action, Person $model, $key, $index, $column) {
                return Url::toRoute(["$action", 'id' => $model->id]);
             }
        ],
    ],
]); ?>

<?php Pjax::end(); ?>

<?= \ser6io\yii2bs5widgets\ShowDeletedWidget::widget() ?>
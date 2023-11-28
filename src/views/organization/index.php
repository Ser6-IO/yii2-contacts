<?php

use ser6io\yii2contacts\models\Organization;
use ser6io\yii2contacts\models\Person;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;
use yii\helpers\ArrayHelper;

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
        ['buttons' => ['create'], 'visible' => Yii::$app->user->can('contacts')],
        ['buttons' => ['show-deleted'], 'visible' => Yii::$app->user->can('admin')],  
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
            'filter' => ArrayHelper::map(Person::find()->select(['id', 'email'])->indexBy('email')->all(), 'id', 'email'),
            'value' => function ($model) {
                return $model->contact_id ? $model->designatedContact->email . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/person/view', 'id' => $model->contact_id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']) : null;
            }
        ],
        ['class' => ActionColumn::className()],
    ],
]); ?>
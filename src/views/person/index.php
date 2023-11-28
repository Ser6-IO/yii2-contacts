<?php

use ser6io\yii2contacts\models\Person;
use ser6io\yii2contacts\models\Organization;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;
use yii\helpers\ArrayHelper;
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
        'name',
        [
            'attribute' => 'email',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->user) {
                    $link = Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/admin/user/view', 'id' => $model->user->id], ['title' => 'View User', 'data-bs-toggle' => 'tooltip']);
                } else {
                    if (Yii::$app->user->can('agent')) {
                        $link =  Html::a('<i class="bi bi-person-add"></i>', ['/admin/user/create', 'email' => $model->email], ['title' => 'Create User', 'data-bs-toggle' => 'tooltip']);
                    } else {
                        $link = '';
                    }                    
                }
                return "$model->email $link";
            }
        ],
        //'phone',
        'mobile',
        [
            'attribute' => 'organization_id',
            'format' => 'raw',
            'filter' => ArrayHelper::map(Organization::find()->select(['id', 'nickname'])->indexBy('nickname')->all(), 'id', 'nickname'),
            'value' => function ($model) {
                if ($model->organization) {
                    return $model->organization->nickname . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/organization/view', 'id' => $model->organization->id], ['title' => 'View Organization', 'data-bs-toggle' => 'tooltip']);
                } else {
                    return '';
                }
            },
            'contentOptions' => function ($model, $key, $index, $column) {
                if (isset($model->organization))
                    return ['class' => $model->organization->isDeleted ? 'bg-danger-subtle' : ''];
                else
                    return ['class' => ''];
            },
        ],
        ['class' => ActionColumn::class],
    ],
]); ?>

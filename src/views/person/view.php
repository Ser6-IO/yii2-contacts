<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\DetailView;
use ser6io\yii2bs5widgets\ListView;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Person $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => $this->title, 
    'isDeleted' => $model->isDeleted,
    'groups' => [
        ['buttons' => ['update', 'delete'], 'visible' => 'contactsAdmin'],
    ],
    'id' => $model->id
]) ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'email:email',
        'phone',
        'mobile',
        'notes:ntext',
        'organization.nickname:text:Organization',
        [
            'attribute' => 'user',
            'label' => 'User Id',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->user ? Html::a($model->user->id, ['/admin/user/view', 'id' => $model->user->id]) : null;
            }
        ],
        [
            'attribute' => 'metadata',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->metadata) {
                    $metadata = array_filter($model->metadata);
                    $metadata = array_map(function ($value, $key) {
                        return Html::tag('div', Html::tag('strong', $key) . ': ' . $value);
                    }, $metadata, array_keys($metadata));
                    return implode('', $metadata);
                } else {
                    return null;
                }
            }
        ]
    ],
]) ?>

<?= \ser6io\yii2bs5widgets\CreatedByWidget::widget(['model' => $model]) ?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => 'Addresses',
    'titleTag' => 'h4',
    'groups' => [
        ['buttons' => ['create'], 'visible' => 'contactsAdmin'],
    ],
    'btnSize' => 'sm',
    'route' => 'address',
    'id' => $model->id,
    'idParam' => 'p_id',
]) ?>

<?= ListView::widget([
    'dataProvider' => $addressDataProvider,
    'itemView' => '../address/_address',
]) ?>

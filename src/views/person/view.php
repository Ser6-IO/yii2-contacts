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
        [
            'attribute' => 'organization_id',
            'label' => 'Organization',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->organization ? $model->organization->nickname . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/organization/view', 'id' => $model->organization->id], ['title' => 'View Organization', 'data-bs-toggle' => 'tooltip']) : null;
            }
        ],
        [
            'attribute' => 'user',
            'label' => 'User Id',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->user ? $model->user->id . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/admin/user/view', 'id' => $model->user->id], ['title' => 'View User', 'data-bs-toggle' => 'tooltip']) : null;
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
        ],
        'notes:ntext',
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

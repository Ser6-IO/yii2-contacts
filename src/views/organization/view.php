<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\DetailView;
use ser6io\yii2bs5widgets\ListView;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Organization $model */

$this->title = $model->nickname;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => $this->title, 
    'isDeleted' => $model->isDeleted,
    'groups' => [
        ['buttons' => ['update', 'delete'], 'visible' => 'contactsAdmin'],
    ],
    'id' => $model->id,
]) ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'full_name',
        //'type',
        'email:email',
        'phone',
        [
            'attribute' => 'contact_id',
            'label' => 'Designated Contact',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->contact_id ? $model->designatedContact->email . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/person/view', 'id' => $model->contact_id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']) : null;
            }
        ],
        'notes:ntext',
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
        [
            'attribute' => 'people',
            'format' => 'raw',
            'value' => function ($model) {
                $people = [];
                foreach ($model->contacts as $person) {
                    $people[] = $person->email . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/contacts/person/view', 'id' => $person->id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']);
                }
                return implode('<br>', $people);
            }
        ],
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
    'idParam' => 'o_id',
]) ?>

<?= ListView::widget([
    'dataProvider' => $addressDataProvider,
    'itemView' => '../address/_address',
]) ?>

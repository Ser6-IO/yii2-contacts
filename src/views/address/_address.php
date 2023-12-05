<?php
use yii\bootstrap5\Html;
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => '<span class="badge bg-light text-dark">' . $model::ADDRESS_TYPE[$model->type] . '</span>',
    'titleTag' => 'h4',
    'id' => $model->id,
    'btnSize' => 'sm',
    'isDeleted' => $model->isDeleted,
    'groups' => [
        [
            'buttons' => [
                'update', 
                'soft-delete'
            ],
            'visible' => Yii::$app->user->can('contacts'),
            'config' => [
                'update' => ['url' => ['address/update', 'id' => $model->id]],
                'soft-delete' => ['route' => 'address',]
            ],
        ],
        [
            'buttons' => ['restore'], 
            'visible' => Yii::$app->user->can('admin'),
            'config' => [
                'restore' => ['url' => ['/contacts/address/restore', 'id' => $model->id]],
            ],
        ],
    ],
]) ?>

<?= $model->line_1 ?><br>
<?= ($model->line_2 != null) ? "$model->line_2<br>" : ''?>
<?= $model->city ?>, <?= $model->state ?> <?= $model->zip ?><br>
<?= $model->country ?>
<hr>
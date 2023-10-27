<?php
use yii\bootstrap5\Html;
?>

<?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
    'title' => '<span class="badge bg-light text-dark">' . $model::ADDRESS_TYPE[$model->type] . '</span>',
    'titleTag' => 'h4',
    'groups' => [
        ['buttons' => ['update', 'delete'], 'visible' => 'contactsAdmin'],
    ],
    'id' => $model->id,
    'btnSize' => 'sm',
    'route' => 'address',
]) ?>

<?= $model->line_1 ?><br>
<?= ($model->line_2 != null) ? "$model->line_2<br>" : ''?>
<?= $model->city ?>, <?= $model->state ?> <?= $model->zip ?><br>
<?= $model->country ?>
<hr>
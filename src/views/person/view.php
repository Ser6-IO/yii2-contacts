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
    'id' => $model->id,
    'groups' => [
        ['buttons' => ['update', 'soft-delete'], 'visible' => Yii::$app->user->can('contacts')],
        ['buttons' => ['restore'], 'visible' => Yii::$app->user->can('admin')],
    ],
]) ?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
     //   'id',
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
        //List all User Accounts associated to this person
        [
            'attribute' => 'userAccounts',
            'label' => 'User Accounts',
            'format' => 'raw',
            'value' => function ($model) {
                $userAccounts = [];
                foreach ($model->userAccounts as $userAccount) {
                    $userAccounts[] = $userAccount->id . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/admin/user/view', 'id' => $userAccount->id], ['title' => 'View User', 'data-bs-toggle' => 'tooltip']);
                }
                return implode('<br>', $userAccounts);
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

<?= $this->render('../address/_index', ['model' => $model, 'idParam' => 'p_id']) ?>

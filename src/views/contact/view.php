<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\DetailView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Contact $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="contact-view">

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
        'rows' => [
            ['name'],
            [
                'nickname:text:Nickname:col-6', 
                [
                    'col-class' => 'col-3',
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $color = $model->type == 0 ? 'text-bg-primary' : 'text-bg-info';
                        return "<span class='badge $color'>" . $model::class::TYPE[$model->type] . "</span>";
                    },
                ],
                [
                    'col-class' => 'col-3',
                    'attribute' => 'sub_type',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return "<span class='badge text-bg-secondary'>" . $model::class::SUB_TYPE[$model->sub_type] . "</span>";
                    },
                ],    
            ],
            [
                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->user) {
                            $link = Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['/admin/user/view', 'id' => $model->user->id], ['title' => 'View User', 'data-bs-toggle' => 'tooltip']);
                        } else {
                            if (Yii::$app->user->can('agent') and $model->email) {
                                $link =  Html::a('<i class="bi bi-person-add"></i>', ['/admin/user/create', 'email' => $model->email], ['title' => 'Create User', 'data-bs-toggle' => 'tooltip']);
                            } else {
                                $link = '';
                            }                    
                        }
                        return "$model->email $link";
                    }
                ],
                'website', 'phone', 'mobile'
            ],
            [
                [
                    'attribute' => 'contact_id',
                    'label' => 'Designated Contact',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->contact_id ? $model->designatedContact->name . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['contact/view', 'id' => $model->contact_id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']) : null;
                    }
                ],
                [
                    'attribute' => 'organization_id',
                    'label' => 'Organization',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->organization ? $model->organization->name . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['contact/view', 'id' => $model->organization->id], ['title' => 'View Organization', 'data-bs-toggle' => 'tooltip']) : null;
                    }
                ],
            ],
            ['notes:ntext'],
            [
                [
                    'label' => 'Members',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $people = [];
                        foreach ($model->contacts as $person) {
                            $people[] = $person->name . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['contact/view', 'id' => $person->id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']);
                        }
                        return implode('<br>', $people);
                    }
                ],
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
            ],
            [
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
            ]  
        ],
    ]) ?>

    <?= \ser6io\yii2bs5widgets\CreatedByWidget::widget(['model' => $model]) ?>

    <?= $this->render('../address/_index', ['contact' => $model]) ?>

</div>


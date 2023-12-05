<?php

use ser6io\yii2contacts\models\Contact;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use ser6io\yii2bs5widgets\ActionColumn;
use ser6io\yii2bs5widgets\GridView;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\ContactSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contacts';
$this->params['breadcrumbs'][] = $this->title;

$people = \ser6io\yii2contacts\models\Contact::find()->where(['type' => 0])->notDeleted()->count();
$organizations = \ser6io\yii2contacts\models\Contact::find()->where(['>', 'type', 0])->notDeleted()->count();
$addresses = \ser6io\yii2contacts\models\Address::find()->notDeleted()->count();
?>

<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="hstack">
                    <a class="btn btn-sm btn-outline-success" href="<?= Url::to(['contact/create', 'type' => 0]) ?>" title="New" data-bs-toggle="tooltip"><i class="bi bi-plus-circle"></i></a>
                    &nbsp;
                    <a href="<?= Url::to(['contact/index', 'ContactSearch' => ['type' => 0]]) ?>" class="card-link text-decoration-none lead">People</a>                    
                    <p class="display-6 ms-auto mb-0"><span class="badge bg-primary"><?= $people ?></span></p>    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="hstack">
                    <a class="btn btn-sm btn-outline-success" href="<?= Url::to(['contact/create', 'type' => 1]) ?>" title="New" data-bs-toggle="tooltip"><i class="bi bi-plus-circle"></i></a>
                    &nbsp;
                    <a href="<?= Url::to(['contact/index', 'ContactSearch' => ['type' => 1]]) ?>" class="card-link text-decoration-none lead">Organizations</a>                    
                    <p class="display-6 ms-auto mb-0"><span class="badge bg-info"><?= $organizations ?></span></p>    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="hstack">
                    <p class="mb-0 lead">Addresses</p>                    
                    <p class="display-6 ms-auto mb-0"><span class="badge bg-light"><?= $addresses ?></span></p>    
                </div>
            </div>
        </div>
    </div>
</div>

<p>
    <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="false" aria-controls="collapseSearch">
    Advanced Search <i class="bi bi-search"></i>
    </button>
</p>

<div class="collapse mb-2" id="collapseSearch">
    <div class="card card-body">
        <div class="input-group">    
            <input type="text" class="form-control" placeholder="Search...">
            <button class="btn btn-outline-secondary"  title="Search" data-bs-toggle="tooltip" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>


<div class="contact-index">

    <?= \ser6io\yii2bs5widgets\ToolBarWidget::widget([
        'title' => $this->title, 
        'groups' => [
            ['buttons' => ['create'], 'visible' => Yii::$app->user->can('contacts')],
            ['buttons' => ['show-deleted'], 'visible' => Yii::$app->user->can('admin')],  
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){ return $model->isDeleted ? ['class' => 'bg-danger-subtle'] : null;},
        'columns' => [
            //'full_name',
            [
                'attribute' => 'name',
                'label' => 'Name',
                'format' => 'raw',
                'value' => function ($model) {
                    return "$model->nickname<br><small>$model->name</small>";
                },
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model) {
                    $color = $model->type == 0 ? 'bg-primary' : 'bg-info';
                    return "<span class='badge $color'>" . Contact::TYPE[$model->type] . "</span>";
                },
                'filter' => Contact::TYPE,
            ],
            [
                'attribute' => 'sub_type',
                'format' => 'raw',
                'value' => function ($model) {
                    return "<span class='badge text-bg-secondary'>" . Contact::SUB_TYPE[$model->sub_type] . "</span>";
                },
                'filter' => Contact::SUB_TYPE,
            ],
            [
                'attribute' => 'contact_id',
                'label' => 'Contact',
                'format' => 'raw',
                //'filter' => ArrayHelper::map(Contact::find()->select(['id', 'email'])->where(['organization_id' => $model->organization_id])->indexBy('email')->all(), 'id', 'email'),
                'value' => function ($model) {
                    return $model->contact_id ? $model->designatedContact->name . ' ' . Html::a('<i class="bi bi-box-arrow-up-right"></i>', ['contact/view', 'id' => $model->contact_id], ['title' => 'View Contact', 'data-bs-toggle' => 'tooltip']) : null;
                }
            ],
            ['class' => ActionColumn::className()],
        ],
    ]); ?>


</div>

<?php

namespace ser6io\yii2contacts\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\Organization;
use ser6io\yii2contacts\models\OrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrganizationController implements the CRUD actions for Organization model.
 */
class OrganizationController extends Controller
{
    public function actions()
    {
        return [
            'soft-delete' => [
                'class' => 'ser6io\yii2admin\components\SoftDeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Organization',
            ],
            'delete' => [
                'class' => 'ser6io\yii2admin\components\DeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Organization',
            ],
            'restore' => [
                'class' => 'ser6io\yii2admin\components\RestoreAction',
                'modelClass' => 'ser6io\yii2contacts\models\Organization',
            ],
        ];
    }

    /**
     * Lists all Organization models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['nickname'=>SORT_ASC]];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organization model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Organization();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organization::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

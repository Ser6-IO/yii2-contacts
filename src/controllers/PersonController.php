<?php

namespace ser6io\yii2contacts\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\Person;
use ser6io\yii2contacts\models\PersonSearch;
use ser6io\yii2admin\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
{ 
    public function actions()
    {
        return [
            'soft-delete' => [
                'class' => 'ser6io\yii2admin\components\SoftDeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Person',
            ],
            'delete' => [
                'class' => 'ser6io\yii2admin\components\DeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Person',
            ],
            'restore' => [
                'class' => 'ser6io\yii2admin\components\RestoreAction',
                'modelClass' => 'ser6io\yii2contacts\models\Person',
            ],
        ];
    }

    /**
     * Lists all Person models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['name' => SORT_ASC]];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Person();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if ($model->create_system_user) {
                    if (User::createSystemUser($model->email)) {
                        Yii::$app->session->addFlash('success', "User $model->email created successfully");
                    } else {
                        Yii::$app->session->addFlash('error', "Error creating user $model->email - Already exists?");
                    }
                } 
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
     * Updates an existing Person model.
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
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

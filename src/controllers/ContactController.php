<?php

namespace ser6io\yii2contacts\controllers;

use ser6io\yii2contacts\models\Contact;
use ser6io\yii2contacts\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    public function actions()
    {
        return [
            'soft-delete' => [
                'class' => 'ser6io\yii2admin\components\SoftDeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Contact',
            ],
            'delete' => [
                'class' => 'ser6io\yii2admin\components\DeleteAction',
                'modelClass' => 'ser6io\yii2contacts\models\Contact',
            ],
            'restore' => [
                'class' => 'ser6io\yii2admin\components\RestoreAction',
                'modelClass' => 'ser6io\yii2contacts\models\Contact',
            ],
        ];
    }

    /**
     * Lists all Contact models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['name'=>SORT_ASC]];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($type=0)
    {
        $model = new Contact();

        if ($this->request->isPost) {

            //$this->detachBehavior('slug') if nickname not empty??

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
            $model->type = $type;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
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
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

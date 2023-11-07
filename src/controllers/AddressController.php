<?php

namespace ser6io\yii2contacts\controllers;

use Yii;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\AddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends Controller
{
    public $layout = 'secondary';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [ 
                        [
                            'actions' => ['index', 'view', 'search-address-by-org-name'],
                            'allow' => true,
                            'roles' => ['contactsView'],
                        ],
                        [
                            'actions' => ['update', 'create', 'delete'],
                            'allow' => true,
                            'roles' => ['contactsAdmin'],
                        ],  
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Address models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AddressSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['country' => SORT_ASC, 'state' => SORT_ASC, 'city' => SORT_ASC]];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Returns a list off Addresses in JSON format, that match the search term.
     * 
     * @param string $term
     * @return json
     */
    public function actionSearchAddressByOrgName($name)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $addresses = Address::find()->joinWith('organization')->where(['like', 'organization.nickname', $name])->asArray()->all();
        return $addresses;
    }

    /**
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($p_id = null, $o_id = null)
    {
        $model = new Address();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if ($p_id) {
                    return $this->redirect(['/contacts/person/view', 'id' => $model->person_id]);
                } else {
                    return $this->redirect(['/contacts/organization/view', 'id' => $model->organization_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->person_id = $p_id;
            $model->organization_id = $o_id;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Address model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($model->person_id != null) {
                return $this->redirect(['person/view', 'id' => $model->person_id]);
            } else {
                return $this->redirect(['organization/view', 'id' => $model->organization_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->softDelete();
        if ($model->person_id != null) {
            return $this->redirect(['person/view', 'id' => $model->person_id]);
        } else {
            return $this->redirect(['organization/view', 'id' => $model->organization_id]);
        }
    }

    /**
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Address::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

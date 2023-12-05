<?php

namespace ser6io\yii2contacts\controllers;

use Yii;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\AddressSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AddressController implements the CRUD actions for Address model.
 */
class AddressController extends Controller
{
    /**
     * Returns a list off Addresses in JSON format, that match the search term.
     * 
     * @param string $term
     * @return json
     */
    public function actionSearchAddressByOrgName($name)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $addresses = Address::find()->joinWith('contact')->where(['like', 'contact.nickname', $name])->asArray()->all();
        return $addresses;
    }

    /**
     * Creates a new Address model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($contact_id = null)
    {
        $model = new Address();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->addFlash('success', 'New Address created.');
                return $this->redirect(['/contacts/contact/view', 'id' => $model->contact_id]);
            }
        } else {
            $model->loadDefaultValues();
            $model->contact_id = $contact_id;
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
            Yii::$app->session->addFlash('info', 'Address updated.');
            return $this->redirect(['/contacts/contact/view', 'id' => $model->contact_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Soft deletes an existing Address model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSoftDelete($id)
    {
        $model = $this->findModel($id);
        $model->softDelete();
        Yii::$app->session->addFlash('error', 'Address deleted.');
        return $this->redirect(['/contacts/contact/view', 'id' => $model->contact_id]);
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
        $model->delete();
        Yii::$app->session->addFlash('error', 'Address deleted permanently.');
        return $this->redirect(['/contacts/contact/view', 'id' => $model->contact_id]);
    }

    /**
     * Restores a soft deleted Address model.
     * If restoration is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRestore($id)
    {
        $model = $this->findModel($id);
        $model->restore();
        Yii::$app->session->addFlash('success', 'Address restored.');
        return $this->redirect(['/contacts/contact/view', 'id' => $model->contact_id]);
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

        throw new NotFoundHttpException('The requested address does not exist.');
    }
}

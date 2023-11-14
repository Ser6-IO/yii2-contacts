<?php

namespace ser6io\yii2contacts\controllers;

use yii\web\Controller;
use ser6io\yii2contacts\models\Person;
use ser6io\yii2contacts\models\Organization;
use ser6io\yii2contacts\models\Address;

/**
 * Main controller for the `Contacts` module
 */
class MainController extends Controller
{
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
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['contactsView'],
                        ],   
                    ],
                ],
            ]
        );
    }

    /**
     * Renders the index view for the Admin controller
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'people' => Person::find()->notDeleted()->count(),
            'organizations' => Organization::find()->notDeleted()->count(),
            'addresses' => Address::find()->notDeleted()->count(),
        ]);
    }
}

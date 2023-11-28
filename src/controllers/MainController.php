<?php

namespace ser6io\yii2contacts\controllers;

use yii\web\Controller;


/**
 * Main controller for the `Contacts` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the Admin controller
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

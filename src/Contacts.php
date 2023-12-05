<?php

namespace ser6io\yii2contacts;

use Yii;

/**
 * Admin module definition class
 */
class Contacts extends \yii\base\Module
{   
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'ser6io\yii2contacts\controllers';

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
                            'actions' => ['update', 'create', 'soft-delete'],
                            'allow' => true,
                            'roles' => ['contacts'],
                        ], 
                        [
                            'actions' => ['restore', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ]
                    ],
                ],
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->defaultRoute = 'contact/index';

        $this->layoutPath = '@app/views/layouts';

        $this->layout = 'secondary';

        //Secondary Menu items - must use two columns layout
        if (Yii::$app instanceof \yii\web\Application) {
            Yii::$app->params['secondaryMenu'] = [                
                ['label' => '<i class="bi bi-person-rolodex"></i> Contacts', 'url' => ['/contacts/contact/index'], 'visible' => Yii::$app->user->can('contactsView')],
                //['label' => '<i class="bi bi-person-lines-fill"></i> People', 'url' => ['/contacts/contact/index', 'ContactSearch' => ['type' => 0]], 'visible' => Yii::$app->user->can('contactsView')],
               // ['label' => '<i class="bi bi-building"></i> Organizations', 'url' => ['/contacts/contact/index', 'ContactSearch' => ['type' => 1]], 'visible' => Yii::$app->user->can('contactsView')],
               // ['label' => '<i class="bi bi-geo-alt"></i> Addresses', 'url' => ['/contacts/address/index'], 'visible' => Yii::$app->user->can('contactsView')],  
            ];
        }
    }

}

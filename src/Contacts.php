<?php

namespace ser6io\yii2contacts;

use Yii;

/**
 * Admin module definition class
 */
class Contacts extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public $initAction;
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'ser6io\yii2contacts\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->defaultRoute = 'people';

        $this->layoutPath = '@app/views/layouts';

        $this->layout = 'secondary';

        //Secondary Menu items - must use two columns layout
        if (Yii::$app instanceof \yii\web\Application) {
            Yii::$app->params['secondaryMenu'] = [                
                ['label' => '<i class="bi bi-person-rolodex"></i> Contacts', 'url' => ['/contacts/main/index'], 'visible' => Yii::$app->user->can('contactsView')],
                ['label' => '<i class="bi bi-person-lines-fill"></i> People', 'url' => ['/contacts/person/index'], 'visible' => Yii::$app->user->can('contactsView')],
                ['label' => '<i class="bi bi-building"></i> Organizations', 'url' => ['/contacts/organization/index'], 'visible' => Yii::$app->user->can('contactsView')],
                ['label' => '<i class="bi bi-geo-alt"></i> Addresses', 'url' => ['/contacts/address/index'], 'visible' => Yii::$app->user->can('contactsView')],  
            ];
        }
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'ser6io\yii2contacts\commands';
            $this->defaultRoute = 'init';
        }
    }
}

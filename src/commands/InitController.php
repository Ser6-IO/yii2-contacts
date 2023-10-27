<?php

namespace ser6io\yii2contacts\commands;

use yii\console\ExitCode;

/**
 * This command initializes the App's users.
 *
 */
class InitController extends \yii\console\Controller
{
    public function actionIndex()
    {
        echo "Not implemented\n";
        return ExitCode::OK;
    }

    /**
     * This command initializes RBAC for this Module
     */
    public function actionRbac()
    {
        $auth = \Yii::$app->authManager;

        //Delete 'contacts' role if it exists
        $contactsView = $auth->getRole('contactsView');
        if ($contactsView) {
            $auth->remove($contactsView);
        }
        $contactsView = $auth->createRole('contactsView');
        $contactsView->description = 'View Contacts module';
        $contactsView->data = ['color' => 'info'];

        $contactsAdmin = $auth->getRole('contacts');
        if ($contactsAdmin) {
            $auth->remove($contactsAdmin);
        }
        $contactsAdmin = $auth->createRole('contactsAdmin');
        $contactsAdmin->description = 'Admin Contacts module';
        $contactsAdmin->data = ['color' => 'warning'];

        $auth->add($contactsView);
        $auth->add($contactsAdmin);
        $auth->addChild($contactsAdmin, $contactsView);

        $admin = $auth->getRole('admin');
        if ($admin) {
            $auth->addChild($admin, $contactsAdmin);
        }

        return ExitCode::OK;
    }

}

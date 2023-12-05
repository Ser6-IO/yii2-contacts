<?php

namespace ser6io\yii2contacts\models;

/**
 * This is the ActiveQuery class for [[Contact]].
 *
 * @see Contact
 */
class ContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => \yii2tech\ar\softdelete\SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return Contact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Contact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

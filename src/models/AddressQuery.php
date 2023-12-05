<?php

namespace ser6io\yii2contacts\models;

/**
 * This is the ActiveQuery class for [[Address]].
 *
 * @see Address
 */
class AddressQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            'softDelete' => [
                'class' => \yii2tech\ar\softdelete\SoftDeleteQueryBehavior::class,
            ],
        ];
    }

    public function fromContact($contact_id)
    {
        return $this->andWhere(['contact_id' => $contact_id]);
    }

    /**
     * {@inheritdoc}
     * @return Address[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Address|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

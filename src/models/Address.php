<?php

namespace ser6io\yii2contacts\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int|null $contact_id
 * @property string $type
 * @property string $line_1
 * @property string|null $line_2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property int $created_at
 * @property int $updated_at
 */
class Address extends \yii\db\ActiveRecord
{
    const ADDRESS_TYPE = [
        0 => 'Main',
        1 => 'Branch',
        2 => 'Shipping',
        3 => 'Billing',
        99 => 'Other',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'contact_id', ], 'integer'],
            [['line_1', 'city', 'state', 'country'], 'required'],
            [['line_1', 'line_2', 'city', 'state', 'zip'], 'string', 'max' => 255],
            [['country'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            'blameableBehavior' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'defaultValue' => '1',
            ],
            'softDeleteBehavior' => [
                'class' => \yii2tech\ar\softdelete\SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
                //'replaceRegularDelete' => true
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contact_id' => 'Contact',
            'type' => 'Type',
            'line_1' => 'Line 1',
            'line_2' => 'Line 2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'country' => 'Country',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AddressQuery(get_called_class());
    }

    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }
}

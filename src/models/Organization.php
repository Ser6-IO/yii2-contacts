<?php

namespace ser6io\yii2contacts\models;

use Yii;
use ser6io\yii2admin\models\User;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $nickname
 * @property string $full_name
 * @property int $type
 * @property string|null $email
 * @property string|null $website
 * @property string|null $phone
 * @property string|null $notes
 * @property string|null $metadata
 * @property int|null $contact_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Organization extends \yii\db\ActiveRecord
{
    const ORGANIZATION_TYPE = [
        0 => 'Customer',
        1 => 'Vendor',
        2 => 'Partner',
        3 => 'Supplier',
        99 => 'Other',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
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
    public function rules()
    {
        return [
            [['nickname', 'full_name'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            [['nickname', 'full_name'], 'unique'],
            [['type', 'contact_id'], 'integer'],
            [['notes'], 'string'],
          //  [['metadata'], 'safe'],
            [['nickname', 'full_name', 'phone', 'website'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'full_name' => 'Full Name',
            'type' => 'Type',
            'email' => 'Email',
            'website' => 'Website',
            'phone' => 'Phone',
            'notes' => 'Notes',
            'metadata' => 'Metadata',
            'contact_id' => 'Contact ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrganizationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['organization_id' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getDesignatedContact()
    {
        return $this->hasOne(Person::class, ['id' => 'contact_id']);
    }

    public function getContacts()
    {
        return $this->hasMany(Person::class, ['organization_id' => 'id']);
    }

    public function beforeDelete()
    {    
        foreach ($this->addresses as $address) {
            $address->delete();
        } 
        return parent::beforeDelete();
      }
}

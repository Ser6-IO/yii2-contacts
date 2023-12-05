<?php

namespace ser6io\yii2contacts\models;

use Yii;
use ser6io\yii2admin\models\UserAdmin;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $nickname
 * @property string $name
 * @property string|null $website
 * @property string $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $notes
 * @property string|null $metadata
 * @property int $type
 * @property int $sub_type
 * @property int|null $organization_id
 * @property int|null $contact_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $isDeleted
 */
class Contact extends \yii\db\ActiveRecord
{
    const TYPE = [
        0 => 'Person',
        1 => 'Organization',
        2 => 'Group',
        3 => 'Other',
    ];
    
    const SUB_TYPE = [
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
        return 'contact';
    }

     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
            ],
            'blameableBehavior' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'defaultValue' => '1',
            ],
            'softDeleteBehavior' => [
                'class' => \yii2tech\ar\softdelete\SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],//'replaceRegularDelete' => true
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['notes'], 'string'],
            [['metadata'], 'safe'],
            [['type', 'sub_type', 'organization_id', 'contact_id'], 'integer'],
            [['nickname', 'name', 'website', 'email', 'phone', 'mobile'], 'string', 'max' => 255],
            [['email', 'nickname'], 'unique'],
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
            'name' => 'Name',
            'website' => 'Website',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'notes' => 'Notes',
            'metadata' => 'Metadata',
            'type' => 'Type',
            'sub_type' => 'Sub Type',
            'organization_id' => 'Parent Organization',
            'contact_id' => 'Contact',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'isDeleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['contact_id' => 'id']);
    }

    public function getDesignatedContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }

    public function getContacts()
    {
        return $this->hasMany(Contact::class, ['organization_id' => 'id']);
    }

    public function getOrganization()
    {
        return $this->hasOne(Contact::class, ['id' => 'organization_id']);
    }

    public function getUser()
    {
        return $this->hasOne(UserAdmin::class, ['username' => 'email']);
    }

    public function getUserAccounts()
    {
        return $this->hasMany(UserAdmin::class, ['email' => 'email']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(UserAdmin::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(UserAdmin::class, ['id' => 'updated_by']);
    }

    public function beforeDelete()
    {    
        foreach ($this->addresses as $address) {
            $address->delete();
        } 
        return parent::beforeDelete();
    }
}

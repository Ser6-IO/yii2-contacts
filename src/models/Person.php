<?php

namespace ser6io\yii2contacts\models;

use Yii;
use ser6io\yii2admin\models\UserAdmin;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $notes
 * @property string|null $metadata
 * @property int|null $organization_id
 * @property int|null $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Person extends \yii\db\ActiveRecord
{
    public $create_system_user = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
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
            [['name', 'email'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            [['email', 'mobile'], 'unique'],
            [['notes'], 'string'],
            [['organization_id', 'user_id'], 'integer'],
            [['name', 'phone', 'mobile'], 'string', 'max' => 255],
            ['create_system_user', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'notes' => 'Notes',
            'metadata' => 'Metadata',
            'organization_id' => 'Organization ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }

    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['person_id' => 'id']);
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(UserAdmin::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(UserAdmin::class, ['id' => 'updated_by']);
    }

    public function getUser()
    {
        return $this->hasOne(UserAdmin::class, ['username' => 'email']);
    }

    public function getUserAccounts()
    {
        return $this->hasMany(UserAdmin::class, ['email' => 'email']);
    }

    public function beforeDelete()
    {    
        foreach ($this->addresses as $address) {
            $address->delete();
        } 
        return parent::beforeDelete();
    }
}

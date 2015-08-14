<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $username
 * @property string $password
 * @property integer $isAdmin
 *
 * @property Site $site
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['site_id', 'isAdmin'], 'integer'],
            [['username'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'site_id' => 'Site ID',
            'username' => 'Username',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }

    public function beforeSave($insert)
    {
        $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->password = $hash;
        $this->isAdmin = 0;
        return parent::beforeSave($insert);
    }
}
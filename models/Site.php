<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property integer $id
 * @property string $lat
 * @property string $lng
 * @property string $name
 * @property string $taxId
 * @property string $isCooperative
 *
 * @property LocationHistory[] $locationHistories
 * @property User[] $users
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lat', 'lng', 'name', 'taxId', 'isCooperative'], 'required'],
            [['id'], 'integer'],
            [['isCooperative'], 'string'],
            [['lat', 'lng'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 255],
            [['taxId'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'name' => 'Name',
            'taxId' => 'Tax ID',
            'isCooperative' => 'Is Cooperative',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationHistories()
    {
        return $this->hasMany(LocationHistory::className(), ['site_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['site_id' => 'id']);
    }
}
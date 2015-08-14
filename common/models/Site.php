<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property integer $id
 * @property string $lat
 * @property string $lng
 * @property string $name
 * @property string $taxId
 * @property string $site_type
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
            [['name', 'taxId', 'address'], 'required'],
            [['id'], 'integer'],
            [['site_type'], 'string'],
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
            'site_type' => 'Is Cooperative',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationHistories()
    {
        return $this->hasMany(LocationHistory::className(), ['site_id' => 'id']);
    }

    public function getPackages()
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

    public function getMaterials()
    {
        return $this->hasMany(LocationHistory::className(), ['site_id' => 'id'])->with('package');
    }

    public function beforeSave($insert)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.$this->address.'';
        $file = file_get_contents($url);
        // $json = json_decode($file, true);
        $this->lat = 'dawdwa';
        die();
        return 'asawd';
        echo "string";
        die('sadaw');
        return parent::beforeSave($insert);
    }
}

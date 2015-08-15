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
    public $material = [];

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
            [['name', 'address'], 'required'],
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
            'site_type' => 'Site Type',
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
        return $this->hasMany(LocationHistory::className(), ['site_id' => 'id'])
            ->select('location_history.*')
            ->innerJoin('package')
            ->innerJoin('material');
    }

    public function beforeSave($insert)
    {
        $this->taxId = 20;
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($this->address);
        $file = file_get_contents($url);
        $json = json_decode($file, true);
        $this->lat = $json['results'][0]['geometry']['location']['lat'];
        $this->lng = $json['results'][0]['geometry']['location']['lng'];
        return parent::beforeSave($insert);
    }
}

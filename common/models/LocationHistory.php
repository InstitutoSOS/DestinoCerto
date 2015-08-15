<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "location_history".
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $timestamp
 *
 * @property Site $site
 * @property Package $id0
 */
class LocationHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'package_id'], 'required'],
            [['id', 'site_id'], 'integer'],
            [['timestamp'], 'safe']
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
            'package_id' => 'package ID',
            'timestamp' => 'Timestamp',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(Site::className(), ['id' => 'site_id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasMany(Package::className(), ['id' => 'package_id']);
    }
}

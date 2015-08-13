<?php

namespace app\models;

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
            [['id', 'site_id'], 'required'],
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
    public function getId0()
    {
        return $this->hasOne(Package::className(), ['id' => 'id']);
    }
}

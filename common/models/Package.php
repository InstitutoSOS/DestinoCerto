<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property string $barcode
 * @property integer $material_id
 * @property string $weight
 * @property string $label_created
 * @property string $package_created
 *
 * @property LocationHistory $locationHistory
 * @property Material $material
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['barcode', 'material_id', 'weight'], 'required'],
            [['material_id'], 'integer'],
            [['weight'], 'number'],
            [['label_created', 'package_created'], 'safe'],
            [['barcode'], 'string', 'max' => 36]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barcode' => 'Barcode',
            'material_id' => 'Material ID',
            'weight' => 'Weight',
            'label_created' => 'Label Created',
            'package_created' => 'Package Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationHistory()
    {
        return $this->hasOne(LocationHistory::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
}

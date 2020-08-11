<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exceptions".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $entity_type
 * @property string $from
 * @property string $to
 * @property int $is_open
 * @property string|null $reason
 */
class Exceptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exceptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity_id', 'entity_type', 'from', 'to', 'is_open'], 'required'],
            [['entity_id', 'is_open'], 'integer'],
            [['from', 'to'], 'safe'],
            [['reason'], 'string'],
            [['entity_type'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'entity_type' => 'Entity Type',
            'from' => 'From',
            'to' => 'To',
            'is_open' => 'Is Open',
            'reason' => 'Reason',
        ];
    }
}
